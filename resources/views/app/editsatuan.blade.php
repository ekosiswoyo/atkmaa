@extends('layouts.app')

@section('content')

      <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Satuan</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Data Master</a></div>
                    <div class="breadcrumb-item">Data Satuan</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Data Satuan</h2>
                    <p class="section-lead">Silahkan Edit Nama Satuan yang nantinya digunakan untuk satuan barang.</p>

                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Edit Data</h4>
                                    </div>
                                    <form action="/satuan/{{$satuans->id_satuan}}" method="post" role="form">
                                        {{csrf_field()}}
                                    <div class="card-body">
                                        <div class="form-group">    
                                            <label>ID Satuan</label>
                                            <input type="text" class="form-control" placeholder="Masukkan ID Satuan" name="id_satuan" value="{{$satuans->id_satuan}}" readonly>
                                        </div>

                                        <div class="form-group">    
                                        <label>Nama Satuan</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Satuan" name="nm_satuan" value="{{$satuans->nm_satuan}}" required>
                                        </div>
                                    </div>
                                    <div class="buttons">
                                        <button class="btn btn-primary">Save</button>
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="col-8">
                <div class="card">
                  <div class="card-header">
                    <h4>Data Satuan</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>                                 
                          <tr>
                            <th >
                              #
                            </th>
                            <th>Nama Satuan</th>
                            <th>Tanggal</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($satuan as $datas)                                 
                          <tr>
                            <td>{{$datas->id_satuan}}</td>
                            <td>{{$datas->nm_satuan}}</td>
                            <td>{{date('d-m-Y', strtotime($datas->created_at))}}</td>
                            <td><a href="/satuan/{{$datas->id_satuan}}/edit"><button type="button" class="btn btn-info">Edit</button></a>
                            <button class="btn btn-warning" onClick="deleteData('{{$datas->id_satuan}}')"  data-id=" {{$datas->id_satuan}}"  >Delete</button></td>
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
                        url : "{{ url('/satuan/destroy') }}" + '/' + id,
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

