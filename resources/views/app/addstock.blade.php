@extends('layouts.app')

@section('content')

      <!-- Main Content -->
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Data Transaksi</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="/">Dashboard</a></div>
                    <div class="breadcrumb-item">Data Stok Pusat</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Data Transaksi Stok Gudang</h2>
                    <!-- <p class="section-lead">Silahkan Masukkan Detail Nama Barang dan Satuannya yang nantinya digunakan untuk data barang.</p> -->

                        <div class="row">
                            <div class="col-12 col-md-12 col-lg-12">
                                <div class="card">
                                @if($querysql == NULL)
                                  
                                    <form action="/trans/copystock" method="post" role="form">
                                        {{csrf_field()}}
                                    <div class="buttons">
                                        <b>Belum ada Barang di Gudang Besar, Silahkan klik COPY DATA untuk memasukkan Data Barang ke Gudang Besar.</b><br>
                                        <button class="btn btn-primary">COPY DATA !</button>
                                    </div>
                                    </form>
                                    
                                    @else
                                    @if($querysqls != NULL)
                                        @if($querysqls->bulan != $monthnow AND $querysqls->tahun != $monthnow)
                                        <form action="/trans/copyall" method="post" role="form">
                                            {{csrf_field()}}
                                        <div class="buttons">
                                            <button class="btn btn-info">COPY STOK AWAL BULAN</button>
                                        </div>
                                        </form>
                                        @else
                                      
                                        <div class="row">
                                      
                                        <div class="col-12">
                                            <div class="card">
                                            
                                                <div class="card-header">
                                                   
                                                    <a href="/addstockbarang"><button type="submit" class="btn btn-info float-right">TAMBAH BARANG</button></a>
                                                </div>
                                              
                                                <div class="card-body">

                                                
                                                    <div class="table-responsive">
                                                    <form action="/trans/stock" method="POST" role="form" >
                        
                                                    {{csrf_field()}}
                                                    <table class="table table-striped" id="table-1">
                                                        <thead>                                 
                                                        <tr>
                                                            <th >
                                                            #
                                                            </th>
                                                            <th>Nama Barang</th>
                                                            <!-- <th>PIC</th> -->
                                                            <th>Stok Lama</th>
                                                            <th>Harga</th>
                                                            <th>Buffer Min</th>
                                                            <th>Buffer Max</th>
                                                            <th>Tambah Stok</th>
                                                            <!-- <th>Action</th> -->
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        @foreach ($data as $datas)                                 
                                                        <tr>
                                                            <td>{{$datas->id_barang}}</td>
                                                            <td>{{$datas->nm_barang}}</td>
                                                            <!-- <td>{{$datas->pic}}</td> -->
                                                            <td>{{$datas->jml}}</td>
                                                            <td>Rp {{ number_format($datas->harga, 0) }}</td>
                                                            <td>{{$datas->min_ga}} </td>
                                                            <td>{{$datas->max_ga}}</td>
                                                            
                                                            <td> <div class="input-group mb-2">
                        
                                                            <input type="hidden" class="form-control text-right" name="id_gudang_brg[]" value="{{$datas->id_gudang_brg}}">
                                                            <input type="hidden" class="form-control text-right" name="id_barang[]" value="{{$datas->id_barang}}">
                                                            <input type="hidden" class="form-control text-right" name="id_pics[]" value="{{ $datas->pic }}">
                                                            <input type="text" class="form-control text-right" id="inlineFormInputGroup2" placeholder="" name="jml[]" style="width:10px;" value="">
                                                            <div class="input-group-append">
                                                            <div class="input-group-text">{{$datas->nm_satuan}}</div>
                                                        </div>
                                                        
                                                        </td>
                                                            
                                                            <!-- <td><a href="/trans/{{$datas->id_gudang_brg}}/edit"><button type="button" class="btn btn-info">TAMBAH STOK</button></a>&nbsp;<a href="/transcab/{{$datas->id_gudang_brg}}/editcab"><button type="button" class="btn btn-warning">STOK KELUAR</button></a>&nbsp;<a href="/usecab/{{$datas->id_gudang_brg}}/usecab"><button type="button" class="btn btn-warning">PEMAKAIAN</button></a></td> -->
                                                        </tr>
                                                        @endforeach
                                                    
                                                        </tbody>
                                                    </table>
                                                    <button type="submit" class="btn btn-primary">SIMPAN</button>&nbsp;
                                                    </form>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    </div>
                                        @endif
                                        @else
                                    <form action="/trans/copyall" method="post" role="form">
                                        {{csrf_field()}}
                                    <div class="buttons">
                                        <button class="btn btn-info">COPY STOK AWAL BULAN</button>
                                    </div>
                                    </form>
                                    
                                        @endif
                                    @endif
                               
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

