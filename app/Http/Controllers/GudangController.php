<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\atk_gudang;
use Carbon\Carbon;

use PDF;
use Auth;
use Session;

class GudangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $query = DB::table('atk_gudangs')->orderBy('id_gudang_brg', 'DESC')->first();

        if($query){
            $a=substr($query->id_gudang_brg, 3, 4);
            $last=$a+1;
            $id_gudang_brg="GD-$last";

        }else{
            $id_gudang_brg="GD-1";
        }

        $data = DB::table('atk_gudangs')
                ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
                ->orderBy('atk_gudangs.id_gudang_brg','asc')->get();
        $pic = DB::table('atk_pics')
        ->orderBy('id_pics','asc')->get();
        $barang = DB::table('atk_barangs')
            ->orderBy('atk_barangs.id_barang','asc')->get();


        return view('/app/gudang', compact('id_gudang_brg','data','barang','pic'));
    }

    public function insert(Request $request)
    {


                $id_gudang_brg= $request->input('id_gudang_brg');
                $id_barang= $request->input('id_barang');
                $pic = $request->input('pic');
                $jml= $request->input('jml');
                $harga= $request->input('harga');
                $min = $request->input('min');
                $max= $request->input('max');

                $gudang = new atk_gudang;
                $gudang->id_gudang_brg = $id_gudang_brg;
                $gudang->id_barang = $id_barang;
                $gudang->pic = $pic;
                $gudang->jml = $jml;
                $gudang->harga = $harga;
                $gudang->min = $min;
                $gudang->max = $max;
                $gudang->save();

                Session::flash('success_massage','Berhasil disimpan.');
                return redirect('/gudang');

    }

    public function edit($id)
    { 
        $pic = DB::table('atk_pics')
        ->orderBy('id_pic','asc')->get();


        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->get();

        $barang = DB::table('atk_barangs')
            ->orderBy('atk_barangs.id_barang','asc')->get();

        $gudang = DB::table('atk_gudangs')
                ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
                ->where('atk_gudangs.id_gudang_brg',$id)->first();
        

      return view ('/app/editgudang', compact('gudang','barang','data','pic'));
    }


    public function update(Request $request,$id)
    {
    $gudang = atk_gudang::find($id);
  
    $gudang->id_gudang_brg = $request->id_gudang_brg;
    $gudang->id_barang = $request->id_barang;
    $gudang->pic = $request->pic;
    $gudang->jml = $request->jml;
    $gudang->harga = $request->harga;
    $gudang->min = $request->min;
    $gudang->max = $request->max;
    $gudang->save();


    Session::flash('success_massage','Data Pelamar, berhasil di edit');
    return redirect('/gudang');
    }




    public function destroy($id)
    {
        $barang = atk_gudang::findOrFail($id);

        atk_gudang::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);
        
    }

    public function databarang()
    {
        
        
        $querysql = DB::table('atk_awals')
            ->orderBy('atk_awals.id_atk_awal','desc')->first();

        $querynow = Carbon::now();
        $id_pic = Auth::User()->id_pics;
        
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;

        $pic = DB::table('atk_pics')->where('id_pics','=',$id_pic)->first();

        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->join('atk_pics','atk_gudangs.pic','=','atk_pics.id_pics')
        ->where('atk_gudangs.pic','!=',1)
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->orderBy('atk_gudangs.pic','asc')->get();

        $datapics = DB::table('atk_pics')->orderBy('id_pics','asc')->get();
        

        return view('/app/datagudang', compact('querysql','querynow','monthnow','yearnow','data','pic','datapics'));
    }

    public function datacabang($id)
    {
        
        
        $querysql = DB::table('atk_awals')
            ->orderBy('atk_awals.id_atk_awal','desc')->first();

        $querynow = Carbon::now();
        $id_pic = Auth::User()->id_pics;
        
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;

        $pic = DB::table('atk_pics')->where('id_pics','=',$id_pic)->first();

        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->join('atk_pics','atk_gudangs.pic','=','atk_pics.id_pics')
        ->where('atk_gudangs.pic','=',$id)
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->orderBy('atk_gudangs.pic','asc')->get();

        $datapics = DB::table('atk_pics')->orderBy('id_pics','asc')->get();
        $pics = DB::table('atk_pics')->where('id_pics','=',$id)->first();
        return view('/app/datacabang', compact('querysql','querynow','monthnow','yearnow','data','pic','datapics','pics'));
    }

    public function addtogudang(Request $request)
    {
        $id_barang= $request->input('id_barang');
        $jml= $request->input('jml');

        $gudang = new atk_gudang;
        $gudang->id_barang = $id_barang;
        $gudang->pic = 1;
        $gudang->save();

        Session::flash('success_massage','Berhasil disimpan.');
        return redirect('/addstockbarang');

    }

    public function makePDF($id){ 
        $no = 0;
       

        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->join('atk_pics','atk_gudangs.pic','=','atk_pics.id_pics')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
        ->where('atk_gudangs.pic','=',$id)
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->orderBy('atk_gudangs.pic','asc')->get();

        $pics = DB::table('atk_pics')->where('id_pics','=',$id)->first();

       
        $pdf = PDF::loadView('app/cetakgudang',compact ('data','no','pics'))->setPaper('A4', 'landscape');;
        
                
        return $pdf->download('Data_Gudang_'.$pics->nm_pic.'.pdf');
    }

    public function PDFAll(){ 
        $no = 0;
       

        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->join('atk_pics','atk_gudangs.pic','=','atk_pics.id_pics')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
        ->orderBy('atk_gudangs.pic','asc')->get();


       
        $pdf = PDF::loadView('app/cetakgudangall',compact ('data','no'))->setPaper('A4', 'landscape');;
        
                
        return $pdf->download('Data_Gudang_All.pdf');
    }

    public function lapbulstok()
    {

        
        $datapics = DB::table('atk_pics')->orderBy('id_pics','asc')->get();
        $data = DB::table('atk_awals')
                ->select('atk_awals.tahun')
                ->groupBy('atk_awals.tahun')->get();
      


        return view('/app/lapbulstok', compact('data','datapics'));
    }

    public function lapbulstokpost(Request $request)
    {


              
        $bagian= $request->input('bagian');
        $bulan= $request->input('bulan');
        $tahun = $request->input('tahun');
       
        $no = 0;


            $pics = DB::table('atk_pics')->where('id_pics','=',$bagian)->first();

            $data = DB::table('atk_barangs')
            ->join('atk_awals','atk_barangs.id_barang','=','atk_awals.id_barang')
            ->join('atk_tambahs','atk_awals.id_gudang_brg','=','atk_tambahs.id_gudang_brg')
            ->join('atk_pics','atk_awals.pic','=','atk_pics.id_pics')
            ->where('atk_awals.bulan','=',$bulan)
            ->where('atk_awals.tahun','=',$tahun)
            ->where('atk_awals.pic','=',$bagian)
            ->where('atk_tambahs.bulan_beli','=',$bulan)
            ->where('atk_tambahs.tahun_beli','=',$tahun)
            ->where('atk_tambahs.pic_beli','=',$bagian)
            ->select('*',DB::raw('(atk_awals.jml+atk_tambahs.jml_beli) as jmltotal'),'atk_awals.id_barang',DB::raw('(atk_barangs.harga) as hargabarang'))
            ->groupBy('atk_awals.id_barang')->get();

            $totaljml = DB::table('atk_awals')
            ->select(DB::raw("SUM(atk_awals.jml) as totaljml"))
            ->where('atk_awals.bulan','=',$bulan)
            ->where('atk_awals.tahun','=',$tahun)
            ->where('atk_awals.pic','=',$bagian)
            ->first();

            $totalbeli = DB::table('atk_tambahs')
            ->select(DB::raw("SUM(atk_tambahs.jml_beli) as totalbeli"))
            ->where('atk_tambahs.bulan_beli','=',$bulan)
            ->where('atk_tambahs.tahun_beli','=',$tahun)
            ->where('atk_tambahs.pic_beli','=',$bagian)
            ->first();

            $totalall = DB::table('atk_awals')
            ->join('atk_tambahs','atk_awals.id_gudang_brg','=','atk_tambahs.id_gudang_brg')
            ->select(DB::raw("SUM(atk_awals.jml+atk_tambahs.jml_beli) as totalall"))
            ->where('atk_awals.bulan','=',$bulan)
            ->where('atk_awals.tahun','=',$tahun)
            ->where('atk_awals.pic','=',$bagian)
            ->where('atk_tambahs.bulan_beli','=',$bulan)
            ->where('atk_tambahs.tahun_beli','=',$tahun)
            ->where('atk_tambahs.pic_beli','=',$bagian)
            ->first();

            $hargaall = DB::table('atk_barangs')
            ->join('atk_awals','atk_barangs.id_barang','=','atk_awals.id_barang')
            ->join('atk_tambahs','atk_awals.id_gudang_brg','=','atk_tambahs.id_gudang_brg')
            ->join('atk_pics','atk_awals.pic','=','atk_pics.id_pics')
            ->where('atk_awals.bulan','=',$bulan)
            ->where('atk_awals.tahun','=',$tahun)
            ->where('atk_awals.pic','=',$bagian)
            ->where('atk_tambahs.bulan_beli','=',$bulan)
            ->where('atk_tambahs.tahun_beli','=',$tahun)
            ->where('atk_tambahs.pic_beli','=',$bagian)
            ->select(DB::raw('SUM(atk_barangs.harga) as hargaall'))->first();

            $pdf = PDF::loadView('app/cetaklapbulstok',compact ('data','no','pics','totaljml','totalbeli','totalall','hargaall'))->setPaper('A4', 'landscape');;
        
                
            return $pdf->download('LapBulStok_'.$pics->nm_pic.'.pdf');

    }


    

    public function lappemakaian()
    {

        
        $datapics = DB::table('atk_pics')->orderBy('id_pics','asc')->get();
        $data = DB::table('atk_awals')
                ->select('atk_awals.tahun')
                ->groupBy('atk_awals.tahun')->get();
      


        return view('/app/lappemakaian', compact('data','datapics'));
    }

    public function lappemakaianpost(Request $request)
    {


              
        $bagian= $request->input('bagian');
        $bulan= $request->input('bulan');
        $tahun = $request->input('tahun');
        if($bulan == 1){
            $month = "JANUARI";
        }elseif ($bulan == 2) {
            $month = "FEBRUARI";
        }elseif ($bulan == 3) {
            $month = "MARET";
        }elseif ($bulan == 4) {
            $month = "APRIL";
        }elseif ($bulan == 5) {
            $month = "MEI";
        }elseif ($bulan == 6) {
            $month = "JUNI";
        }elseif ($bulan == 7) {
            $month = "JULI";
        }elseif ($bulan == 8) {
            $month = "AGUSTUS";
        }elseif ($bulan == 9) {
            $month = "SEPTEMBER";
        }elseif ($bulan == 10) {
            $month = "OKTOBER";
        }elseif ($bulan == 11) {
            $month = "NOVEMBER";
        }else{
            $month = "DESEMBER";
        }
        $no = 0;


            $pics = DB::table('atk_pics')->where('id_pics','=',$bagian)->first();

            $data = DB::table('atk_pemakaians')
            ->join('atk_gudangs','atk_pemakaians.id_gudang_brg','=','atk_gudangs.id_gudang_brg')
            ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
            ->join('atk_pics','atk_gudangs.pic','=','atk_pics.id_pics')
            ->where('atk_pemakaians.bln_pemakaian','=',$bulan)
            ->where('atk_pemakaians.thn_pemakaian','=',$tahun)
            ->where('atk_gudangs.pic','=',$bagian)->orderBy('atk_pemakaians.created_at')->get();

            $totaljml = DB::table('atk_awals')
            ->select(DB::raw("SUM(atk_awals.jml) as totaljml"))
            ->where('atk_awals.bulan','=',$bulan)
            ->where('atk_awals.tahun','=',$tahun)
            ->where('atk_awals.pic','=',$bagian)
            ->first();

            $totalbeli = DB::table('atk_tambahs')
            ->select(DB::raw("SUM(atk_tambahs.jml_beli) as totalbeli"))
            ->where('atk_tambahs.bulan_beli','=',$bulan)
            ->where('atk_tambahs.tahun_beli','=',$tahun)
            ->where('atk_tambahs.pic_beli','=',$bagian)
            ->first();

            $totalall = DB::table('atk_awals')
            ->join('atk_tambahs','atk_awals.id_gudang_brg','=','atk_tambahs.id_gudang_brg')
            ->select(DB::raw("SUM(atk_awals.jml+atk_tambahs.jml_beli) as totalall"))
            ->where('atk_awals.bulan','=',$bulan)
            ->where('atk_awals.tahun','=',$tahun)
            ->where('atk_awals.pic','=',$bagian)
            ->where('atk_tambahs.bulan_beli','=',$bulan)
            ->where('atk_tambahs.tahun_beli','=',$tahun)
            ->where('atk_tambahs.pic_beli','=',$bagian)
            ->first();

            $hargaall = DB::table('atk_barangs')
            ->join('atk_awals','atk_barangs.id_barang','=','atk_awals.id_barang')
            ->join('atk_tambahs','atk_awals.id_gudang_brg','=','atk_tambahs.id_gudang_brg')
            ->join('atk_pics','atk_awals.pic','=','atk_pics.id_pics')
            ->where('atk_awals.bulan','=',$bulan)
            ->where('atk_awals.tahun','=',$tahun)
            ->where('atk_awals.pic','=',$bagian)
            ->where('atk_tambahs.bulan_beli','=',$bulan)
            ->where('atk_tambahs.tahun_beli','=',$tahun)
            ->where('atk_tambahs.pic_beli','=',$bagian)
            ->select(DB::raw('SUM(atk_barangs.harga) as hargaall'))->first();

            $pdf = PDF::loadView('app/cetaklappemakaian',compact ('data','no','pics','totaljml','totalbeli','totalall','hargaall','month','tahun'))->setPaper('A4', 'landscape');;
        
                
            return $pdf->download('LapPemakaianStok'.$pics->nm_pic.'.pdf');

    }



    public function stokmasukPDF(){ 
        $no = 0;

        $querynow = Carbon::now();
        
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;

        



        $data = DB::table('atk_barangs')
        ->join('atk_awals','atk_barangs.id_barang','=','atk_awals.id_barang')
        ->join('atk_tambahs','atk_awals.pic','=','atk_tambahs.pic_beli')
        ->where('atk_awals.bulan','=',$monthnow)
        ->where('atk_awals.tahun','=',$yearnow)
        ->where('atk_awals.pic','=',1)
        ->where('atk_tambahs.bulan_beli','=',$monthnow)
        ->where('atk_tambahs.tahun_beli','=',$yearnow)
        ->where('atk_tambahs.pic_beli','=',1)
        ->select('*',DB::raw('(atk_awals.jml+atk_tambahs.jml_beli) as jmltotal'),'atk_awals.id_barang')
        ->groupBy('atk_awals.id_barang')->get();

        return view('/app/cek', compact('no','data'));
    }


}
