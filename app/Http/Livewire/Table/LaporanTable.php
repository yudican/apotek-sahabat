<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\Transaksi;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class LaporanTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable', 'setFilter'];
    public $hideable = 'select';
    public $table_name = 'transaksi_keluar';
    public $hide = [];
    public $path = 'obat-keluar';
    public $filter = [];


    public function builder()
    {
        if (count($this->filter) > 0) {


            if ($this->filter['jenis_transaksi'] && $this->filter['tanggal_transaksi_mulai'] && $this->filter['tanggal_transaksi_selesai']) {
                return Transaksi::query()->where(['jenis_transaksi' => $this->filter['jenis_transaksi']])->whereBetween('tanggal_transaksi', [$this->filter['tanggal_transaksi_mulai'], $this->filter['tanggal_transaksi_selesai']])->orderBy('tanggal_transaksi', 'DESC');
            }

            if (!$this->filter['jenis_transaksi'] && $this->filter['tanggal_transaksi_mulai'] && $this->filter['tanggal_transaksi_selesai']) {
                return Transaksi::query()->whereBetween('tanggal_transaksi', [$this->filter['tanggal_transaksi_mulai'], $this->filter['tanggal_transaksi_selesai']])->orderBy('tanggal_transaksi', 'DESC');
            }

            if ($this->filter['jenis_transaksi'] && $this->filter['tanggal_transaksi_mulai']) {
                return Transaksi::query()->where(['jenis_transaksi' => $this->filter['jenis_transaksi']])->whereDate('tanggal_transaksi', date('Y-m-d', strtotime($this->filter['tanggal_transaksi_mulai'])))->orderBy('tanggal_transaksi', 'DESC');
            }

            if ($this->filter['jenis_transaksi']) {
                return Transaksi::query()->where(['jenis_transaksi' => $this->filter['jenis_transaksi']])->orderBy('tanggal_transaksi', 'DESC');
            }
        }
        return Transaksi::query()->orderBy('tanggal_transaksi', 'DESC');
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        $data_to_return = [
            Column::name('kode_transaksi')->label('Kode transaksi')->searchable(),
            Column::callback('total_transaksi', 'numberFormat')->label('Total transaksi')->searchable(),
            Column::name('jumlah_stok')->label('Stok')->searchable(),
            Column::callback('tanggal_transaksi', 'formatTanggal')->label('tanggal transaksi')->searchable(),
            Column::name('suplier.suplier_nama')->label('Suplier')->searchable(),
            Column::callback(['jenis_transaksi'], function ($jenis_transaksi) {
                return view('livewire.components.button-label', [
                    'status' => $jenis_transaksi == 'obat masuk',
                ]);
            })->label(__('Jenis Transaksi')),
            // Column::name('user.name')->label('Kasir')->searchable(),

            Column::callback(['kode_transaksi'], function ($kode_transaksi) {
                return view('livewire.components.transaction-detail', [
                    'id' => $kode_transaksi,
                    'segment' => $this->path
                ]);
            })->label(__('Aksi')),
        ];

        return $data_to_return;
    }

    public function getDataById($id)
    {
        $this->emit('getDataById', $id);
    }

    public function getId($id)
    {
        $this->emit('getDataById', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }

    public function numberFormat($number)
    {
        return 'Rp. ' . number_format($number);
    }

    public function formatTanggal($tanggal)
    {
        return date('d-m-Y H:i', strtotime($tanggal)) . ' WIB';
    }

    public function setFilter($data)
    {
        $this->filter = $data;
    }

    public function toggle($index)
    {
        if ($this->sort == $index) {
            $this->initialiseSort();
        }

        $column = HideableColumn::where([
            'table_name' => $this->table_name,
            'column_name' => $this->columns[$index]['name'],
            'index' => $index,
            'user_id' => auth()->user()->id
        ])->first();

        if (!$this->columns[$index]['hidden']) {
            unset($this->activeSelectFilters[$index]);
        }

        $this->columns[$index]['hidden'] = !$this->columns[$index]['hidden'];

        if (!$column) {
            HideableColumn::updateOrCreate([
                'table_name' => $this->table_name,
                'column_name' => $this->columns[$index]['name'],
                'index' => $index,
                'user_id' => auth()->user()->id
            ]);
        } else {
            $column->delete();
        }
    }
}
