<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\atk_gudang;
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
        $barang = DB::table('atk_barangs')
            ->orderBy('atk_barangs.id_barang','asc')->get();


        return view('/app/gudang', compact('id_gudang_brg','data','barang'));
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
        $data = DB::table('atk_gudangs')
        ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
        ->orderBy('atk_gudangs.id_gudang_brg','asc')->get();

        $barang = DB::table('atk_barangs')
            ->orderBy('atk_barangs.id_barang','asc')->get();

        $gudang = DB::table('atk_gudangs')->where('id_gudang_brg',$id)->first();

      return view ('/app/editgudang', compact('gudang','barang','data'));
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
}
