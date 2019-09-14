<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Model\atk_barang;
use App\Model\atk_cart;
use App\Model\atk_tambah;
use App\Model\atk_gudang;
use Carbon\Carbon;
use App\Mail\CartMail;
use Illuminate\Support\Facades\Mail;

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
        $a=substr($query->id_barang, 2, 3);
        $b = $a + 1;
        if($query){

            if($b < 10){
                $id_barang="BR00$b";
            }else if($b < 100){
                $id_barang = "BR0$b";
            }else{
                $id_barang = "BR$b";
            }
            

        }else{
            $id_barang="BR001";
        }

        $data = DB::table('atk_barangs')
                ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
                ->orderBy('atk_barangs.id_barang','desc')->get();
        $satuan = DB::table('atk_satuans')
            ->orderBy('atk_satuans.id_satuan','asc')->get();


        return view('/app/barang', compact('id_barang','data','satuan','a'));
    }

    public function indexs()
    {
        
        $id = Auth::user()->id_pics;
        $barang = DB::table('atk_gudangs')->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')->where('atk_gudangs.pic','=',1)->orderby('atk_gudangs.id_barang','desc')->paginate(10);

        $query = DB::table('atk_barangs')->get();

        $cart = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('id_pics','=',$id)->where('atk_carts.status','=','0')->take(3)->get();

        return view('/app/stok', compact('query','barang','cart'));
    }

    
    public function addstockbarang()
    {
        
        $id = Auth::user()->id_pics;
        $barang = DB::table('atk_barangs')->whereNotIn('id_barang', function($q){
            $q->select('id_barang')->from('atk_gudangs')->where('atk_gudangs.pic','=',1);
        })->get();

        
        return view('/app/addstockbarang', compact('barang'));
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
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('id_pics','=',Auth::user()->id_pics)->where('atk_carts.status','=','0')->take(3)->get();

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
                $harga = $request->input('harga');
                $hargafix = str_replace(".", "", $harga);
                $min_ga= $request->input('min_ga');
                $max_ga = $request->input('max_ga');
                $min_cab= $request->input('min_cab');
                $max_cab= $request->input('max_cab');
                $photo= $request->input('foto');
               
                if($request->foto == NULL){
                    $barang = new atk_barang;
                    $barang->id_barang = $id_barang;
                    $barang->nm_barang = $nm_barang;
                    $barang->id_satuan = $id_satuan;
                    $barang->harga = $hargafix;
                    $barang->min_ga = $min_ga;
                    $barang->max_ga = $max_ga;
                    $barang->min_cab = $min_cab;
                    $barang->max_cab = $max_cab;
                    $barang->foto = NULL;
                    $barang->save();
                }else{
                   
                    $foto = $id_barang.'.'.date('dmYHis').'.'.$request->foto->getClientOriginalName();
                    $filefoto = $request->foto->storeAs('public/lampiran', $foto);
                    $barang = new atk_barang;
                    $barang->id_barang = $id_barang;
                    $barang->nm_barang = $nm_barang;
                    $barang->id_satuan = $id_satuan;
                    $barang->harga = $hargafix;
                    $barang->min_ga = $min_ga;
                    $barang->max_ga = $max_ga;
                    $barang->min_cab = $min_cab;
                    $barang->max_cab = $max_cab;
                    $barang->foto = $foto;
                    $barang->save();
                }
                

                Session::flash('success_massage','Berhasil disimpan.');
                return redirect('/barang');

    }

    public function edit($id)
    { 
        $data = DB::table('atk_barangs')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
        ->orderBy('atk_barangs.id_barang','desc')->get();

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
    if($request->foto == NULL){
        $barang->nm_barang = $request->nm_barang;
        $barang->id_satuan = $request->id_satuan;
        $barang->harga = $request->harga;
        $barang->min_ga = $request->min_ga;
        $barang->max_ga = $request->max_ga;
        $barang->min_cab = $request->min_cab;
        $barang->max_cab = $request->max_cab;
        $barang->save();
    }else{
        $foto = $barang->id_barang.'.'.date('dmYHis').'.'.$request->foto->getClientOriginalName();
        $filefoto = $request->foto->storeAs('public/lampiran', $foto);
        $barang->nm_barang = $request->nm_barang;
        $barang->id_satuan = $request->id_satuan;
        $barang->harga = $request->harga;
        $barang->min_ga = $request->min_ga;
        $barang->max_ga = $request->max_ga;
        $barang->min_cab = $request->min_cab;
        $barang->max_cab = $request->max_cab;
        $barang->foto = $foto;
        $barang->save();
    }


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
                $barang->id_pics = $id;
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
        $user = DB::table('atk_pics')->where('id_pics','=',$id_pics)->first();
        
    foreach ($confirm as $confirms){
        $ids = $confirms->id_cart;
        $carts = atk_cart::find($ids); 
        $carts->status = '1'; 
        $carts->save(); 

        };

        Mail::to("it.bprmaa@gmail.com")->send(new CartMail($user));
        
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

    public function detailorderpic($status, $date,  $id)
    {
        
        // $id = Auth::user()->id_pics;
        // // $barang = DB::table('atk_carts')->orderby('id_barang','desc')->where('atk_carts.status','=','0')->orderby('id_cart','desc')->get();
       
        // $query = DB::table('atk_carts')
        // ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        // ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->select('*',DB::raw('DATE(atk_carts.created_at) as dates'))->where('atk_carts.id_pics','=',$id)->groupBy('atk_carts.status','dates')->get();
        // // $barang = DB::table('atk_barangs')->where('id_user','=',$id)->where('status','=','0')->orderby('id_barang','desc')->paginate(10);
        // $cart = DB::table('atk_carts')
        // ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        // ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')->where('atk_carts.id_pics','=',$id)->where('atk_carts.status','=','0')->get();

        $query = DB::table('atk_gudangs')->orderBy('id_gudang_brg', 'DESC')->first();
       
       
        if($query != NULL){
        //     $a=substr($query->id_gudang_brg, 2, 3);

            $id_barang = $query->id_gudang_brg;
    
        //     if($b < 10){
        //         $id_barang="GK00$b";
        //     }else if($b < 100){
        //         $id_barang = "GK0$b";
        //     }else{
        //         $id_barang = "GK$b";
        //     }
            

        }else{
            $id_barang="1";
        }
       

        $query = DB::table('atk_carts')
        ->join('atk_barangs','atk_carts.id_barang','=','atk_barangs.id_barang')
        ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
        ->join('atk_gudangs','atk_carts.id_barang','=','atk_gudangs.id_barang')
        ->select('atk_barangs.id_barang','atk_barangs.foto','atk_barangs.nm_barang','atk_carts.jml as jmlorder','atk_carts.id_cart','atk_carts.id_pics','atk_satuans.nm_satuan','atk_gudangs.jml as jmlstok',DB::raw('DATE(atk_carts.created_at) as dates'))->whereDate('atk_carts.created_at', '=', $date)->where('atk_carts.id_pics','=',$id)->where('atk_carts.status','=',$status)->where('atk_gudangs.pic','=',1)->get();

        

        return view('/app/orderdetail', compact('query','id_barang'));
    }

    public function updateorder(Request $request)
    {
    


        $querynow = Carbon::now();
        $monthnow = $querynow->month;
        $yearnow = $querynow->year;
      
        foreach($request->id_cart as $key => $value){ 

            $carts = atk_cart::find($request->id_cart[$key]); 
            $carts->status = '2'; 
            $carts->save(); 


            $stokcab = DB::table('atk_gudangs')
            ->where('id_barang',$request->id_barang[$key])
            ->where('pic',$request->id_pics[$key])
            ->first();

            if($stokcab == NULL){
                    $insert = new atk_gudang;
                    $insert->id_gudang_brg = $request->id_gudang_brg[$key];
                    $insert->id_barang =  $request->id_barang[$key];
                    $insert->pic = $request->id_pics[$key];
                    $insert->jml = $request->jml[$key];
                    $insert->save();
            }else{

                    $trans = atk_gudang::find($stokcab->id_gudang_brg);
                    // $jmlawal =;
                    $total = $trans->jml + $request->jml[$key];
            
                    $trans->jml = $total;
                    
                    $trans->save();
            
            }
            
            $transtotals =  DB::table('atk_gudangs')
            ->where('id_barang',$request->id_barang[$key])
            ->where('pic',1)
            ->first();

            $transtotal = atk_gudang::find($transtotals->id_gudang_brg);
            $totalbarang = $transtotal->jml - $request->jml[$key];

            $transtotal->jml = $totalbarang;
            
            $transtotal->save();


            
            // $querys = DB::table('atk_gudangs')->where('pic','!=','GA')->orderBy('id_gudang_brg', 'DESC')->first();


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




    public function confirmsorder()
    {
    
        $id_pics = Auth::user()->id_pics;
        $confirm = DB::table('atk_carts')->where('id_pics','=',$id_pics)->where('status','=','2')->get();


  
  
        
        foreach ($confirm as $confirms){
        
            $ids = $confirms->id_cart;
            $carts = atk_cart::find($ids); 
            $carts->status = '3'; 
            $carts->save();

        };

        Session::flash('success_massage','Berhasil disimpan.');
        return redirect('/order-list');


    }

    public function stockcab(){
        
        $id = Auth::user()->id_pics;
        $sql = DB::table('atk_gudangs')
            ->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')
            ->join('atk_satuans','atk_barangs.id_satuan','=','atk_satuans.id_satuan')
            ->where('atk_gudangs.pic','=',$id)->get();

        return view('/app/stockcab',compact('sql'));
    }

}
