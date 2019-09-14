
<!DOCTYPE html>
<html>
<head>
    <title>DATA GUDANG </title>
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
        <h3 align="center">  DATA GUDANG {{$pics->nm_pic}} </h3>
</div>

<div class="panel-body">
        <table style="width:100%">
                <tr>
                    <th class="a" width="10px">No</th>
                    <th class="a" width="60px">Kode Barang</th> 
                    <th class="a" width="150px">Nama Barang</th>
                    <th class="a" width="30px">Jumlah</th> 
                    <th class="a" width="100px">Harga</th>
                    <th class="a" width="30px">Buffer Min</th> 
                    <th class="a" width="30px">Buffer Max</th>

                </tr>
                
            @foreach ($data as $datas)
                <tr>
                    <td class="a">{{++$no}}</td>
                    <td class="a">{{$datas->id_barang}}</td>
                    <td>{{$datas->nm_barang}}</td>
                    <td class="a">{{$datas->jml}}</td>
                    <td>Rp {{ number_format($datas->harga, 0) }}</td>
                    <td class="a">{{$datas->min_cab}}</td>
                    <td class="a">{{$datas->max_cab}}</td>
                </tr>
            @endforeach
              
       
                
        </table>
</div>
</div>
</body>
</html>