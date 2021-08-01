<?php

namespace App\Http\Livewire\Table;

use App\Models\HideableColumn;
use App\Models\Transaksi;
use Mediconesystems\LivewireDatatables\BooleanColumn;
use Mediconesystems\LivewireDatatables\Column;
use Mediconesystems\LivewireDatatables\Http\Livewire\LivewireDatatable;

class TransaksiKeluarTable extends LivewireDatatable
{
  protected $listeners = ['refreshTable'];
  public $hideable = 'select';
  public $table_name = 'transaksi_keluar';
  public $hide = [];
  public $path = 'obat-keluar';


  public function builder()
  {
    return Transaksi::query()->where('jenis_transaksi', 'obat keluar');
  }

  public function columns()
  {
    $this->hide = HideableColumn::where(['table_name' => $this->table_name, 'user_id' => auth()->user()->id])->pluck('column_name')->toArray();
    $data_to_return = [
      Column::name('kode_transaksi')->label('Kode transaksi')->searchable(),
      Column::callback('total_transaksi', 'numberFormat')->label('Total transaksi')->searchable(),
      Column::name('jumlah_stok')->label('Stok')->searchable(),
      Column::callback('tanggal_transaksi', 'formatTanggal')->label('tanggal transaksi')->searchable(),
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
