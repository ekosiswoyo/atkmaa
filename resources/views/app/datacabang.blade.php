@extends('layouts.app')

@section('content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          

          <div class="card"  style="width:100%;">
                  <div class="card-header">
                    <h4>Data Barang {{$pics->nm_pic}}</h4>
                  </div>
                  <div class="card-body">
                <div class="row">
                  <div class="form-group col-md-6">
                    <select class="form-control select2" name="id_satuan" onchange="location = this.value;">
                    <option> -- PILIH CABANG / BAGIAN --</option>
                      <option value="/data">ALL</option>
                       @foreach($datapics as $pic)
                      <option value="/data/{{$pic->id_pics}}">{{$pic->nm_pic}}</option>
                      @endforeach
                    </select>
                  </div>

                  <div class="form-group col-md-6">
                  <a href="/data/print/{{$pics->id_pics}}"><button type="submit" class="btn btn-info">PRINT DATA</button></a>&nbsp;<a href="/datas/prints"><button type="submit" class="btn btn-light">PRINT DATA ALL</button></a>
                  </div>
                  
                </div>


                    <div class="table-responsive">
                    <table class="table table-striped" id="table-1">
                                                    <thead>                                 
                                                    <tr>
                                                        <th >
                                                        #
                                                        </th>
                                                        <th>Nama Barang</th>
                                                        <th>Foto</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        <th>Buffer Min</th>
                                                        <th>Buffer Max</th>
                                                        <!-- <th>Action</th> -->
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($data as $datas)                                 
                                                    <tr>
                                                        <td>{{$datas->id_barang}}</td>
                                                        <td>{{$datas->nm_barang}}</td>
                                                        @if($datas->foto != NULL)
                                                            <td><img src="{{asset('storage/lampiran/' . $datas->foto)}}" style="width:70px;height:70px;border-radius:15px;border:3px solid #E51414;"></td>
                                                            @else
                                                            <td><img src="{{asset('storage/lampiran/notfound.jpg')}}" style="width:70px;height:70px;border-radius:15px;border:3px solid #E51414;"></td>
                                                            @endif
                                                        <td>{{$datas->jml}}</td>
                                                        <td>Rp {{ number_format($datas->harga, 0) }}</td>
                                                        <td>{{$datas->min_cab}}</td>
                                                        <td>{{$datas->max_cab}}</td>
                                                        
                                                        <!-- <td><a href="/cabang/{{$datas->id_gudang_brg}}/use"><button type="button" class="btn btn-warning">PEMAKAIAN</button></a></td> -->
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

