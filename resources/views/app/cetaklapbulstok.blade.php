
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
        <h3 align="center">  DATA STOK MASUK GUDANG </h3>
</div>

<div class="panel-body">
        <table style="width:100%">
                <tr>
                    <th class="a" width="10px">No</th>
                    
                    <th class="a" width="50px">PIC</th>
                    <th class="a" width="60px">Kode Barang</th> 
                    <th class="a" width="150px">Nama Barang</th>
                    <th class="a" width="30px">Stok Awal</th> 
                    <th class="a" width="80px">Stok Masuk</th>
                    <th class="a" width="80px">Total Stok</th>
                    <th class="a" width="30px">Harga</th> 

                </tr>
           
                @if(count($data) > 0)
                    @foreach ($data as $datas)
                
                        <tr>
                            <td class="a">{{++$no}}</td>
                            <td>{{$datas->nm_pic}}</td>
                            <td class="a">{{$datas->id_barang}}</td>
                            <td>{{$datas->nm_barang}}</td>
                            <td class="a">{{$datas->jml}}</td>
                            <td class="a">{{$datas->jml_beli}}</td>
                            <td class="a">{{$datas->jmltotal}}</td>
                            <td>Rp {{ number_format($datas->hargabarang, 0) }}</td>
                        </tr>
                       
                        

                    @endforeach
                @else
                <tr><td colspan="8" class="a">TIDAK ADA DATA!</td></tr>
          
            @endif
            <tr>
                            <td class="a" colspan="4">TOTAL</td>
                            <td class="a">{{$totaljml->totaljml}}</td>
                            <td class="a">{{$totalbeli->totalbeli}}</td>
                            <td class="a">{{$totalall->totalall}}</td>
                            <td>Rp {{ number_format($hargaall->hargaall, 0) }}</td>
                        </tr>
                
        </table>
</div>
</div>
</body>
</html>