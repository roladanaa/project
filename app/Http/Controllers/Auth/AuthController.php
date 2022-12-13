<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Carbon\Carbon;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function loginPage(Request $request){
        session()->put('guard',$request->guard);
        return view('auth.login');
    }

    public function login(Request $request){
        $guard = session()->get('guard');
        $validator = Validator($request->all(),[
            'email'=>'required|email',
            'password'=>'required|string|max:12',
            'remember'=>'nullable|boolean'
        ]);
        if(!$validator->fails()){
            $credentials = [
                'email'=>$request->input('email'),
                'password'=>$request->input('password')
            ];
            if(Auth::guard($guard)->attempt($credentials,$request->remember)){
                return response()->json(['title'=>__('msg.success'),'message'=>__('msg.sucess_login')],Response::HTTP_OK);
            }else{
                return response()->json(['title'=>__('msg.error'),'message'=>__('msg.error_data_login')],Response::HTTP_BAD_REQUEST);
            }
        }else{
            return response()->json(['title'=>__('msg.error'),'message'=>$validator->getMessageBag()->first()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function logoutUser(){
        Auth::logout();
        return redirect()->route('auth.choise_guard');
    }
    
    public function blockAccount(){
        return view('auth.block');
    }


    public function choiseGuard(Request $request){
        return view('auth.choise-guard');
    }
}
