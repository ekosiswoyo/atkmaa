<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PT. BPR MANDIRI ARTHA ABADI') }}</title>

     <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css')}}">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="{{ asset('assets/modules/jqvmap/dist/jqvmap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/weather-icon/css/weather-icons-wind.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/summernote/summernote-bs4.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/jquery-selectric/selectric.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/datatables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/datatables/Select-1.2.4/css/select.bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/prism/prism.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/chocolat/dist/css/chocolat.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/modules/ionicons/css/ionicons.min.css')}}">


  <!-- Template CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css')}}">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto" action="/search" method="GET">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
            <li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>
          </ul>
          <div class="search-element">
            <input class="form-control" type="search" name="cari" placeholder="Cari Barang" aria-label="Search" data-width="250">
            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
            <div class="search-backdrop"></div>
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
        @php
           $cart = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('atk_carts.id_pics','=',Auth::user()->id_pics)->where('atk_carts.status','=','0')->get(); 
        @endphp
        @if(count($cart) > 0)
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="fas fa-shopping-cart"></i></a>
        @else
        <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle"><i class="fas fa-shopping-cart"></i></a>
        @endif
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


          @if(Auth::user()->id_pics == 1)  @php
              $notif = DB::table('atk_carts')
              ->join('atk_pics','atk_carts.id_pics','=','atk_pics.id_pics')
              ->select('*',DB::raw('DATE(atk_carts.created_at) as dates'))->where('atk_carts.status','=','1')->where('atk_carts.id_pics','!=','1')->groupBy('atk_carts.status','dates','atk_carts.id_pics')->get();
              @endphp
          @if(count($notif) > 0)
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
          @else
          <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg"><i class="far fa-bell"></i></a>
          @endif

            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Pemberitahuan
               
              </div>
            
              <div class="dropdown-list-content dropdown-list-icons">
            
              @foreach($notif as $notifs)
                <a href="/order/{{$notifs->status}}/{{$notifs->dates}}/{{$notifs->id_pics}}" class="dropdown-item">
                  <div class="dropdown-item-icon bg-info text-white">
                    <i class="fas fa-bell"></i>
                  </div>
                  <div class="dropdown-item-desc">
                    Permintaan dari <b>{{$notifs->nm_pic}}</b>
                    <div class="time">{{$notifs->dates}}</div>
                  </div>
                </a>
              @endforeach
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li>
          
          @endif
          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png')}}" class="rounded-circle mr-1">
            <div class="d-sm-none d-lg-inline-block">Hi, {{Auth::user()->name}} </div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <!-- <div class="dropdown-title">Logged in 5 min ago</div> -->
              <a href="/profile" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profil
              </a>
              <a href="/order-list" class="dropdown-item has-icon">
                <i class="fas fa-bolt"></i> Riwayat Pesanan
              </a>
              <div class="dropdown-divider"></div>
           


              <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt"></i> Keluar
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="/">BPR MAA</a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="/">MAA</a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="active"><a class="nav-link" href="/"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
           @if(Auth::user()->id_pics != 1)
           <li><a class="nav-link" href="/barangs"><i class="fas fa-plus-square"></i> <span>Pengajuan  </span></a></li>

           <li><a class="nav-link" href="/stockcab"><i class="fas fa-database"></i> <span>Stok ATK Cetak</span></a></li>
           <li><a class="nav-link" href="/atknoncetak"><i class="fas fa-database"></i> <span>Stok ATK Non Cetak</span></a></li>
           @endif
            @if(Auth::user()->id_pics == 1)
            <li class="menu-header">Data Master</li>
         
            <li><a class="nav-link" href="/satuan"><i class="fas fa-database"></i> <span>Data Satuan</span></a></li>
            <li><a class="nav-link" href="/barang"><i class="fas fa-database"></i> <span>Data Barang</span></a></li>
           
            <li class="menu-header">Data Transaksi</li>
            <li><a class="nav-link" href="/barangs"><i class="fas fa-plus-square"></i> <span>Pengajuan  </span></a></li>
           <li><a class="nav-link" href="/addstock"><i class="fas fa-plus-square"></i> <span>Tambah Stok Gudang</span></a></li>
           <li><a class="nav-link" href="/transaksiall"><i class="fas fa-dollar-sign"></i> <span>Daftar Transaksi</span></a></li>
           <li><a class="nav-link" href="/data"><i class="fas fa-database"></i> <span>Data Stok Cabang</span></a></li>
          
           <li class="menu-header">Laporan</li>
            <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-file-alt"></i> <span>Cetak Laporan</span></a>
              <ul class="dropdown-menu">
              <li><a class="nav-link" href="/lapbulstok">Cetak Laporan Bulanan</a></li>
              <li><a class="nav-link" href="/lappemakaian">Cetak Laporan Pemakaian</a></li>
              </ul>
            </li>
            @endif

           </aside>
      </div>

            @yield('content')
      <footer class="main-footer">
        <div class="footer-left">
          Copyright &copy; 2019 <div class="bullet"></div> Design By IT BPR MAA</a>
        </div>
        <div class="footer-right">
          
        </div>
      </footer>
    </div>
  </div>
  @yield('script')
    
  <!-- General JS Scripts -->
  <script src="{{ asset('assets/modules/jquery.min.js')}}"></script>
  <script src="{{ asset('assets/modules/popper.js')}}"></script>
  <script src="{{ asset('assets/modules/tooltip.js')}}"></script>
  <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js')}}"></script>
  <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js')}}"></script>
  <script src="{{ asset('assets/modules/moment.min.js')}}"></script>
  <script src="{{ asset('assets/js/stisla.js')}}"></script>
  
  <!-- JS Libraies -->
  <script src="{{ asset('assets/modules/simple-weather/jquery.simpleWeather.min.js')}}"></script>
  <script src="{{ asset('assets/modules/chart.min.js')}}"></script>
  <script src="{{ asset('assets/modules/jqvmap/dist/jquery.vmap.min.js')}}"></script>
  <script src="{{ asset('assets/modules/jqvmap/dist/maps/jquery.vmap.world.js')}}"></script>
  <script src="{{ asset('assets/modules/summernote/summernote-bs4.js')}}"></script>
  <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>
  <script src="{{ asset('assets/modules/cleave-js/dist/cleave.min.js')}}"></script>
  <script src="{{ asset('assets/modules/cleave-js/dist/addons/cleave-phone.us.js')}}"></script>
  <script src="{{ asset('assets/modules/jquery-pwstrength/jquery.pwstrength.min.js')}}"></script>
  <script src="{{ asset('assets/modules/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
  <script src="{{ asset('assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js')}}"></script>
  <script src="{{ asset('assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}"></script>
  <script src="{{ asset('assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js')}}"></script>
  <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js')}}"></script>
  <script src="{{ asset('assets/modules/jquery-selectric/jquery.selectric.min.js')}}"></script>
  <script src="{{ asset('assets/modules/datatables/datatables.min.js')}}"></script>
  <script src="{{ asset('assets/modules/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js')}}"></script>
  <script src="{{ asset('assets/modules/datatables/Select-1.2.4/js/dataTables.select.min.js')}}"></script>
  <script src="{{ asset('assets/modules/jquery-ui/jquery-ui.min.js')}}"></script>
  <script src="{{ asset('assets/modules/prism/prism.js')}}"></script>
  <script src="{{ asset('assets/modules/sweetalert/sweetalert.min.js')}}"></script>
  <script src="{{ asset('assets/modules/chocolat/dist/js/jquery.chocolat.min.js')}}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('assets/js/page/index-0.js')}}"></script>  
  <script src="{{ asset('assets/js/page/forms-advanced-forms.js')}}"></script>
  <script src="{{ asset('assets/js/page/modules-datatables.js')}}"></script>
  <script src="{{ asset('assets/js/page/bootstrap-modal.js')}}"></script>
  <script src="{{ asset('assets/js/page/modules-sweetalert.js')}}"></script>
  <script src="{{ asset('assets/js/page/modules-ion-icons.js')}}"></script>
  
  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js')}}"></script>
  <script src="{{ asset('assets/js/custom.js')}}"></script>
</body>
</html>