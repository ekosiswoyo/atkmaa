@extends('layouts.app')
<!-- @section('cart')
<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="fas fa-shopping-cart"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Keranjang Belanja
              </div>
              <div class="dropdown-list-content dropdown-list-message">
              @foreach($row as $carts)
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
        <section class="card" style="width:100%;">
          <div class="card-header">
            <h4>{{$barangs->nm_barang}}</h4>
          </div>

          <div class="card-body">

            <div class="row">
              <div class="col-md-3">
                
                  <div class="card card-primary">
                  <input type="hidden" value="">
                    @if($barangs->foto != NULL)
                    <div class="card-header">
                    <center> <div class="gallery gallery-md">
                      <div class="gallery-item" data-image="{{asset('storage/lampiran/' . $barangs->foto)}}" data-title="{{$barangs->foto}}" style="width:170px;height:170px;border-radius:15px;border:3px solid #E51414;"></div>
                    </div></center>
</div>
                    
                    @else
                    <div class="card-header">
                    <center><div class="gallery gallery-md">
                    <div class="gallery-item" data-image="{{asset('storage/lampiran/notfound.jpg')}}" data-title="{{$barangs->foto}}" style="width:170px;height:170px;border-radius:15px;border:3px solid #E51414;"></div>
                    </div></center>
</div>
                    
                    @endif
                    
                    <center><b><p></p></b></center>
                  
                  </div>

                  
                  
                </div>
                <div class="col-2">
                <form action="" method="post" role="form" >
                                        {{csrf_field()}}
                <div class="form-group">
                <label>Tambahkan Keranjang</label>
                      <div class="input-group mb-2">
                        <input type="hidden" class="form-control text-right" id="inlineFormInputGroup2" name="id_barang" value="{{$barangs->id_barang}}">
                        <input type="text" class="form-control text-right" id="inlineFormInputGroup2" placeholder="Jumlah" name="jml">
                        <div class="input-group-append">
                          <div class="input-group-text">{{$barangs->nm_satuan}}</div>
                        </div>
                      </div>
                    </div>
                    <div class="buttons">
                                        <button class="btn btn-primary">Tambahkan</button>
                                    </div>  
               </form>  
                </div>
                
                
                
              </div>



  

                </div>            
          </div>
          
        </section>
      </div>
    
@endsection