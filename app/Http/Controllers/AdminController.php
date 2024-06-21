<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    public function go_login(){
        return view('login_admin');
    }

    public function go_register(){
        return view('register_admin');
    }

    public function get_admin(Request $request){
        $admin = true;
        $client = false;
        Session::put('client_page',$client);
        Session::put('admin_page', $admin);
        $email = $request->input('email');
        $pass = $request->input('pass');
        $admin = Admin::where('email',$email)
                ->where('mot_de_passe',$pass)
                ->get();
        Session::put('admin',$admin);
        return redirect()->route('defaut');
    }

    public function insert_admin(Request $request){
        $nom = $request->input('nom');
        $email = $request->input('email');
        $pass = $request->input('pass');
        $admin = Admin::create([
            'nom'=>$nom,
            'email'=>$email,
            'mot_de_passe'=>$pass
        ]);
        return redirect()->route('login');
    }

    public function logout(Request $request){
        $request->session()->forget('admin');
        return redirect()->route('login');
    }
}
