<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="text-center">SELAMAT DATANG DI APOTEK SAHABAT</h1>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body row">
                    {{-- Kolom PENCARIAN --}}
                    <div class="col-md-3">
                        <x-select name="category_id" placeholder="Pilih Kategori">
                            <option value="">Pilih Kategori</option>
                            @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->data_kategori_nama}}</option>
                            @endforeach
                        </x-select>
                    </div>
                    <div class="col-md-9">
                        <x-text-field name="search" placeholder="Cari Obat" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @if (count($items))
                        @foreach ($items as $item)
                        <div class="col-lg-2 col-md-2 col-sm-4 col-6" wire:click="showDetail('{{$item->id}}')">
                            <div class="card p-0" style="height: 210px">
                                <div class="card-body p-0">
                                    @if ($item->transaksiDetails()->sum('jumlah') > 0)
                                    <label class="imagecheck mb-1">
                                        <figure class="imagecheck-figure">
                                            <img src="{{asset('storage/'.$item->obat_gambar)}}" height="150" alt="title"
                                                class="imagecheck-image w-100">
                                        </figure>
                                        <span class="badge badge-success absolute">Tersedia</span>
                                    </label>
                                    @else
                                    <label class="imagecheck mb-1 cursor-default">
                                        <figure class="imagecheck-figure">
                                            <img src="{{asset('storage/'.$item->obat_gambar)}}" height="150" alt="title"
                                                class="imagecheck-image w-100">
                                        </figure>
                                        <span class="badge badge-danger absolute">Habis</span>
                                    </label>
                                    @endif

                                </div>
                                <p class="pl-3 pr-3 mb-0">
                                    {{$item->obat_nama}}
                                </p>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="col-md-12 text-center pt-4 pb-4">
                            <h3>Obat Tidak Tersedia</h3>
                        </div>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal form --}}
    <div id="detail-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
        aria-labelledby="my-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" permission="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize" id="my-modal-title">Detail Obat</h5>
                </div>
                <div class="modal-body">
                    @if ($obat)
                    <table class="table table-light">
                        <tbody>
                            <tr>
                                <td width="30%">Nama Obat</td>
                                <td>: {{$obat->obat_nama}}</td>
                            </tr>
                            <tr>
                                <td width="30%">Jenis Obat</td>
                                <td>: {{$obat->dataJenis->data_jenis_nama}}</td>
                            </tr>
                            <tr>
                                <td width="30%">Kategori Obat</td>
                                <td>: {{$obat->dataKategori->data_kategori_nama}}</td>
                            </tr>
                            <tr>
                                <td width="30%">Merek Obat</td>
                                <td>: {{$obat->obat_merek}}</td>
                            </tr>
                            <tr>
                                <td width="30%">Dosis</td>
                                <td>: {{$obat->obat_dosis}}</td>
                            </tr>
                            <tr>
                                <td width="30%">Indikasi</td>
                                <td>: {{$obat->obat_indikasi}}</td>
                            </tr>
                            <tr>
                                <td width="30%">Catatan</td>
                                <td>: {{$obat->obat_indikasi}}</td>
                            </tr>
                            <tr>
                                <td width="30%">Stok</td>
                                <td>: {{$obat->transaksiDetails()->sum('jumlah')}}</td>
                            </tr>
                        </tbody>
                    </table>
                    @endif
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger btn-sm" wire:click='_reset'><i class="fa fa-times pr-2"></i>Tutup</a>

                </div>
            </div>
        </div>
    </div>


    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function(e) {
                window.livewire.on('showModal', (data) => {
                    $('#detail-modal').modal('show')
                });
    
                window.livewire.on('closeModal', (data) => {
                    $('#detail-modal').modal('hide')
                });
            })
    </script>
    @endpush
</div>