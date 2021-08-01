<?php

namespace App\Http\Livewire\Transaksi;

use App\Models\Transaksi;
use Livewire\Component;

class LaporanTransaksi extends Component
{
    public $kode_transaksi;
    public $tanggal_transaksi;
    public $data_suplier_id;
    public $jumlah_stok;
    public $total_transaksi;
    public $transaksiDetails;
    public $suplier;
    public $jenis_transaksi = null;
    public $tanggal_transaksi_mulai = null;
    public $tanggal_transaksi_selesai = null;
    protected $listeners = ['getDataById', 'getId'];

    public function render()
    {
        return view('livewire.transaksi.laporan-transaksi');
    }

    public function getDataById($transaksi_id)
    {
        $transaksi = Transaksi::find($transaksi_id);
        $this->kode_transaksi = $transaksi->kode_transaksi;
        $this->tanggal_transaksi = date('d-m-Y H:i', strtotime($transaksi->tanggal_transaksi)) . ' WIB';
        $this->data_suplier_id = $transaksi->data_suplier_id;
        $this->jumlah_stok = $transaksi->jumlah_stok;
        $this->total_transaksi = $transaksi->total_transaksi;
        $this->suplier = $transaksi->suplier->suplier_nama;

        $this->transaksiDetails = $transaksi;
        $this->emit('showModalDetail');
    }

    public function setFilter()
    {
        $data = [
            'jenis_transaksi' => $this->jenis_transaksi,
            'tanggal_transaksi_mulai' => $this->tanggal_transaksi_mulai,
            'tanggal_transaksi_selesai' => $this->tanggal_transaksi_selesai,
        ];

        $this->emit('setFilter', $data);
    }

    public function resetFilter()
    {
        $data = [];

        $this->emit('setFilter', $data);
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->emit('refreshTable');
        $this->kode_transaksi = null;
        $this->tanggal_transaksi = null;
        $this->data_suplier_id = null;
        $this->jumlah_stok = null;
        $this->total_transaksi = null;
        $this->suplier = null;
        $this->transaksiDetails = null;
    }
}
