<?php

namespace App\Http\Livewire\Transaksi;

use App\Models\DataObat;
use App\Models\DataSuplier;
use App\Models\Transaksi;
use App\Models\TransaksiDetail;
use Livewire\Component;


class TransaksiKeluar extends Component
{

  public $transaksi_id;
  public $kode_transaksi;
  public $jenis_transaksi = 'obat keluar';
  public $tanggal_transaksi;
  public $jumlah_stok;
  public $total_transaksi;
  public $transaksiDetails;
  public $suplier;
  public $data_obat_id;
  public $jumlah;
  public $harga;
  public $inputs = [0];
  public $i;



  public $form_active = false;
  public $form = false;
  public $update_mode = false;
  public $modal = true;

  protected $listeners = ['getDataById', 'getId'];

  public function mount()
  {
    $this->kode_transaksi = $this->_getTransactionCode();
    $this->tanggal_transaksi = date('Y-m-d');
  }



  public function render()
  {
    return view('livewire.transaksi.transaksi-keluar', [
      'items' => Transaksi::all(),
      'obats' => DataObat::all(),
    ]);
  }

  public function store()
  {
    $this->_validate();
    $jumlah = 0;
    $total = 0;

    for ($i = 0; $i < count($this->inputs); $i++) {
      $jumlah += $this->jumlah[$i];
      $total += $this->jumlah[$i] * $this->harga[$i];
    }

    $data = [
      'kode_transaksi'  => $this->kode_transaksi,
      'jenis_transaksi'  => $this->jenis_transaksi,
      'jumlah_stok'  => $jumlah,
      'total_transaksi'  => $total,
      'tanggal_transaksi'  => date($this->tanggal_transaksi . ' H:i:s'),
      'user_id'  => auth()->user()->id
    ];

    Transaksi::create($data);

    for ($i = 0; $i < count($this->inputs); $i++) {
      $jumlah += $this->jumlah[$i];
      $total += $this->jumlah[$i] * $this->harga[$i];
      TransaksiDetail::create([
        'jumlah'  => -$this->jumlah[$i],
        'harga'  => $this->harga[$i],
        'subtotal'  => $this->jumlah[$i] * $this->harga[$i],
        'kode_transaksi_id'  => $this->kode_transaksi,
        'data_obat_id'  => $this->data_obat_id[$i],
      ]);
    }

    $this->_reset();
    return $this->emit('showAlert', ['msg' => 'Transaksi ' . $this->kode_transaksi . ' Berhasil Disimpan']);
  }


  public function delete()
  {
    Transaksi::find($this->transaksi_id)->delete();

    $this->_reset();
    return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
  }

  public function _validate()
  {
    $rule = [
      'jenis_transaksi'  => 'required',
      'tanggal_transaksi'  => 'required',
    ];

    $message = [];

    for ($i = 0; $i < count($this->inputs); $i++) {
      $rule['data_obat_id.' . $i] = 'required';
      $rule['jumlah.' . $i] = 'required';
      $rule['harga.' . $i] = 'required';

      $message['data_obat_id.' . $i . '.required'] = 'Wajib diisi';
      $message['jumlah.' . $i . '.required'] = 'Wajib diisi';
      $message['harga.' . $i . '.required'] = 'Wajib diisi';
    }

    return $this->validate($rule, $message);
  }

  public function getDataById($transaksi_id)
  {
    $transaksi = Transaksi::find($transaksi_id);
    $this->kode_transaksi = $transaksi->kode_transaksi;
    $this->tanggal_transaksi = date('d-m-Y H:i', strtotime($transaksi->tanggal_transaksi)) . ' WIB';
    $this->jumlah_stok = $transaksi->jumlah_stok;
    $this->total_transaksi = $transaksi->total_transaksi;
    $this->suplier = $transaksi->suplier->suplier_nama;

    $this->transaksiDetails = $transaksi;
    $this->emit('showModalDetail');
  }

  public function getId($transaksi_id)
  {
    $transaksi = Transaksi::find($transaksi_id);
    $this->transaksi_id = $transaksi->id;
  }

  public function toggleForm($form)
  {
    $this->form_active = $form;
    $this->emit('loadForm');
  }

  public function showModal()
  {
    $this->emit('showModal');
    $this->kode_transaksi = $this->_getTransactionCode();
  }

  public function add($i)
  {
    $i = $i + 1;
    $this->i = $i;
    array_push($this->inputs, $i);
  }

  public function remove($i)
  {
    unset($this->inputs[$i]);
  }

  public function _reset()
  {
    $this->emit('closeModal');
    $this->emit('refreshTable');
    $this->kode_transaksi = $this->_getTransactionCode();
    $this->transaksi_id = null;
    $this->kode_transaksi = null;
    $this->jenis_transaksi = null;
    $this->tanggal_transaksi = null;
    $this->data_obat_id = null;
    $this->jumlah = null;
    $this->harga = null;
    $this->inputs = [0];
    $this->i = null;
    $this->form = false;
    $this->form_active = false;
    $this->update_mode = false;
    $this->modal = true;
  }

  public function _getTransactionCode($label = 'INV', $prefix = '-')
  {
    $tanggal = date('dm') . substr(date('Y'), 2);
    $kode = '0001';

    $transaksi = Transaksi::where('jenis_transaksi', 'obat keluar')->latest()->first();
    if ($transaksi) {
      $kode_transaksi = explode($prefix, $transaksi->kode_transaksi);
      $bulan = substr($kode_transaksi[1], 2, -2);
      if (date('m') == $bulan) {
        $final_kode = $label . $prefix . $tanggal . $prefix;
        $kode_transaksi = $kode_transaksi[2] + 1;

        $final_kode = $final_kode . sprintf("%04s", $kode_transaksi);
        return $final_kode;
      }

      $final_kode = $label . $prefix . $tanggal . $prefix . $kode;
      return $final_kode;
    }

    $final_kode = $label . $prefix . $tanggal . $prefix . $kode;
    return $final_kode;
  }
}
