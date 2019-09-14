<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\atk_satuan;
use App\Model\atk_barang;
use App\Model\atk_gudang;
use App\Model\atk_awal;
use App\Model\atk_tambah;
use App\Model\atk_pemakaian;
use Carbon\Carbon;
use Auth;
use PDF;

use Session;

class TransController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
        
        $querysql = DB::table('atk_awals')
            ->orderBy('atk_awals.id_atk_awal','desc')->first();
        $querynow = Carbon::now();

        
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;
        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->get();

        

        return view('/app/trans', compact('querysql','querynow','monthnow','yearnow','data'));
    }

    public function addstock()
    {
        
        
        $querysql = DB::table('atk_gudangs')
            ->orderBy('atk_gudangs.id_gudang_brg','desc')->first();

            $querysqls = DB::table('atk_awals')
            ->orderBy('atk_awals.id_atk_awal','desc')->first();

        $querynow = Carbon::now();

        
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;
        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
        ->where('atk_gudangs.pic','=',1)
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->get();

        $awals = DB::table('atk_barangs')
            ->orderBy('atk_barangs.id_barang','desc')->get();
        

        return view('/app/addstock', compact('querysql','querynow','monthnow','yearnow','data','awals','querysqls'));
    }

    public function copystock()
    {

        $querynow = Carbon::now();
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;
        $first =  DB::table('atk_barangs')
                ->orderBy('id_barang','ASC')->get();

        foreach ($first as $firsts){
        $id_barang = $firsts->id_barang;
        $nm_barang = $firsts->nm_barang;
        $id_satuan = $firsts->id_satuan;

        $insert = new atk_gudang;
        $insert->id_barang = $id_barang;
        $insert->pic = 1;
        $insert->save();
        };

        Session::flash('success_massage','Berhasil disimpan.');
        return redirect('/addstock');


    }


    public function copyall()
    {

        $querynow = Carbon::now();
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;
        $first =  DB::table('atk_gudangs')
                ->orderBy('id_gudang_brg','ASC')->get();

        foreach ($first as $firsts){
        $id_gudang_brg = $firsts->id_gudang_brg;
        $id_barang = $firsts->id_barang;
        $pic = $firsts->pic;
        $jml = $firsts->jml;

        $insert = new atk_awal;
        $insert->id_gudang_brg = $id_gudang_brg;
        $insert->id_barang = $id_barang;
        $insert->pic = $pic;
        $insert->jml = $jml;
        $insert->bulan = $monthnow;
        $insert->tahun = $yearnow;
        $insert->save();
        };

        Session::flash('success_massage','Berhasil disimpan.');
        return redirect('/');


    }

    public function edit($id)
    { 
        $all = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->get();

        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->where('id_gudang_brg',$id)->first();

        
        return view ('/app/stokmasuk', compact('data','all'));
    }


    public function stock(Request $request)
    {
    


        $querynow = Carbon::now();
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;
      
        foreach($request->id_gudang_brg as $key => $value){ 

            $gudangs = atk_gudang::find($request->id_gudang_brg[$key]);
            $stokawal = $gudangs->jml;
            $tot_gudang = $stokawal + $request->jml[$key];
            $gudangs->jml = $tot_gudang; 
            $gudangs->save(); 


            $inserttambah = new atk_tambah;
            $inserttambah->id_gudang_brg = $request->id_gudang_brg[$key];
            $inserttambah->id_barang =  $request->id_barang[$key];
            $inserttambah->pic_beli = $request->id_pics[$key];
            $inserttambah->jml_beli = $request->jml[$key];
            $inserttambah->bulan_beli = $monthnow;
            $inserttambah->tahun_beli = $yearnow;
            $inserttambah->save();
            
      

        }


        return redirect('/');


    }



    public function update(Request $request,$id)
    {

        $data = DB::table('atk_gudangs')
        ->where('id_gudang_brg',$id)->first();

        $querynow = Carbon::now();
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;

        $jmllama= $request->input('jmllama');
        $jmlbaru= $request->input('jmlbaru');

            $id_gudang_brg = $data->id_gudang_brg;
            $id_barang = $data->id_barang;
            $pic = $data->pic;
            $jml = $data->jml;
            $harga = $data->harga;
    
            $insert = new atk_tambah;
            $insert->id_gudang_brg = $id_gudang_brg;
            $insert->id_barang = $id_barang;
            $insert->pic_beli = $pic;
            $insert->jml_beli = $jmlbaru;
            $insert->harga_beli = $harga;
            $insert->bulan_beli = $monthnow;
            $insert->tahun_beli = $yearnow;
            $insert->save();
            
            $trans = atk_gudang::find($id);

            
            
            $jmlakhir = $jmlbaru+$jmllama;

            $trans->jml = $jmlakhir;
            $trans->save();

            Session::flash('success_massage','Berhasil disimpan.');
            return redirect('/trans');


    }


    public function editcab($id)
    { 
        $pic = DB::table('atk_pics')
        ->orderBy('id_pics','asc')->get();

        $query = DB::table('atk_gudangs')->where('pic','!=','GA')->orderBy('id_gudang_brg', 'DESC')->first();

        if($query){
            $a=substr($query->id_gudang_brg, 3, 4);
            $last=$a+1;
            $id_barang="GK-$last";

        }else{
            $id_barang="GK-1";
        }


        $all = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->get();

        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->where('id_gudang_brg',$id)->first();

        
        return view ('/app/stokkeluar', compact('data','all','id_barang','pic'));
    }


    public function updatecab(Request $request,$id)
    {

            $data = DB::table('atk_gudangs')
            ->where('id_gudang_brg',$id)->first();
        
            $querynow = Carbon::now();
            $monthnow = $querynow->month;
            $yearnow = $querynow->year;
        
            $id_gudang_brgs= $request->input('id_gudang_brg');
            $pic= $request->input('pic');
            $jmltersedia= $request->input('jmllama');
            $jmlkeluar= $request->input('jmlkeluar');
            $kd_barang= $request->input('kd_barang');
            $kd_barangcab= $request->input('kd_barangcab');
            $min= $request->input('min');
            $max= $request->input('max');
            $id_gudang_brg = $data->id_gudang_brg;
            $id_barang = $data->id_barang;
            $jml = $data->jml;
            $harga = $data->harga;

            $stokcab = DB::table('atk_gudangs')
            ->where('id_barang',$kd_barang)
            ->where('pic',$pic)
            ->first();


            if($stokcab == NULL){
            $insert = new atk_gudang;
            $insert->id_gudang_brg = $kd_barangcab;
            $insert->id_barang = $id_barang;
            $insert->pic = $pic;
            $insert->jml = $jmlkeluar;
            $insert->harga = $harga;
            $insert->min = $min;
            $insert->max = $max;
            $insert->save();
            }else{

                $trans = atk_gudang::find($stokcab->id_gudang_brg);
                $jmlawal = $trans->jml;
                $total = $jmlawal+$jmlkeluar;

                $trans->jml = $total;
                $trans->min = $min;
                $trans->max = $max;
                
                $trans->save();

            }

            $transtotal = atk_gudang::find($id_gudang_brgs);
            $totalbarang = $jmltersedia-$jmlkeluar;

            $transtotal->jml = $totalbarang;
            
            $transtotal->save();

            $querys = DB::table('atk_gudangs')->where('pic','!=','GA')->orderBy('id_gudang_brg', 'DESC')->first();

            $a=$querys->id_gudang_brg;
            $inserttambah = new atk_tambah;
            $inserttambah->id_gudang_brg = $a;
            $inserttambah->id_barang = $id_barang;
            $inserttambah->pic_beli = $pic;
            $inserttambah->jml_beli = $jmlkeluar;
            $inserttambah->harga_beli = $harga;
            $inserttambah->bulan_beli = $monthnow;
            $inserttambah->tahun_beli = $yearnow;
            $inserttambah->save();


            Session::flash('success_massage','Berhasil disimpan.');
            return redirect('/trans');


    }
    public function usecab($id)
    { 
        $pic = DB::table('atk_pics')
        ->orderBy('id_pics','asc')->get();

        $query = DB::table('atk_gudangs')->orderBy('id_gudang_brg', 'DESC')->first();

        if($query){
            $id_barang = $query->id_gudang_brg+1;

        }else{
            $id_barang="1";
        }


        $all = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->get();

        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->where('atk_gudangs.id_gudang_brg',$id)->first();

        
        return view ('/app/pemakaian', compact('data','all','id_barang','pic'));
    }


    public function updateuse(Request $request,$id)
    {

            $data = DB::table('atk_gudangs')
            ->where('id_gudang_brg',$id)->first();
        
            $querynow = Carbon::now();
            $monthnow = $querynow->month;
            $yearnow = $querynow->year;
        
            $id_gudang_brgs= $request->input('id_gudang_brg');
            $keterangan= $request->input('keterangan');
            $jmltersedia= $request->input('jmllama');
            $jmlkeluar= $request->input('jmlkeluar');
            $kd_barang= $request->input('kd_barang');
            $kd_barangcab= $request->input('kd_barangcab');

            $id_gudang_brg = $data->id_gudang_brg;
            $id_barang = $data->id_barang;
            $jml = $data->jml;
            $harga = $data->harga;

            $trans = atk_gudang::find($id_gudang_brgs);
            $jmlawal = $trans->jml;
            $total = $jmlawal-$jmlkeluar;

            $trans->jml = $total;
            
            $trans->save();
            
            $insert = new atk_pemakaian;
            $insert->id_gudang_brg = $id_gudang_brgs;
            $insert->jml_pemakaian = $jmlkeluar;
            $insert->harga_pemakaian = $data->harga;
            $insert->ket_pemakaian = $keterangan;
            $insert->bln_pemakaian = $monthnow;

            $insert->save();
           


            Session::flash('success_massage','Berhasil disimpan.');
            return redirect('/trans');


    }


    public function cabanguse($id)
    { 
        $pic = DB::table('atk_pics')
        ->orderBy('id_pics','asc')->get();

        $query = DB::table('atk_gudangs')->where('pic','!=','GA')->orderBy('id_gudang_brg', 'DESC')->first();

        if($query){
            $a=substr($query->id_gudang_brg, 3, 4);
            $last=$a+1;
            $id_barang="GK-$last";

        }else{
            $id_barang="GK-1";
        }

     
        $all = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->where('atk_gudangs.pic','=',Auth::user()->id_pics)
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->get();

        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->where('id_gudang_brg',$id)->first();

        
        return view ('/app/cabanguse', compact('data','all','id_barang','pic'));
    }


    public function cabangupdate(Request $request,$id)
    {

            $data = DB::table('atk_gudangs')
            ->where('id_gudang_brg',$id)->first();
        
            $querynow = Carbon::now();
            $monthnow = $querynow->month;
            $yearnow = $querynow->year;
        
            $id_gudang_brgs= $request->input('id_gudang_brg');
            $keterangan= $request->input('keterangan');
            $jmltersedia= $request->input('jmllama');
            $jmlkeluar= $request->input('jmlkeluar');
            $kd_barang= $request->input('kd_barang');

            $id_gudang_brg = $data->id_gudang_brg;
            $id_barang = $data->id_barang;
            $jml = $data->jml;

            $trans = atk_gudang::find($id_gudang_brgs);
            $jmlawal = $trans->jml;
            $total = $jmlawal-$jmlkeluar;

            $trans->jml = $total;
            
            $trans->save();
            
            $insert = new atk_pemakaian;
            $insert->id_gudang_brg = $id_gudang_brgs;
            $insert->jml_pemakaian = $jmlkeluar;
            $insert->ket_pemakaian = $keterangan;
            $insert->bln_pemakaian = $monthnow;
            $insert->thn_pemakaian = $yearnow;


            $insert->save();
           


            Session::flash('success_massage','Berhasil disimpan.');
            return redirect('/stockcab');


    }


    public function transaksiall()
    {
        
        $id = Auth::user()->id_pics;
        // // $barang = DB::table('atk_carts')->orderby('id_barang','desc')->where('atk_carts.status','=','0')->orderby('id_cart','desc')->get();
       
        $query = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->select('*',DB::raw('DATE(atk_carts.created_at) as dates'))->groupBy('atk_carts.status','dates')->get();
        // // $barang = DB::table('atk_barangs')->where('id_user','=',$id)->where('status','=','0')->orderby('id_barang','desc')->paginate(10);
        $cart = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('atk_carts.status','=','0')->get();

        

        return view('/app/transall', compact('query','cart'));
    }

    public function makePDF(){ 
        $no = 0;
        $abc = atk_barang::all();
        $pdf = PDF::loadView('app/cetak',compact ('abc','no'));
        
                
        return $pdf->download('fptk.pdf');
      }

}
