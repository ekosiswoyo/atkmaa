<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\atk_barang;
use Session;

class BarangController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $query = DB::table('atk_barangs')->orderBy('id_barang', 'DESC')->first();

        if($query){
            $a=substr($query->id_barang, 3, 4);
            $last=$a+1;
            $id_barang="BR-$last";

        }else{
            $id_barang="BR-1";
        }

        $data = DB::table('atk_barangs')
                ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
                ->orderBy('atk_barangs.id_barang','asc')->get();
        $satuan = DB::table('atk_satuans')
            ->orderBy('atk_satuans.id_satuan','asc')->get();


        return view('/app/barang', compact('id_barang','data','satuan'));
    }

    public function insert(Request $request)
    {


                $id_barang= $request->input('id_barang');
                $nm_barang = $request->input('nm_barang');
                $id_satuan= $request->input('id_satuan');

                $barang = new atk_barang;
                $barang->id_barang = $id_barang;
                $barang->nm_barang = $nm_barang;
                $barang->id_satuan = $id_satuan;
                $barang->save();

                Session::flash('success_massage','Berhasil disimpan.');
                return redirect('/barang');

    }

    public function edit($id)
    { 
        $data = DB::table('atk_barangs')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
        ->orderBy('atk_barangs.id_barang','asc')->get();

        $satuan = DB::table('atk_satuans')
        ->orderBy('atk_satuans.id_satuan','asc')->get();

        $barangs = DB::table('atk_barangs')->where('id_barang',$id)->first();

      return view ('/app/editbarang', compact('barangs','satuan','data'));
    }


    public function update(Request $request,$id)
    {
    $barang = atk_barang::find($id);
  
    $barang->nm_barang = $request->nm_barang;
    $barang->id_satuan = $request->id_satuan;
    $barang->save();


    Session::flash('success_massage','Data Pelamar, berhasil di edit');
    return redirect('/barang');
    }




    public function destroy($id)
    {
        $barang = atk_barang::findOrFail($id);

        atk_barang::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);
        
    }
}
