<?php

namespace App\Http\Livewire;

use App\Models\DataObat;
use App\Models\Transaksi;
use Livewire\Component;
use Symfony\Component\VarDumper\Cloner\Data;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard', [
            'obat' => DataObat::count(),
            'obat_masuk' => Transaksi::where('jenis_transaksi', 'obat masuk')->count(),
            'obat_keluar' => Transaksi::where('jenis_transaksi', 'obat keluar')->count(),
        ]);
    }
}
