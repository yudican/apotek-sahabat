<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\DataObat;
use App\Models\ObatKeluar;
use App\Models\ObatMasuk;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class DataObatTable extends LivewireDatatable
{
    protected $listeners = ['refreshTable'];
    public $hideable = 'select';
    public $table_name = 'data_obat';
    public $hide = [];


    public function builder()
    {
        // dd(DataObat::query()->get());
        // dd(DataObat::withSum('obatMasuks', 'jumlah_masuk')->get());
        return DataObat::query();
    }

    public function columns()
    {
        $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
        return [
            Column::name('obat_nama')->label('Nama Obat')->width('20%')->searchable(),
            Column::name('obat_merek')->label('Merek')->searchable(),
            Column::name('obat_dosis')->label('Dosis')->searchable(),
            Column::name('obat_harga')->label('Harga Obat')->searchable(),
            Column::name('obat_kemasan')->label('Kemasan')->searchable(),
            Column::name('obat_indikasi')->label('Indikasi')->searchable(),
            Column::callback(['id', 'obat_stok'], function ($id, $obat_stok) {
                return $this->obatStok($id, $obat_stok);
            })->label('Stok')->searchable(),
            Column::name('obat_catatan')->label('Catatan')->searchable(),
            Column::name('dataSatuan.data_satuan_nama')->label('Satuan')->searchable(),
            Column::name('dataJenis.data_jenis_nama')->label('Jenis')->searchable(),
            Column::name('dataKategori.data_kategori_nama')->label('Kategori')->searchable(),
            Column::callback(['obat_gambar'], function ($image) {
                return view('livewire.components.photo', [
                    'image_url' => asset('storage/' . $image),
                ]);
            })->label(__('image')),

            Column::callback(['id'], function ($id) {
                return view('livewire.components.action-button', [
                    'id' => $id,
                    'segment' => request()->segment(1)
                ]);
            })->label(__('Aksi')),
        ];
    }


    public function getDataById($id)
    {
        $this->emit('getDataById', $id);
    }

    public function getId($id)
    {
        $this->emit('getId', $id);
    }

    public function refreshTable()
    {
        $this->emit('refreshLivewireDatatable');
    }

    public function obatStok($id, $obat_stok)
    {
        $total_masuk = 0;
        $transaksi_masuks = Transaksi::all();

        foreach ($transaksi_masuks as $masuk) {
            $total_masuk += $masuk->transaksiDetails()->where(['data_obat_id' => $id])->sum('jumlah');
        }


        return $total_masuk;
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
