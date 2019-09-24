@extends('layouts.app')

@section('content')
      <div class="main-content">
        <section class="card"  style="width:100%;">
          <div class="card-header"> 
            <h4>Sistem Informasi Layanan ATK</h4>
          </div>
          <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                  <i class="fas fa-box-open"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Total Data Barang</h4>
                  </div>
                  <div class="card-body">
                  @php
                    $totaldatabarang = DB::table('atk_barangs')->count();
                  @endphp
                   {{$totaldatabarang}}
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                  <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>News</h4>
                  </div>
                  <div class="card-body">
                    42
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Reports</h4>
                  </div>
                  <div class="card-body">
                    1,201
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Online Users</h4>
                  </div>
                  <div class="card-body">
                    47
                  </div>
                </div>
              </div>
            </div>                  
          </div>
          <div class="card-header"> 
            <h4>Silhkan pilih barang yang diinginkan</h4>
          </div>
          <div class="card-body">

            <div class="row">
            @foreach($barang as $querys)
              <div class="col-md-3">
                
                  <div class="card card-primary">
                  <input type="hidden" value="{{$querys->id_barang}}">
                    @if($querys->foto != NULL)
                    <center><div class="card-header">
                        <a href="/barangs/{{$querys->id_barang}}"><img src="{{asset('storage/lampiran/' . $querys->foto)}}" style="width:170px;height:170px;border-radius:15px;border:3px solid #E51414;"></a>

                    </div> </center>
                    @else
                    <center> <div class="card-header">
                    <a href="/barangs/{{$querys->id_barang}}"><img src="{{asset('storage/lampiran/notfound.jpg')}}" style="width:170px;height:170px;border-radius:15px;border:3px solid #E51414;"></a>

                    </div> </center>
                    @endif
                    
                    <center> <a href="/barangs/{{$querys->id_barang}}" style="text-decoration:none;font-family:arial;color:black;">{{$querys->nm_barang}}</a> 
                    <p>Stok Tersedia : {{$querys->jml}}</p></center>
                  
                  </div>
                  
                </div>
                 @endforeach

  
                
                </div>          
                <a href="/barangs"><button type="button" class="btn btn-info">LIHAT SEMUA BARANG</button></a>
          </div>
         
        </section>
      </div>
@endsection
