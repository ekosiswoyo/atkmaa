
<!DOCTYPE html>
<html>
<head>
    <title>DATA STOK MASUK GUDANG </title>
    <link href=" {{ asset ('public /css/
bootstrap.min.css') }} "rel="stylesheet">
<style>
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        th, td {
            padding: 5px;
            text-align: left;    
        }
        th.a,td.a{
            text-align: center;
        }
        </style>
</head>
<body>
<div class="panel panel - default">
   <div class="panel-heading">
        <img src="../public/logo.png" alt="logo">
        <h3 align="center">  DATA PEMAKAIAN BARANG {{$pics->nm_pic}}</h3>
        <h4 align="center"> {{$month}} {{$tahun}}</h4>
</div>

<div class="panel-body">
        <table style="width:100%">
                <tr>
                    <th class="a" width="10px">No</th>
                    
                    <th class="a" width="40px">Kode Barang</th> 
                    <th class="a" width="150px">Nama Barang</th>
                    <th class="a" width="20px">Jumlah</th> 
                    <th class="a" width="80px">Keterangan</th>
                    <th class="a" width="60px">Tanggal</th>

                </tr>
           
                @if(count($data) > 0)
                    @foreach ($data as $datas)
                
                        <tr>
                            <td class="a">{{++$no}}</td>
                            <td class="a">{{$datas->id_barang}}</td>
                            <td>{{$datas->nm_barang}}</td>
                            <td class="a">{{$datas->jml_pemakaian}}</td>
                            <td>{{$datas->ket_pemakaian}}</td>
                            <td>{{$datas->created_at}}</td>
                        </tr>
                       
                        

                    @endforeach
                @else
                <tr><td colspan="8" class="a">TIDAK ADA DATA!</td></tr>
          
            @endif
           
                
        </table>
</div>
</div>
</body>
</html>