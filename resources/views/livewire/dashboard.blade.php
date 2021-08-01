<div class="page-inner">
    <div class="row">
        <div class="col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-warning bubble-shadow-small">
                                <i class="fas fa-heart"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Jumlah Obat</p>
                                <h4 class="card-title">{{$obat}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-success bubble-shadow-small">
                                <i class="fas fa-list"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Transaksi Obat Masuk</p>
                                <h4 class="card-title">{{$obat_masuk}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-stats card-round">
                <div class="card-body ">
                    <div class="row align-items-center">
                        <div class="col-icon">
                            <div class="icon-big text-center icon-danger bubble-shadow-small">
                                <i class="fas fa-list"></i>
                            </div>
                        </div>
                        <div class="col col-stats ml-3 ml-sm-0">
                            <div class="numbers">
                                <p class="card-category">Transaksi Obat Keluar</p>
                                <h4 class="card-title">{{$obat_keluar}}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body justify-content-center">
                    <img src="{{asset('assets/img/apotek-1.jpeg')}}" style="height: 50vh;objec-fit:cover;width:100%" />
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-stats card-round">
                <div class="card-body justify-content-center">
                    <img src="{{asset('assets/img/apotek-2.jpeg')}}" style="height: 50vh;objec-fit:cover;width:100%" />
                </div>
            </div>
        </div>
    </div>
</div>