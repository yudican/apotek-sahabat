<div class="page-inner">
    @push('styles')
    <style>
        .table td {
            font-size: 14px;
            border-top-width: 0px;
            border-bottom: 1px solid;
            border-color: #ebedf2 !important;
            padding: 0 0 !important;
            height: 60px;
            vertical-align: middle !important;
        }
    </style>
    @endpush
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>transaksi obat masuk</span>
                        </a>
                        <div class="pull-right">
                            @if (auth()->user()->hasTeamPermission($curteam, request()->segment(1).':create'))
                            @if (!$form && !$modal)
                            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i
                                    class="fas fa-times"></i> Cancel</button>
                            @else
                            <button class="btn btn-primary btn-sm"
                                wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i class="fas fa-plus"></i>
                                Tambah Transaksi</button>
                            @endif
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <livewire:table.transaksi-masuk-table />
        </div>

        {{-- Modal form --}}
        <div id="form-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog modal-lg" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" id="my-modal-title">
                            {{$update_mode ? 'Update' : 'Tambah'}} transaksi</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <x-text-field type="text" name="kode_transaksi" label="Kode transaksi" readonly />
                            </div>
                            <div class="col-md-4">
                                <x-text-field type="date" name="tanggal_transaksi" label="Tanggal transaksi" />
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <table class="table table-light">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="40%" class="p-0">Pilih Obat</th>
                                                <th width="20%" class="p-0">Jumlah</th>
                                                <th width="20%" class="p-0">Harga</th>
                                                <th width="10%" class="p-0"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @for ($index = 0; $index < count($inputs); $index++) <tr>
                                                <td class="p-0">
                                                    <x-select name="data_obat_id.{{$index}}">
                                                        <option value="">Pilih Obat</option>
                                                        @foreach ($obats as $obat)
                                                        <option value="{{$obat->id}}">{{$obat->obat_nama}}
                                                        </option>
                                                        @endforeach
                                                    </x-select>
                                                </td>
                                                <td class="p-0">
                                                    <x-text-field type="number" name="jumlah.{{$index}}" />
                                                </td>
                                                <td class="p-0">
                                                    <x-text-field type="number" name="harga.{{$index}}" />
                                                </td>
                                                <td class="p-0">
                                                    @if ($index > 0)
                                                    <button class="btn btn-danger btn-sm"><i class="fas fa-times"
                                                            wire:click="remove({{$index}})"></i></button>
                                                    @else
                                                    <button class="btn btn-success btn-sm"><i class="fas fa-plus"
                                                            wire:click="add({{$index}})"></i></button>
                                                    @endif
                                                </td>
                                                </tr>
                                                @endfor
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="modal-footer">

                        <button type="button" wire:click={{$update_mode ? 'update' : 'store'}}
                            class="btn btn-primary btn-sm"><i class="fa fa-check pr-2"></i>Simpan</button>

                        <button class="btn btn-danger btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Batal</a>

                    </div>
                </div>
            </div>
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
                                                <td class="pl-4 pr-4">Rp.{{number_format($transaction->subtotal)}}</td>
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
            window.livewire.on('showModal', (data) => {
                $('#form-modal').modal('show')
            });
            window.livewire.on('showModalDetail', (data) => {
                $('#detail-modal').modal('show')
            });

            window.livewire.on('closeModal', (data) => {
                $('#detail-modal').modal('hide')
                $('#form-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>