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
                    <form action="/order/update" method="POST" role="form" >
                    
                    {{csrf_field()}}
                      <table class="table table-striped" id="table-1">
                        <thead>                                 
                            <th>
                              #
                            </th>
                            <th>Foto</th>
                            <th>Nama Barang</th>
                            <th>Jumlah Permintaan</th>
                            <th>Jumlah Di Konfirmasi</th>
                            <!-- <th>Aksi</th> -->
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($query as $datas)                                 
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
                            <div class="input-group mb-2">
                        <input type="hidden" class="form-control text-right" name="id_cart[]" value="{{$datas->id_cart}}">
                        <input type="hidden" class="form-control text-right" name="id_barang[]" value="{{$datas->id_barang}}">
                        <input type="hidden" class="form-control text-right" name="id_pics[]" value="{{ $datas->id_pics }}">
                        @if($id_barang != NULL)
                        @php
                          $id_barang++;
                        @endphp
                        <input type="hidden" class="form-control text-right" name="id_gudang_brg[]" value="{{ $id_barang }}">
                        @endif
                        <input type="text" class="form-control text-right" id="inlineFormInputGroup2" placeholder="Jumlah" name="jml[]" style="width:10px;" value="{{ $datas->jml }}">
                        <div class="input-group-append">
                          <div class="input-group-text">{{$datas->nm_satuan}}</div>
                        </div>
                      </div>
                            </td>
                            <!-- <td>
                            <button class="btn btn-warning" onClick="deleteData('{{$datas->id_cart}}')"  data-id=" {{$datas->id_cart}}"  >Delete</button></td> -->
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

