
<!DOCTYPE html>
<html>
<head>
    <title>FPTK </title>
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
        th.a{
            text-align: center;
        }
        </style>
</head>
<body>
<div class="panel panel - default">
        @foreach ($abc as $xyz)
   <div class="panel-heading">
        <img src="../public/logo.png" alt="logo">
        <!-- <p align="right">{{$xyz->id}}</p> -->
        <h3 align="center">  DATA GUDANG {{$pics->nm_pic}} </h3>
</div>

<div class="panel-body">
        <table style="width:100%">
                <tr>
                    <th class="a" width="10px">No</th>
                    <th class="a" width="180px">Subject</th> 
                    <th class="a" width="350px">Keterangan</th>
                </tr>
                
                <tr>
                    <td>{{++$no}}</td>
                    <td>Divisi/Department/Cabang</td>
                    <td>{{ $xyz->nm_barang}}</td>
                </tr>
              
                <tr>
                    <td style="border:0px;" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Yang mengajukan<br><br><br><br></td>
                    <td style="border:0px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Menyetujui, <br><br><br><br></td>
                </tr>
                <tr>
                    <td colspan="2" style="border:0px;">...........&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;...........</td>
                    <td style="border:0px;">SIGIT ARIE H&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;LENY ARJANY&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HENGKY TANTO S</td>
                </tr>
                <tr>
                    <td colspan="2" style="border:0px;">User&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Kabag/Kadiv/Kacab</td>
                    <td style="border:0px;">Dir.OPR&Kepatuhan&nbsp;&nbsp;&nbsp;Dir.Bisnis&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dir.Utama</td>
                </tr>
                <tr>
                    <td style="border:0px;" colspan="2">tgl:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tgl:</td>
                    <td style="border:0px;">tgl:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tgl:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;tgl:</td>
                </tr>
                <tr>
                    <td style="border:0px;" colspan="2">a. Terpenuhi Tanggal</td>
                    <td style="border:0px;">:</td>
                </tr>
                <tr>
                    <td style="border:0px;" colspan="2">b. Nama</td>
                    <td style="border:0px;">:</td>
                </tr>
                <tr>
                    <td style="border:0px;" colspan="2">c. Diserahkan ke</td>
                    <td style="border:0px;">: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; tgl:</td>
                </tr>
                @endforeach
                
        </table>
</div>
</div>
</body>
</html>