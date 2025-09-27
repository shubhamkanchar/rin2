<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    public function index(UsersDataTable $dataTable)
    {
        return $dataTable->render('welcome');
    }

    public function impersonate($id){
        $user = User::find($id);
        if($user){
            Auth::login($user);
            return redirect()->route('home');
        }
    }  
    
    public function setting(){
        return view('user.setting');
    }
}
