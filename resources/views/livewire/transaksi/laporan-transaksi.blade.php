<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>Laporan Transaksi</span>
                        </a>
                    </h4>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <x-select name="jenis_transaksi" label="Jenis Transaksi">
                                <option value="">Pilih Jenis Transaksi</option>
                                <option value="obat masuk">Obat Masuk</option>
                                <option value="obat keluar">Obat Keluar</option>
                            </x-select>
                        </div>
                        <div class="col-md-4">
                            <x-text-field type="date" name="tanggal_transaksi_mulai" label="Tanggal Awal" />

                        </div>
                        <div class="col-md-4">
                            <x-text-field type="date" name="tanggal_transaksi_selesai"
                                min="{{$tanggal_transaksi_mulai}}" label="Tanggal Akhir" />
                        </div>
                    </div>
                    <div class="form-group mt-2">
                        <button class="btn btn-primary btn-sm" wire:click="setFilter">Filter</button>
                        <button class="btn btn-danger btn-sm" wire:click="resetFilter">Reset</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <livewire:table.laporan-table />
        </div>


        <div id="detail-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" id="my-modal-title">
                            Detail transaksi</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <x-text-field type="text" name="kode_transaksi" label="Kode transaksi" readonly />
                            </div>
                            <div class="col-md-4">
                                <x-text-field type="text" name="tanggal_transaksi" label="Tanggal transaksi" readonly />
                            </div>
                            <div class="col-md-4">
                                <x-text-field type="text" name="suplier" label="Suplier" readonly />
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table table-light">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="40%" class="p-0">Nama Obat</th>
                                                <th width="20%" class="p-0">Jumlah</th>
                                                <th width="20%" class="p-0">Harga</th>
                                                <th width="10%" class="p-0">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if ($transaksiDetails)
                                            @foreach ($transaksiDetails->transaksiDetails as $transaction)
                                            <tr>
                                                <td class="pl-4 pr-4">{{$transaction->dataObat->obat_nama}}</td>
                                                <td class="pl-4 pr-4">{{$transaction->jumlah}}</td>
                                                <td class="pl-4 pr-4">Rp.{{number_format($transaction->harga)}}</td>
                                                <td class="pl-4 pr-4">Rp.{{number_format($transaction->subtotal)}}
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr>
                                                <td class="pl-4 pr-4"><strong>Total Stok</strong></td>
                                                <td class="pl-4 pr-4"><strong>{{$jumlah_stok}}</strong></td>
                                                <td class="pl-4 pr-4"><strong>Total Harga</strong></td>
                                                <td class="pl-4 pr-4"><strong>Rp.
                                                        {{number_format($total_transaksi)}}</strong></td>
                                            </tr>
                                            @endif

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">

                        <button class="btn btn-danger btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Tutup</a>

                    </div>
                </div>
            </div>
        </div>

    </div>
    @push('scripts')


    <script>
        document.addEventListener('livewire:load', function(e) {
            window.livewire.on('showModalDetail', (data) => {
                $('#detail-modal').modal('show')
            });

            window.livewire.on('closeModal', (data) => {
                $('#detail-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>