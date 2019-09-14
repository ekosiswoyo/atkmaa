@extends('layouts.app')

@section('content')

      <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
                    <div class="breadcrumb-item">Data Transaksi</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Data Transaksi Pemakaian Cabang</h2>
                    <!-- <p class="section-lead">Silahkan Masukkan Detail Nama Barang dan Satuannya yang nantinya digunakan untuk data barang.</p> -->

                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                <form action="/usecab/{{$data->id_gudang_brg}}" method="post" role="form">
                                        {{csrf_field()}}
                                    <div class="row">
                                     
                                    <div class="col-6">
                                        <div class="card">
                                        <div class="form-group">    
                                            <label>Kode Barang</label>
                                            <input type="hidden" class="form-control" name="id_gudang_brg"  value="{{$data->id_gudang_brg}}" >
                                            <input type="text" class="form-control" name="kd_barang"  value="{{$data->id_barang}}"  readonly>
                                        </div>
                                        
                                        
                                        </div>  
                                    </div>
                                    <!-- <div class="col-3">
                                        <div class="card">
                                        <div class="form-group">    
                                            <label>Kode Gudang Cabang</label>
                                            <input type="text" class="form-control" name="kd_barangcab" value="{{$id_barang}}" readonly>
                                        </div>
                                        </div>
                                        
                                    </div> -->
                                    
                                    
                                    <div class="col-3">
                                        <div class="card">
                                        <div class="form-group">    
                                        <label>Keterangan Pemakaian</label>
                                        <textarea class="form-control" name="keterangan" required></textarea>
                                       
                                        </div>
                                        </div>
                                        
                                    </div>
                                    <div class="col-6">
                                        <div class="card">
                                        <div class="form-group">    
                                            <label>Jumlah Stok Tersedia</label>
                                            <input type="text" class="form-control" name="jmllama"  value="{{$data->jml}}"  readonly>
                                        </div>
                                        </div>
                                        
                                    </div>
                                    
                                    <div class="col-6">
                                        <div class="card">
                                        <div class="form-group">    
                                            <label>Jumlah Stok Keluar</label>
                                            <input type="text" class="form-control" placeholder="Jumlah Stok Keluar" name="jmlkeluar"  >
                                        </div>
                                        </div>
                                        
                                    </div>

                                    <div class="buttons">
                                        <button class="btn btn-primary">Simpan</button>
                                    </div>
</div>
</form>
<div class="row">

                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4>Data Transaksi Stok Gudang</h4>
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
                                                        <th>PIC</th>
                                                        <th>Jumlah</th>
                                                        <th>Harga</th>
                                                        <th>Buffer Min</th>
                                                        <th>Buffer Max</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach ($all as $datas)                                 
                                                    <tr>
                                                        <td>{{$datas->id_gudang_brg}}</td>
                                                        <td>{{$datas->nm_barang}}</td>
                                                        <td>{{$datas->pic}}</td>
                                                        <td>{{$datas->jml}}</td>
                                                        <td>{{$datas->harga}}</td>
                                                        <td>{{$datas->min_cab}}</td>
                                                        <td>{{$datas->max_cab}}</td>
                                                        
                                                        <td><a href="/trans/{{$datas->id_gudang_brg}}/edit"><button type="button" class="btn btn-info">STOK MASUK</button></a></td>
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
                            
                        </div>   
                        
                        
                        
                        </div>
           
            </div>
        </section>
    </div>
@endsection

@section('script')
<script type="text/javascript"> 
    $(document).ready(function(){

        $('#id_barang').on('change', function(e){
            var id = e.target.value;
            $.get("{{ url('/trans')}}"+ '/' + id, 
                function(data){
                console.log(id);
                console.log(data);
                
                $.each(data, function(index, element){
                    
                    $('#pic').value = element.pic;
                    // $('#pic').append(element.pic);
                });
            });
        });
    });
</script>
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
                        url : "{{ url('/gudang/destroy') }}" + '/' + id,
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

