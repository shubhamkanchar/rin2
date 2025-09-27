<?php

namespace App\Http\Controllers;

use App\DataTables\UsersDataTable;
use App\Models\User;
use App\Rules\ValidPhoneNumber;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

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

    public function updateSetting(Request $request){
        $user = Auth::user();
        $validated = $request->validate([
            'is_notification' => 'nullable',
            'email'    => ['required','email', Rule::unique('users')->ignore($user->id)],
            'phone'    => ['nullable',new ValidPhoneNumber()],  // using laravel‑phone
        ]);

        try{
            $user->is_notification = isset($validated['is_notification']) ? 1 : 0;
            $user->email = $validated['email'];
            $user->phone = $validated['phone'];
            $user->save();
            notify()->success('Settings updated successfully');
        }catch(Exception $e){
            notify()->error($e->getMessage());
        }
        return redirect()->back();
    }
}
