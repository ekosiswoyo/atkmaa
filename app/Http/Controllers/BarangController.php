<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\atk_barang;
use App\Model\atk_cart;
use Auth;
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

    public function indexs()
    {
        
        $id = Auth::user()->id_pics;
        $barang = DB::table('atk_barangs')->orderby('id_barang','desc')->paginate(10);
        $query = DB::table('atk_barangs')->get();

        $cart = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('id_pics','=',$id)->where('atk_carts.status','=','0')->take(3)->get();

        return view('/app/stok', compact('query','barang','cart'));
    }

    
    public function carts()
    {
        
        $id = Auth::user()->id_pics;
        // $barang = DB::table('atk_carts')->orderby('id_barang','desc')->where('atk_carts.status','=','0')->orderby('id_cart','desc')->get();
        $query = DB::table('atk_barangs')->get();

        // $barang = DB::table('atk_barangs')->where('id_user','=',$id)->where('status','=','0')->orderby('id_barang','desc')->paginate(10);
        $cart = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('atk_carts.id_pics','=',$id)->where('atk_carts.status','=','0')->get();

        return view('/app/cart', compact('cart','query'));
    }

    public function datacart()
    {
        
        $id = Auth::user()->id;
        // $barang = DB::table('atk_carts')->orderby('id_barang','desc')->where('atk_carts.status','=','0')->orderby('id_cart','desc')->get();
        $query = DB::table('atk_barangs')->get();

        // $barang = DB::table('atk_barangs')->where('id_user','=',$id)->where('status','=','0')->orderby('id_barang','desc')->paginate(10);
        $cart = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('atk_carts.id_pics','=',$id)->where('atk_carts.status','=','0')->get();

        return view('/app/editcart', compact('cart','query'));
    }

    public function cartsall()
    {
        
        $id = Auth::user()->id;
        // $barang = DB::table('atk_carts')->orderby('id_barang','desc')->where('atk_carts.status','=','0')->orderby('id_cart','desc')->get();
        $query = DB::table('atk_barangs')->get();

        // $barang = DB::table('atk_barangs')->where('id_user','=',$id)->where('status','=','0')->orderby('id_barang','desc')->paginate(10);
        $cart = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('id_user','=',$id)->where('atk_carts.status','=','0')->get();

        return view('/app/cart', compact('cart','query'));
    }


    public function details($id)
    { 
        
        // $ids = Auth::user()->id;
        $row = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('id_user','=',Auth::user()->id)->where('atk_carts.status','=','0')->take(3)->get();

        $data = DB::table('atk_barangs')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
        ->orderBy('atk_barangs.id_barang','asc')->get();

        $satuan = DB::table('atk_satuans')
        ->orderBy('atk_satuans.id_satuan','asc')->get();

        $barangs = DB::table('atk_barangs')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
        ->where('id_barang',$id)->first();

        
      return view ('/app/details', compact('barangs','satuan','data','row'));
    }

    public function insert(Request $request)
    {

               
                $id_barang= $request->input('id_barang');
                $nm_barang = $request->input('nm_barang');
                $id_satuan= $request->input('id_satuan');
                $foto = $id_barang.'.'.date('dmYHis').'.'.$request->foto->getClientOriginalName();
                $filefoto = $request->foto->storeAs('public/lampiran', $foto);

                $barang = new atk_barang;
                $barang->id_barang = $id_barang;
                $barang->nm_barang = $nm_barang;
                $barang->id_satuan = $id_satuan;
                $barang->foto = $foto;
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

        $barangs = DB::table('atk_barangs')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
        ->where('id_barang',$id)->first();

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

    public function insertcart(Request $request)
    {

               
                $id_barang= $request->input('id_barang');
                $jml = $request->input('jml');
                $id = Auth::user()->id;
            

                $barang = new atk_cart;
                $barang->id_barang = $id_barang;
                $barang->jml = $jml;
                $barang->pics = $id;
                $barang->save();

                Session::flash('success_massage','Berhasil disimpan.');
                return redirect('/barangs');

    }

    public function editcart($id)
    { 
        
        $iduser = Auth::user()->id;
        $cartk = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('id_user','=',$iduser)->where('atk_carts.status','=','0')->get();

        $data = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->where('atk_carts.id_cart',$id)->first();

        $satuan = DB::table('atk_satuans')
        ->orderBy('atk_satuans.id_satuan','asc')->get();

        $barangs = DB::table('atk_barangs')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->get();

      return view ('/app/editcart', compact('barangs','satuan','data','cartk'));
    }


    public function updatecart(Request $request,$id)
    {
    $barang = atk_cart::find($id);
  
    $barang->id_barang = $request->id_barang;
    $barang->jml = $request->jml;
    $barang->save();


    Session::flash('success_massage','Data Pelamar, berhasil di edit');
    return redirect('/cart');
    }




    public function destroycart($id)
    {
        $cart = atk_cart::findOrFail($id);

        atk_cart::destroy($id);
        return response()->json([
            'success' => true,
            'message' => 'Contact Deleted'
        ]);
        
    }

    public function confirms()
    {
    
        $id_pics = Auth::user()->id_pics;
        $confirm = DB::table('atk_carts')->where('id_pics','=',$id_pics)->where('status','=','0')->get();


  
  
        
    foreach ($confirm as $confirms){
        $ids = $confirms->id_cart;
        $carts = atk_cart::find($ids); 
        $carts->status = '1'; 
        $carts->save(); 

        };

        Session::flash('success_massage','Berhasil disimpan.');
        return redirect('/barangs');


    }

    public function datacartupdate(Request $request)
    {
    

        foreach($request->id_cart as $key => $value){ 

            $quarters = atk_cart::find($request->id_cart[$key]); 
            $quarters->jml = $request->jml[$key]; 
            $quarters->save(); 
      }

      


        return redirect('/cart');


    }

    public function orderlist()
    {
        
        $id = Auth::user()->id_pics;
        // // $barang = DB::table('atk_carts')->orderby('id_barang','desc')->where('atk_carts.status','=','0')->orderby('id_cart','desc')->get();
       
        $query = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->select('*',DB::raw('DATE(atk_carts.created_at) as dates'))->where('atk_carts.id_pics','=',$id)->groupBy('atk_carts.status','dates')->get();
        // // $barang = DB::table('atk_barangs')->where('id_user','=',$id)->where('status','=','0')->orderby('id_barang','desc')->paginate(10);
        $cart = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('atk_carts.id_pics','=',$id)->where('atk_carts.status','=','0')->get();

        

        return view('/app/orderlist', compact('query','cart'));
    }

    public function detailorderlist()
    {
        
        $id = Auth::user()->id_pics;
        // // $barang = DB::table('atk_carts')->orderby('id_barang','desc')->where('atk_carts.status','=','0')->orderby('id_cart','desc')->get();
       
        // $query = DB::table('atk_carts')
        // ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        // ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->select('*',DB::raw('DATE(atk_carts.created_at) as dates'))->where('atk_carts.id_pics','=',$id)->groupBy('atk_carts.status','dates')->get();
        // // $barang = DB::table('atk_barangs')->where('id_user','=',$id)->where('status','=','0')->orderby('id_barang','desc')->paginate(10);
        // $cart = DB::table('atk_carts')
        // ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        // ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('atk_carts.id_pics','=',$id)->where('atk_carts.status','=','0')->get();

        $query = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('atk_carts.id_pics','=',$id)->groupBy('atk_carts.status','dates')->get();

        

        return view('/app/orderlist', compact('query','cart'));
    }

}
