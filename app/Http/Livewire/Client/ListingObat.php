<?php

namespace App\Http\Livewire\Client;

use App\Models\DataObat;
use Livewire\Component;

class ListingObat extends Component
{
    public $obat;
    public $search;
    public function render()
    {
        $obat = DataObat::all();

        if ($this->search) {
            $obat = DataObat::where('obat_nama', 'LIKE', '%' . $this->search . '%')->get();
        }
        return view('livewire.client.listing-obat', [
            'items' => $obat,
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
