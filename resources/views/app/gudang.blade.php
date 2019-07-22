@extends('layouts.app')

@section('content')

      <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Barang</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Data Master</a></div>
                    <div class="breadcrumb-item">Data Gudang</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Data Gudang</h2>
                    <!-- <p class="section-lead">Silahkan Masukkan Detail Nama Barang dan Satuannya yang nantinya digunakan untuk data barang.</p> -->

                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Input Data</h4>
                                    </div>
                                    <form action="" method="post" role="form">
                                        {{csrf_field()}}
                                    <div class="card-body">
                                        <div class="form-group">    
                                            <label>ID</label>
                                            <input type="text" class="form-control" placeholder="Masukkan ID" name="id_gudang_brg" value="{{$id_gudang_brg}}" readonly>
                                        </div>

                                        <div class="form-group">
                                        <label>Nama Barang</label>
                                        <select class="form-control select2" name="id_barang">
                                        <option> -- PILIH SATUAN --</option>
                                            @foreach($barang as $barangs)
                                            <option value="{{$barangs->id_barang}}">{{$barangs->id_barang}} ( {{$barangs->nm_barang}} )</option>
                                            @endforeach
                                        </select>
                                        </div>

                                        <div class="form-group">    
                                        <label>PIC</label>
                                        <input type="text" class="form-control" placeholder="Masukkan PIC" name="pic" required>
                                        </div>

                                        <div class="form-group">    
                                        <label>Jumlah Barang</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Jumlah Barang" name="jml" required>
                                        </div>

                                        <div class="form-group">    
                                        <label>Harga Barang</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Harga Barang" name="harga" required>
                                        </div>

                                        <div class="form-group">    
                                        <label>Buffer MIN</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Buffer MIN" name="min" required>
                                        </div>


                                        <div class="form-group">    
                                        <label>Buffer MAX</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Buffer MAX" name="max" required>
                                        </div>

                                        

                                    </div>
                                    <div class="buttons">
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-8">
                <div class="card">
                  <div class="card-header">
                    <h4>Data Barang di Gudang</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>                                 
                          <tr>
                            <th >
                              #
                            </th>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $datas)                                 
                          <tr>
                            <td>{{$datas->id_gudang_brg}}</td>
                            <td>{{$datas->id_barang}}</td>
                            <td>{{$datas->pic}}</td>
                            <td><a href="/barang/{{$datas->id_barang}}/edit"><button type="button" class="btn btn-info">Edit</button></a>
                            <button class="btn btn-warning" onClick="deleteData('{{$datas->id_barang}}')"  data-id=" {{$datas->id_barang}}"  >Delete</button></td>
                          </tr>
                        @endforeach
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
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
                        url : "{{ url('/barang/destroy') }}" + '/' + id,
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

