<?php

namespace App\Http\Livewire\Admin;

use App\Models\DataJenis;
use App\Models\DataKategori;
use App\Models\DataObat as ModelsDataObat;
use App\Models\DataSatuan;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;

class DataObat extends Component
{
    use WithFileUploads;
    public $data_obat_id;
    public $obat_nama;
    public $obat_merek;
    public $obat_dosis;
    public $obat_kemasan;
    public $obat_indikasi;
    public $obat_stok;
    public $obat_harga;
    public $obat_catatan;
    public $obat_gambar;
    public $data_satuan_id;
    public $data_jenis_id;
    public $data_kategori_id;
    public $obat_gambar_path;


    public $form_active = false;
    public $form = false;
    public $update_mode = false;
    public $modal = true;

    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.admin.data-obat', [
            'items' => ModelsDataObat::all(),
            'data_satuan' => DataSatuan::all(),
            'data_jenis' => DataJenis::all(),
            'data_kategori' => DataKategori::all(),
        ]);
    }

    public function store()
    {
        $this->_validate();
        $obat_gambar = $this->obat_gambar_path->store('upload', 'public');
        $data = [
            'obat_nama'  => $this->obat_nama,
            'obat_merek'  => $this->obat_merek,
            'obat_dosis'  => $this->obat_dosis,
            'obat_kemasan'  => $this->obat_kemasan,
            'obat_indikasi'  => $this->obat_indikasi,
            'obat_catatan'  => $this->obat_catatan,
            'obat_harga'  => $this->obat_harga,
            'obat_gambar'  => $obat_gambar,
            'data_satuan_id'  => $this->data_satuan_id,
            'data_jenis_id'  => $this->data_jenis_id,
            'data_kategori_id'  => $this->data_kategori_id
        ];

        ModelsDataObat::create($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Disimpan']);
    }

    public function update()
    {
        $this->_validate();

        $data = [
            'obat_nama'  => $this->obat_nama,
            'obat_merek'  => $this->obat_merek,
            'obat_dosis'  => $this->obat_dosis,
            'obat_kemasan'  => $this->obat_kemasan,
            'obat_indikasi'  => $this->obat_indikasi,
            'obat_catatan'  => $this->obat_catatan,
            'obat_harga'  => $this->obat_harga,
            'obat_gambar'  => $this->obat_gambar,
            'data_satuan_id'  => $this->data_satuan_id,
            'data_jenis_id'  => $this->data_jenis_id,
            'data_kategori_id'  => $this->data_kategori_id
        ];
        $row = ModelsDataObat::find($this->data_obat_id);


        if ($this->obat_gambar_path) {
            $obat_gambar = $this->obat_gambar_path->store('upload', 'public');
            $data = ['obat_gambar' => $obat_gambar];
            if (Storage::exists('public/' . $this->obat_gambar)) {
                Storage::delete('public/' . $this->obat_gambar);
            }
        }

        $row->update($data);

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Diupdate']);
    }

    public function delete()
    {
        ModelsDataObat::find($this->data_obat_id)->delete();

        $this->_reset();
        return $this->emit('showAlert', ['msg' => 'Data Berhasil Dihapus']);
    }

    public function _validate()
    {
        $rule = [
            'obat_nama'  => 'required',
            'obat_merek'  => 'required',
            'obat_dosis'  => 'required',
            'obat_kemasan'  => 'required',
            'obat_indikasi'  => 'required',
            'obat_harga'  => 'required|numeric',
            'obat_catatan'  => 'required',
            'data_satuan_id'  => 'required',
            'data_jenis_id'  => 'required',
            'data_kategori_id'  => 'required'
        ];

        if (!$this->update_mode) {
            $rule['obat_gambar_path'] = 'required|image';
        }

        return $this->validate($rule);
    }

    public function getDataById($data_obat_id)
    {
        $data_obat = ModelsDataObat::find($data_obat_id);
        $this->data_obat_id = $data_obat->id;
        $this->obat_nama = $data_obat->obat_nama;
        $this->obat_merek = $data_obat->obat_merek;
        $this->obat_dosis = $data_obat->obat_dosis;
        $this->obat_kemasan = $data_obat->obat_kemasan;
        $this->obat_indikasi = $data_obat->obat_indikasi;
        $this->obat_harga = $data_obat->obat_harga;
        $this->obat_catatan = $data_obat->obat_catatan;
        $this->obat_gambar = $data_obat->obat_gambar;
        $this->data_satuan_id = $data_obat->data_satuan_id;
        $this->data_jenis_id = $data_obat->data_jenis_id;
        $this->data_kategori_id = $data_obat->data_kategori_id;
        if ($this->form) {
            $this->form_active = true;
            $this->emit('loadForm');
        }
        if ($this->modal) {
            $this->emit('showModal');
        }
        $this->update_mode = true;
    }

    public function getId($data_obat_id)
    {
        $data_obat = ModelsDataObat::find($data_obat_id);
        $this->data_obat_id = $data_obat->id;
    }

    public function toggleForm($form)
    {
        $this->form_active = $form;
        $this->emit('loadForm');
    }

    public function showModal()
    {
        $this->_reset();
        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->data_obat_id = null;
        $this->obat_nama = null;
        $this->obat_merek = null;
        $this->obat_dosis = null;
        $this->obat_kemasan = null;
        $this->obat_indikasi = null;
        $this->obat_catatan = null;
        $this->obat_harga = null;
        $this->obat_gambar = null;
        $this->data_satuan_id = null;
        $this->data_jenis_id = null;
        $this->data_kategori_id = null;
        $this->form = false;
        $this->form_active = false;
        $this->update_mode = false;
        $this->modal = true;
    }
}
