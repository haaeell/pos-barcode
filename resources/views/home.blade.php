@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12 col-lg-6">
            <div class="card shadow eq-card mb-4">
                <div class="card-body mb-n3">
                    <div class="row items-align-baseline align-items-center text-center h-100">
                        <div class="col-md-6 my-3">
                            <i class="fe fe-shopping-cart text-dark mb-3"  style="font-size: 70px"></i>
                            <h5 class="mt-4">Total Transaksi Hari Ini</h5>
                        </div>
                        <div class="col-md-6 my-4 text-center">
                            <h2 class="font-weight-bold" style="font-size: 50px">
                                32
                            </h2>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
        <div class="col-md-12 col-lg-6">
            <div class="card shadow eq-card mb-4">
                <div class="card-body mb-n3">
                    <div class="row items-align-baseline align-items-center text-center h-100">
                        <div class="col-md-6 my-3">
                            <i class="fe fe-dollar-sign mb-3 text-dark"  style="font-size: 70px"></i>
                            <h5 class="mt-4">Total Pendapatan Hari Ini</h5>
                        </div>
                        <div class="col-md-6 my-4 text-center">
                            <h2 class="font-weight-bold" style="font-size: 30px">
                                Rp. 1.205.000
                            </h2>
                        </div>
                    </div>
                </div> 
            </div> 
        </div> 
     
    </div>
    <div class="mb-2 align-items-center">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row mt-1 align-items-center">
                    <div class="col-12 col-lg-4 text-left pl-4">
                        <p class="mb-1 small text-muted">Balance</p>
                        <span class="h3">$12,600</span>
                        <span class="small text-muted">+20%</span>
                        <span class="fe fe-arrow-up text-success fe-12"></span>
                        <p class="text-muted mt-2"> Etiam ultricies nisi vel augue. Curabitur
                            ullamcorper ultricies nisi. Nam eget dui </p>
                    </div>
                    <div class="col-6 col-lg-2 text-center py-4">
                        <p class="mb-1 small text-muted">Today</p>
                        <span class="h3">$2600</span><br />
                        <span class="small text-muted">+20%</span>
                        <span class="fe fe-arrow-up text-success fe-12"></span>
                    </div>
                    <div class="col-6 col-lg-2 text-center py-4 mb-2">
                        <p class="mb-1 small text-muted">Goal Value</p>
                        <span class="h3">$260</span><br />
                        <span class="small text-muted">+6%</span>
                        <span class="fe fe-arrow-up text-success fe-12"></span>
                    </div>
                    <div class="col-6 col-lg-2 text-center py-4">
                        <p class="mb-1 small text-muted">Completions</p>
                        <span class="h3">26</span><br />
                        <span class="small text-muted">+20%</span>
                        <span class="fe fe-arrow-up text-success fe-12"></span>
                    </div>
                    <div class="col-6 col-lg-2 text-center py-4">
                        <p class="mb-1 small text-muted">Conversion</p>
                        <span class="h3">6%</span><br />
                        <span class="small text-muted">-2%</span>
                        <span class="fe fe-arrow-down text-danger fe-12"></span>
                    </div>
                </div>
                <div class="chartbox mr-4">
                    <div id="areaChart"></div>
                </div>
            </div> <!-- .card-body -->
        </div> <!-- .card -->
    </div>
@endsection
