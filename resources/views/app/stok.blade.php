@extends('layouts.app')
<!-- @section('cart')
<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="fas fa-shopping-cart"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Keranjang Belanja
              </div>
              <div class="dropdown-list-content dropdown-list-message">
              @foreach($cart as $carts)
                <a href="#" class="dropdown-item dropdown-item-unread">
                @if($carts->foto != NULL)
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="{{asset('storage/lampiran/' . $carts->foto)}}" class="rounded-circle" style="width:40px;height:40px;">
                    <div class="is-online"></div>
                  </div>
                @else
                <div class="dropdown-item-avatar">
                    <img alt="image" src="{{asset('storage/lampiran/notfound.jpg')}}" class="rounded-circle" style="width:40px;height:40px;">
                    <div class="is-online"></div>
                  </div>
                @endif
                  <div class="dropdown-item-desc">
                    <b>{{$carts->nm_barang}}</b>
                    <p>{{$carts->jml}} {{$carts->nm_satuan}} </p>
                    
                  </div>
                </a>
              @endforeach
              </div>
              <div class="dropdown-footer text-center">
                <a href="/cart">Lihat Semua <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>


@endsection -->
@section('content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="card"  style="width:100%;">
          <div class="card-header">
            <h4>Silahkan pilih barang yang diinginkan </h4>
          </div>

          <div class="card-body">

            <div class="row">
            @foreach($barang as $querys)
              <div class="col-md-3">
                
                  <div class="card card-primary">
                  <input type="hidden" value="{{$querys->id_barang}}">
                    @if($querys->foto != NULL)
                    <center><div class="card-header">
                        <a href="/barangs/{{$querys->id_barang}}"><img src="{{asset('storage/lampiran/' . $querys->foto)}}" style="width:80%;height:80%;border-radius:15px;border:3px solid #E51414;"></a>

                    </div> </center>
                    @else
                    <center> <div class="card-header">
                    <a href="/barangs/{{$querys->id_barang}}"><img src="{{asset('storage/lampiran/notfound.jpg')}}" style="width:80%;height:80%;border-radius:15px;border:3px solid #E51414;"></a>

                    </div> </center>
                    @endif
                    
                    <center> <a href="/barangs/{{$querys->id_barang}}" style="text-decoration:none;font-family:arial;color:black;">{{$querys->nm_barang}}</a></center>
                  
                  </div>
                  
                </div>
                 @endforeach

  

                </div>
  {{$barang->links()}}              
          </div>
          
        </section>
      </div>
    
@endsection