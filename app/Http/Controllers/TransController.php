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
        $harga = $firsts->harga;

        $insert = new atk_awal;
        $insert->id_gudang_brg = $id_gudang_brg;
        $insert->id_barang = $id_barang;
        $insert->pic = $pic;
        $insert->jml = $jml;
        $insert->harga = $harga;
        $insert->bulan = $monthnow;
        $insert->tahun = $yearnow;
        $insert->save();
        };

        Session::flash('success_massage','Berhasil disimpan.');
        return redirect('/trans');


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


    public function update(Request $request,$id)
    {

        $data = DB::table('atk_gudangs')
        ->where('id_gudang_brg',$id)->first();

        $querynow = Carbon::now();
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;

            $id_gudang_brg = $data->id_gudang_brg;
            $id_barang = $data->id_barang;
            $pic = $data->pic;
            $jml = $data->jml;
            $harga = $data->harga;
    
            $insert = new atk_tambah;
            $insert->id_gudang_brg = $id_gudang_brg;
            $insert->id_barang = $id_barang;
            $insert->pic_beli = $pic;
            $insert->jml_beli = $jml;
            $insert->harga_beli = $harga;
            $insert->bulan_beli = $monthnow;
            $insert->tahun_beli = $yearnow;
            $insert->save();
            
            $trans = atk_gudang::find($id);

            $jmllama= $request->input('jmllama');
            $jmlbaru= $request->input('jmlbaru');
            
            $jmlakhir = $jmlbaru+$jmllama;

            $trans->jml = $jmlakhir;
            $trans->save();

            Session::flash('success_massage','Berhasil disimpan.');
            return redirect('/trans');


    }


    public function editcab($id)
    { 
        
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

        
        return view ('/app/stokkeluar', compact('data','all','id_barang'));
    }


    public function updatecab(Request $request,$id)
    {

        $data = DB::table('atk_gudangs')
        ->where('id_gudang_brg',$id)->first();
        
        $querynow = Carbon::now();
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;

            $pic= $request->input('pic');
            $jmlkeluar= $request->input('jmlkeluar');
            $kd_barang= $request->input('kd_barang');
            $kd_barangcab= $request->input('kd_barangcab');
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
            $insert->save();
            }else{
                


            }

            $trans = atk_gudang::find($id);

           
            
            $jmlakhir = $jmlbaru+$jmllama;

            $trans->jml = $jmlakhir;
            $trans->save();

            Session::flash('success_massage','Berhasil disimpan.');
            return redirect('/trans');


    }


}