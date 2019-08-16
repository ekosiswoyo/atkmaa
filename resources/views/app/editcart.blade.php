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
                    <form action="/datacart/update" method="POST" role="form">
                    
                    {{csrf_field()}}
                      <table class="table table-striped" id="table-1">
                        <thead>                                 
                            <th>
                              #
                            </th>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>Jumlah</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($cart as $datas)                                 
                          <tr>
                            <td>{{$datas->id_barang}}</td>
                            @if($datas->foto != NULL)
                            <td><img src="{{asset('storage/lampiran/' . $datas->foto)}}" style="width:70px;height:70px;border-radius:15px;border:3px solid #E51414;"></td>
                            @else
                            <td><img src="{{asset('storage/lampiran/notfound.jpg')}}" style="width:70px;height:70px;border-radius:15px;border:3px solid #E51414;"></td>
                            @endif
                            <td>{{$datas->nm_barang}}</td>
                            <td>
                            <div class="input-group mb-2">
                        <input type="hidden" class="form-control text-right" name="id_cart[]" value="{{$datas->id_cart}}">
                        <input type="text" class="form-control text-right" id="inlineFormInputGroup2" placeholder="Jumlah" name="jml[]" style="width:10px;" value="{{$datas->jml}}">
                        <div class="input-group-append">
                          <div class="input-group-text">{{$datas->nm_satuan}}</div>
                        </div>
                      </div>
                            </td>
                            <td>
                                <!-- <a href="/cart/{{$datas->id_cart}}/edit"><button type="button" class="btn btn-info">Edit</button></a> -->
                            <button class="btn btn-warning" onClick="deleteData('{{$datas->id_cart}}')"  data-id=" {{$datas->id_cart}}"  >Delete</button></td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table> 
                      
                     
                     
                                        <button type="submit" class="btn btn-primary">SIMPAN</button>&nbsp;
                      </form>
                      
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

