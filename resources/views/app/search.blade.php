@extends('layouts.app')

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
                        <a href="/barangs/{{$querys->id_barang}}"><img src="{{asset('storage/lampiran/' . $querys->foto)}}" style="width:170px;height:170px;border-radius:15px;border:3px solid #E51414;"></a>
                        
                    </div> </center>
                    @else
                    <center> <div class="card-header">
                    <a href="/barangs/{{$querys->id_barang}}"><img src="{{asset('storage/lampiran/notfound.jpg')}}" style="width:170px;height:170px;border-radius:15px;border:3px solid #E51414;"></a>

                    </div> </center>
                    @endif
                    
                    <center> <a href="/barangs/{{$querys->id_barang}}" style="text-decoration:none;font-family:arial;color:black;">{{$querys->nm_barang}}</a><br>
                    <p>Stok Tersedia : {{$querys->jml}}</p></center>
                  
                  </div>
                  
                </div>
                 @endforeach

  

                </div>
  {{$barang->links()}}              
          </div>
          
        </section>
      </div>
    
@endsection