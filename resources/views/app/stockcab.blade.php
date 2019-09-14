@extends('layouts.app')

@section('content')

      <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
                    <div class="breadcrumb-item">Data Stok Cabang</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Data Stok</h2>
                    <!-- <p class="section-lead">Silahkan Masukkan Detail Nama Barang dan Satuannya yang nantinya digunakan untuk data barang.</p> -->

                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                
                                        <div class="row">
                                        
                                        <div class="col-12">
                                            <div class="card">
                                                <div class="card-header">
                                                    <h4>Data Stok Gudang</h4>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                    <form action="" method="POST" role="form" >
                        
                                                    {{csrf_field()}}
                                                    <table class="table table-striped" id="table-1">
                                                        <thead>                                 
                                                        <tr>
                                                            <th >
                                                            #
                                                            </th>
                                                            <th>Nama Barang</th>
                                                            <th>Foto</th>
                                                            <th>Stok Gudang</th>
                                                            <th>Harga</th>
                                                            <th>Buffer Min</th>
                                                            <th>Buffer Max</th>
                                                            <th>Keterangan</th>
                                                            <th>Action</th>
                                                            <!-- <th>Action</th> -->
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($sql as $datas)                                 
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
                                                            <td>{{$datas->min_cab}} </td>
                                                            <td>{{$datas->max_cab}}</td>
                                                            @if($datas->jml <= $datas->min_cab)
                                                            <td><a href="#" class="btn btn-icon btn-warning" title="Stok Kurang Dari Buffer"><i class="fas fa-exclamation-triangle"></i></a></td>
                                                            @elseif($datas->jml >= $datas->max_cab)
                                                            <td> <a href="#" class="btn btn-icon btn-danger" title="Stok Lebih Dari Buffer"><i class="fas fa-times"></i></a></td>
                                                            @else
                                                            <td><a href="#" class="btn btn-icon btn-info" title="Stok Tersedia"><i class="fas fa-check"></i></a></td>
                                                            @endif
                                                            <td><a href="/cabang/{{$datas->id_gudang_brg}}/use"><button type="button" class="btn btn-warning">PEMAKAIAN</button></a></td>

                                                            
                                                        </tr>
                                                        @endforeach
                                                    
                                                        </tbody>
                                                    </table>
                                                   
                                                    </form>
                                                   
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

