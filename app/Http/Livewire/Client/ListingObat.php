<?php

namespace App\Http\Livewire\Client;

use App\Models\DataKategori;
use App\Models\DataObat;
use Livewire\Component;

class ListingObat extends Component
{
    public $obat;
    public $search;
    public $category_id;
    public function render()
    {
        $obat = DataObat::all();

        if ($this->search) {
            if ($this->category_id) {
                $obat = DataObat::where('data_kategori_id', $this->category_id)->where('obat_nama', 'LIKE', '%' . $this->search . '%')->get();
            } else {
                $obat = DataObat::where('obat_nama', 'LIKE', '%' . $this->search . '%')->get();
            }
        }
        return view('livewire.client.listing-obat', [
            'items' => $obat,
            'categories' => DataKategori::all()
        ])->layout('layouts.user');
    }

    public function showDetail($obat_id)
    {
        $this->obat = DataObat::find($obat_id);

        $this->emit('showModal');
    }

    public function _reset()
    {
        $this->emit('closeModal');
        $this->obat = null;
    }
}
