@extends('layouts.app')

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
                            <td>{{$datas->jml}} {{$datas->nm_satuan}}</td>
                            <td>
                            <button class="btn btn-warning" onClick="deleteData('{{$datas->id_cart}}')"  data-id=" {{$datas->id_cart}}"  >Delete</button></td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table> 
                      
                     
                      <form action="/confirms" method="post" role="form">
                                        {{csrf_field()}}
                                        <button type="submit" class="btn btn-primary">KONFIRMASI KERANJANG</button>&nbsp;
                      <a href="/datacart"><button type="button" class="btn btn-warning">EDIT KERANJANG</button></a>
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

