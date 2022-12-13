<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiMsg;
use App\Http\Resources\MainResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class AuthRegisterUserController extends Controller
{
    //

    public function register(Request $request){

        $validator = Validator($request->all(),[
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'mobile' => 'required|string|unique:users,mobile',
            'national_id' => 'required|string|unique:users,national_id',
            'password' => 'required|string|min:6|max:12',
            'city_id' => 'required|string|exists:cities,id',
        ]);

        if(!$validator->fails()){
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->mobile = $request->input('mobile');
            $user->national_id = $request->input('national_id');
            $user->password = Hash::make($request->input('password'));
            $user->city_id = $request->input('city_id');
            $user->save();

            // Create Wallet After Register
            $this->createWalletUser($user);

            $user->givePermissionTo('History-wallet','Send-mony','Read-subcategory','Read-category');

            return $this->grantPGCT($request);
        }else{
            return response()->json(
                new MainResource([],
                Response::HTTP_BAD_REQUEST,
                $validator->getMessageBag()->first()),
                Response::HTTP_BAD_REQUEST);
        }
    }

    public function grantPGCT(Request $request){
        $response = Http::asForm()->post(env('URL_API_TOKEN'),[
            'grant_type' => 'password',
            'client_id' => env('USER_CLIENT_ID'),
            'client_secret'=>env('USER_CLIENT_SECRET'),
            'username' => $request->input('email'),
            'password' =>$request->input('password'),
            'scope' => '*'
        ]);
        $jsonResponse = json_decode($response);
        $user = User::where('email',$request->input('email'))->first();
        $user->setAttribute('token',$jsonResponse->access_token);

        return response()->json(
        new MainResource(new UserResource($user),Response::HTTP_OK,ApiMsg::getMsg($request,'success'))
        ,Response::HTTP_OK);
    }

    public function createWalletUser(User $user){
            $wallet = new Wallet;
            $wallet->currency = 'USD';
            $wallet->balance = 0;
            $wallet->user_id = $user->id;
            $wallet->save();
    }
    
}
