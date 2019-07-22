<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\atk_satuan;
use Session;

class SatuanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        $query = DB::table('atk_satuans')->orderBy('id_satuan', 'DESC')->first();

        if($query){
            $a=substr($query->id_satuan, 3, 4);
            $last=$a+1;
            $id_satuan="ST-$last";

        }else{
            $id_satuan="ST-1";
        }

        $data = DB::table('atk_satuans')
            ->orderBy('atk_satuans.id_satuan','asc')->get();


        return view('/app/satuan', compact('id_satuan','data'));
    }

    public function insert(Request $request)
    {


                $id_satuan= $request->input('id_satuan');
                $nm_satuan = $request->input('nm_satuan');

                $satuan = new atk_satuan;
                $satuan->id_satuan = $id_satuan;
                $satuan->nm_satuan = $nm_satuan;
                $satuan->save();

                Session::flash('success_massage','Berhasil disimpan.');
                return redirect('/satuan');

    }


    public function edit($id)
    { 
       

        $satuan = DB::table('atk_satuans')
        ->orderBy('atk_satuans.id_satuan','asc')->get();

        $satuans = DB::table('atk_satuans')->where('id_satuan',$id)->first();

      return view ('/app/editsatuan', compact('satuans','satuan'));
    }


    public function update(Request $request,$id)
    {
    $satuan = atk_satuan::find($id);
  
    $satuan->nm_satuan = $request->nm_satuan;
    $satuan->save();


    Session::flash('success_massage','Data Pelamar, berhasil di edit');
    return redirect('/satuan');
    }



    public function destroy($id)
    {
        $satuan = atk_satuan::findOrFail($id);

        atk_satuan::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);
        
    }

}
