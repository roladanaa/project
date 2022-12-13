<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiMsg;
use App\Http\Resources\FatherResource;
use App\Http\Resources\MainResource;
use App\Http\Resources\TeacherResource;
use App\Http\Resources\UserResource;
use App\Mail\VerifiedUserPassword;
use App\Models\Father;
use App\Models\Teacher;
use App\Models\User;
use App\Models\VerifiedAccountCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\FuncCall;
use Symfony\Component\HttpFoundation\Response;

class AuthLoginController extends Controller
{
    
    public function login(Request $request){
        $validator = Validator($request->all(),[
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:12',
        ]);

        if(!$validator->fails()){
            $userLogin = User::where('email',$request->input('email'))->first();
            
            if(!is_null($userLogin)){
                if(Hash::check($request->input('password'), $userLogin->password)){
                    if($userLogin->status == 'block'){
                        return response()->json([
                            'status'=>false,
                            'title'=> ApiMsg::getMsg($request,'error'),
                            'message'=> ApiMsg::getMsg($request,'block_account')
                        ],Response::HTTP_BAD_REQUEST);
                    }
                   return $this->grantPGCT($request);
                }else{
                    return response()->json([
                        'status'=>false,
                        'message' => ApiMsg::getMsg($request,'password_faild')
                    ],Response::HTTP_BAD_REQUEST);
                }
            }else{
                return response()->json(
                    new MainResource([],Response::HTTP_BAD_REQUEST,ApiMsg::getMsg($request,'notfound_account')),
                    Response::HTTP_BAD_REQUEST
                );
            }

        }else{
            return response()->json([
                'status'=>false,
                'title'=> ApiMsg::getMsg($request,'error'),
                'message'=> $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    function grantPGCT(Request $request){
        $response = Http::asForm()->post(env('URL_API_TOKEN'),[
                'grant_type' => 'password',
                'client_id' => env('USER_CLIENT_ID'),
                'client_secret'=>env('USER_CLIENT_SECRET'),
                'username' => $request->input('email'),
                'password' =>$request->input('password'),
                'scope' => '*'
            ]);

        $decodedResponse = json_decode($response);
        $user = User::where('email',$request->input('email'))->first();
        $user->setAttribute('token',$decodedResponse->access_token);
        return response()->json(
            new MainResource(new UserResource($user),Response::HTTP_OK,ApiMsg::getMsg($request,'success_login')),
            Response::HTTP_BAD_REQUEST
        );     
    }

  


    public function logout(Request $request){
        $token = Auth::user()->token();
        $token->revoke();
        return response()->json([
            'status' => true,
            'message' => ApiMsg::getMsg($request,'success')
        ],Response::HTTP_OK);
    }




    public function sendEmailCodeVerified(Request $request){
       
            VerifiedAccountCode::where('email',auth()->user()->email)->delete();
            $code =  mt_rand(100000,999999);
            $verified = new VerifiedAccountCode;
            $verified->email = auth()->user()->email;
            $verified->code = $code;
            $verified->save();

            Mail::to(auth()->user())->send(new VerifiedUserPassword($code));

            return response()->json([
                'status'=>true,
                'message'=> ApiMsg::getMsg($request,'send_code'),
            ],Response::HTTP_OK);

        
    }
    public function verifiedCheck(Request $request){
        $validator = Validator($request->all(),[
            'code' => 'required|exists:verified_account_codes,code'
        ]);

        if(!$validator->fails()){

            $code = VerifiedAccountCode::where('code',$request->input('code'))->first();
            if($this->isExpireCode($request,$code->created_at)){
                $code->delete();
            }

            $user = auth()->user();
            $user->email_verified_at = now();
            $user->save();


            return response()->json([
                'status' => true,
                'message' => ApiMsg::getMsg($request,'success_verified')
            ],Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json([
                'status'=>false,
                'title'=> ApiMsg::getMsg($request,'error'),
                'message'=> $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function isExpireCode(Request $request,$createdAt){
        if($createdAt > now()->addHour()){
            return response()->json([
                'status'=>false,
                'title'=> ApiMsg::getMsg($request,'error'),
                'message'=> ApiMsg::getMsg($request,'expire_code')
            ],Response::HTTP_BAD_REQUEST);
        }
    }


}
