<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\User;

use Auth;
use Session;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
             $barang = DB::table('atk_gudangs')->join('atk_barangs','atk_gudangs.id_barang','=','atk_barangs.id_barang')->where('atk_gudangs.pic','=',1)->where('atk_barangs.tipe','1')->orderby('atk_gudangs.id_barang','desc')->limit(8)->get();
             return view('home',compact('barang'));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    
    public function profile()
    {

        $query = User::findOrFail(Auth::user()->id);
       


        return view('/app/profile', compact('query'));
    }


    public function updateprofile(Request $request,$id)
    {
    $user = User::find($id);
  
    if($request->password == NULL){
    $user->name = $request->name;
    $user->email = $request->email;
    $user->save();
    }else{
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
    }

    Session::flash('success_massage','Data Pelamar, berhasil di edit');
    return redirect('/profile');
    }


}
