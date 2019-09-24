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
                    <div class="breadcrumb-item">Data Barang</div>
                    </div>
                </div>

                <div class="section-body">
                    <h2 class="section-title">Data Barang</h2>
                    <p class="section-lead">Silahkan Masukkan Nama Barang dan Satuannya yang nantinya digunakan untuk data barang.</p>

                        <div class="row">
                            <div class="col-4 col-md-4 col-lg-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Input Data</h4>
                                    </div>
                                    <form action="" method="post" role="form" enctype="multipart/form-data" >
                                        {{csrf_field()}}
                                    <div class="card-body">
                                        <div class="form-group">    
                                            <label>ID Barang</label>
                                            <input type="text" class="form-control" placeholder="Masukkan ID Barang" name="id_barang" value="{{$id_barang}}" readonly>
                                        </div>

                                        <div class="form-group">    
                                        <label>Nama Barang</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Nama Barang" name="nm_barang" required>
                                        </div>

                                        <div class="form-group">
                                        <label>Satuan</label>
                                        <select class="form-control select2" name="id_satuan">
                                        <option> -- PILIH SATUAN --</option>
                                            @foreach($satuan as $satuans)
                                            <option value="{{$satuans->id_satuan}}">{{$satuans->id_satuan}} ( {{$satuans->nm_satuan}} )</option>
                                            @endforeach
                                        </select>
                                        </div>

                                        <div class="form-group">
                                        <label>Harga</label>
                                        <input type="text" class="form-control" placeholder="Masukkan Harga Barang" name="harga" id="rupiah" required>
                                        </div>

                                        <div class="form-group">
                                        <label>Buffer Min GA</label>
                                        <input type="number" class="form-control" placeholder="Masukkan Buffer Minimal GA" name="min_ga" required>
                                        </div>

                                        <div class="form-group">
                                        <label>Buffer Max GA</label>
                                        <input type="number" class="form-control" placeholder="Masukkan Buffer Maximal GA" name="max_ga" required>
                                        </div>

                                        <div class="form-group">
                                        <label>Buffer Min Cabang</label>
                                        <input type="number" class="form-control" placeholder="Masukkan Buffer Minimal Cabang" name="min_cab" required>
                                        </div>

                                        <div class="form-group">
                                        <label>Buffer Max Cabang</label>
                                        <input type="number" class="form-control" placeholder="Masukkan Buffer Minimal Cabang" name="max_cab" required>
                                        </div>

                                        <div class="form-group">
                                          <label class="control-label">Foto Barang</label>                                                    
                                              
                                                  <input type="file" id="foto" name="foto">
                                        </div>

                                        <div class="buttons">
                                          <button class="btn btn-primary">Simpan</button>
                                        </div>

                                    </div>
                                    
                                    
                                </div>
                            </div>

                            <div class="col-8">
                <div class="card">
                  <div class="card-header">
                    <h4>Data Barang</h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="table-1">
                        <thead>                                 
                          <tr>
                            <th>
                              #
                            </th>
                            <th>Nama Barang</th>
                            <th>Foto</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($data as $datas)                                 
                          <tr>
                            <td>{{$datas->id_barang}}</td>
                            <td><a href="/barangs/{{$datas->id_barang}}">{{$datas->nm_barang}}</a></td>
                            @if($datas->foto != NULL)
                                                            <td><img src="{{asset('storage/lampiran/' . $datas->foto)}}" style="width:70px;height:70px;border-radius:15px;border:3px solid #E51414;"></td>
                                                            @else
                                                            <td><img src="{{asset('storage/lampiran/notfound.jpg')}}" style="width:70px;height:70px;border-radius:15px;border:3px solid #E51414;"></td>
                                                            @endif
                            <td><a href="/barang/{{$datas->id_barang}}/edit" class="btn btn-icon btn-info" title="Ubah Data"><i class="far fa-edit"></i></a>
                           <a class="btn btn-icon btn-primary" title="Hapus Data" onClick="deleteData('{{$datas->id_barang}}')"  data-id=" {{$datas->id_barang}}"   ><i class="fas fa-times"></i></td>
                            
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

<script type="text/javascript">
		
		var rupiah = document.getElementById('rupiah');
		rupiah.addEventListener('keyup', function(e){
			// tambahkan 'Rp.' pada saat form di ketik
			// gunakan fungsi formatRupiah() untuk mengubah angka yang di ketik menjadi format angka
			rupiah.value = formatRupiah(this.value, '');
		});
 
		/* Fungsi formatRupiah */
		function formatRupiah(angka, prefix){
			var number_string = angka.replace(/[^,\d]/g, '').toString(),
			split   		= number_string.split(','),
			sisa     		= split[0].length % 3,
			rupiah     		= split[0].substr(0, sisa),
			ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
			// tambahkan titik jika yang di input sudah menjadi angka ribuan
			if(ribuan){
				separator = sisa ? '.' : '';
				rupiah += separator + ribuan.join('.');
			}
 
			rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
			return prefix == undefined ? rupiah : (rupiah ? '' + rupiah : '');
		}
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

