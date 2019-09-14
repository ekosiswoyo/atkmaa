@extends('layouts.app')

@section('content')
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          

          <div class="card"  style="width:100%;">
                  <div class="card-header">
                    <h4>CETAK LAPORAN STOK GUDANG</h4>
                  </div>
                  <div class="card-body">
                  <form action="" method="post" role="form">
                      {{csrf_field()}}
                <div class="row">
                
                <div class="form-group col-md-4">
                <select class="form-control select2" name="bagian">
                    <option> -- PILIH PIC --</option>
                       @foreach($datapics as $pic)
                      <option value="{{$pic->id_pics}}">{{$pic->nm_pic}}</option>
                      @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <select class="form-control select2" name="bulan">
                    <option> -- PILIH BULAN --</option>
                      <option value="1">JANUARI</option>
                      <option value="2">FEBRUARI</option>
                      <option value="3">MARET</option>
                      <option value="4">APRIL</option>
                      <option value="5">MEI</option>
                      <option value="6">JUNI</option>
                      <option value="7">JULI</option>
                      <option value="8">AGUSTUS</option>
                      <option value="9">SEPTEMBER</option>
                      <option value="10">OKTOBER</option>
                      <option value="11">NOVEMBER</option>
                      <option value="12">DESEMBER</option>
                      
                    </select>
                  </div>
                  <div class="form-group col-md-4">
                    <select class="form-control select2" name="tahun" >
                    <option> -- PILIH TAHUN --</option>
                       @foreach($data as $datas)
                      <option value="{{$datas->tahun}}">{{$datas->tahun}}</option>
                      @endforeach
                    </select>
                  </div>
                  
                
                  
                  
                </div>
                <div class="buttons">
                    <button class="btn btn-info">Simpan</button>
                </div>
                </form>


                  </div>
                </div>
        </section>
      </div>
    
@endsection

