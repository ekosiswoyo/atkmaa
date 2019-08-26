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
        <section class="section">
          

          <div class="card"  style="width:100%;">
                  <div class="card-header">
                    <h4>Data Keranjang Belanja</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>                                 
                            <th>
                            Tanggal Transaksi
                            </th>
                            
                            <th>Status</th>
                            <!-- <th>Konfirmasi</th> -->
                            <!-- <th>Aksi</th> -->
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($query as $datas)                                 
                          <tr>
                            
                            <td>{{$datas->dates}}</td>
                            @if($datas->status == '1')
                            <td><div class="badge badge-warning">Pesanan di Proses</div></td>
                            @elseif($datas->status == '2')
                            <td><div class="badge badge-danger">Pesanan Siap di Ambil / di Kirim</div></td>
                            @elseif($datas->status == '3')
                            <td><div class="badge badge-info">Pesanan Selesai!</div></td>
                            
                            @endif
                            @if($datas->status == '2')
                            <td> <form action="/confirmsorder" method="post" role="form">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-primary">PESANAN DITERIMA</button>
                  
                      </form></td>
                      @endif
                            <!-- <td><a href="/order-list/{{$datas->dates}}"><button type="button" class="btn btn-danger">Detail</button></a>
                            </td> -->
                          </tr>
                        @endforeach
                        </tbody>
                      </table> 
                     
                      
                      
<!--                      
                      <form action="/confirms" method="post" role="form">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-primary">KONFIRMASI KERANJANG</button>&nbsp;
                      <a href="/datacart"><button type="button" class="btn btn-warning">EDIT KERANJANG</button></a>
                      </form> -->
                      
                    </div>
                  </div>
                </div>
        </section>
      </div>
    
@endsection


@section('script')
<script>
        $.ajaxSetup({
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function deleteData(id){
          var csrf_token = $('meta[name="csrf-token"]').attr('content');
            swal({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this imaginary file!",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
            .then((willDelete) => {
                if (willDelete) {
                    $.ajax({
                        url : "{{ url('/cart/destroy') }}" + '/' + id,
                        type : "POST",
                        data : {
                          '_method' : 'DELETE', 
                          '_token' : csrf_token},
                        success: function(){
                            swal({
                                title: "Success!",
                                text : "Post has been deleted \n Click OK to refresh the page",
                                icon : "success",
                            })
                                window.location.reload(); 
                        },
                        error : function(){
                            swal({
                                title: 'Opps...',
                                text : data.message,
                                type : 'error',
                                timer : '1500'
                            })
                        }
                    })
                } else {
                swal("Your imaginary file is safe!");
                }
            });
        }
    </script>
@endsection

