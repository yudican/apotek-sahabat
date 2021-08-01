<div class="page-inner">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-capitalize">
                        <a href="{{route('dashboard')}}">
                            <span><i class="fas fa-arrow-left mr-3 text-capitalize"></i>data obat</span>
                        </a>
                        <div class="pull-right">
                            @if (auth()->user()->hasTeamPermission($curteam, request()->segment(1).':create'))
                            @if (!$form && !$modal)
                            <button class="btn btn-danger btn-sm" wire:click="toggleForm(false)"><i
                                    class="fas fa-times"></i> Cancel</button>
                            @else
                            <button class="btn btn-primary btn-sm"
                                wire:click="{{$modal ? 'showModal' : 'toggleForm(true)'}}"><i class="fas fa-plus"></i>
                                Add
                                New</button>
                            @endif
                            @endif
                        </div>
                    </h4>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <livewire:table.data-obat-table />
        </div>

        {{-- Modal form --}}
        <div id="form-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-capitalize" id="my-modal-title">
                            {{$update_mode ? 'Update' : 'Tambah'}} data obat</h5>
                    </div>
                    <div class="modal-body">
                        <x-text-field type="text" name="obat_nama" label="Nama Obat" />
                        <x-text-field type="text" name="obat_merek" label="Merek" />
                        <x-text-field type="text" name="obat_dosis" label="Dosis" />
                        <x-text-field type="text" name="obat_kemasan" label="Kemasan" />
                        <x-text-field type="text" name="obat_indikasi" label="Indikasi" />
                        <x-textarea type="textarea" name="obat_catatan" label="Catatan" />

                        <x-select name="data_satuan_id" label="Satuan">
                            <option value="">Pilih Data Satuan</option>
                            @foreach ($data_satuan as $satuan)
                            <option value="{{$satuan->id}}">{{$satuan->data_satuan_nama}}</option>
                            @endforeach
                        </x-select>
                        <x-select name="data_jenis_id" label="Jenis">
                            <option value="">Pilih Data Jenis</option>
                            @foreach ($data_jenis as $jenis)
                            <option value="{{$jenis->id}}">{{$jenis->data_jenis_nama}}</option>
                            @endforeach
                        </x-select>
                        <x-select name="data_kategori_id" label="Kategori">
                            <option value="">Pilih Data Kategori</option>
                            @foreach ($data_kategori as $kategori)
                            <option value="{{$kategori->id}}">{{$kategori->data_kategori_nama}}</option>
                            @endforeach
                        </x-select>
                        <x-input-photo foto="{{$obat_gambar}}" path="{{optional($obat_gambar_path)->temporaryUrl()}}"
                            name="obat_gambar_path" label="Gambar Obat" />
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


        {{-- Modal confirm --}}
        <div id="confirm-modal" wire:ignore.self class="modal fade" tabindex="-1" permission="dialog"
            aria-labelledby="my-modal-title" aria-hidden="true">
            <div class="modal-dialog" permission="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="my-modal-title">Konfirmasi Hapus</h5>
                    </div>
                    <div class="modal-body">
                        <p>Apakah anda yakin hapus data ini.?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" wire:click='delete' class="btn btn-danger btn-sm"><i
                                class="fa fa-check pr-2"></i>Ya, Hapus</button>
                        <button class="btn btn-primary btn-sm" wire:click='_reset'><i
                                class="fa fa-times pr-2"></i>Batal</a>
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

            window.livewire.on('closeModal', (data) => {
                $('#confirm-modal').modal('hide')
                $('#form-modal').modal('hide')
            });
        })
    </script>
    @endpush
</div>