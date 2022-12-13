<?php

namespace App\Http\Controllers;

use App\Http\Helper\ApiMsg;
use App\Mail\SendCodeChargeEmail;
use App\Mail\SendDetailsChargeEmail;
use App\Models\CodeCharge;
use App\Models\Employee;
use App\Models\HistoryWallet;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Broadcasting\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpFoundation\Response;

class ChargeController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(HistoryWallet::class,'charge');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $charges = auth()->user()->senderWalletUsers;
        return view('charge.index',[
            'charges' =>$charges
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('charge.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //
        $validator = Validator($request->all(),[
            'mobile' =>'required|string|exists:users,mobile',
            'amount' =>'required|numeric',
            'code' => 'required|exists:code_charges,code',
            'description' => 'nullable|string',
        ]);

        if(!$validator->fails()){
            if($this->verifiedCheck($request) === true){

                //code
            $resever = User::where('mobile',$request->input('mobile'))->first();
            $sender = auth()->user();

            $reseverWallet = Wallet::where('user_id',$resever->id)->first();



            // Create History For Wallet on two users
            $sender->senderWalletUsers()->create([
                'type' => 'Charge',
                'amount' => $request->input('amount'),
                'description' => $request->input('description'),
                'user_id' => $resever->id
            ]);

            // Update balance on two users
            $reseverWallet->balance = intval($reseverWallet->balance) + intval($request->input('amount'));
            $reseverWallet->save();

            $dataCharge = [
                'sender' => $sender,
                'reseverWallet' => $reseverWallet,
                'amount' => $request->input('amount')
            ];

            Mail::to($resever)->send(new SendDetailsChargeEmail($dataCharge));

                return response()->json([
                    'title' => __('msg.success'),
                    'message' => __('msg.success_create')
                ],Response::HTTP_OK);
            }else{
                return $this->verifiedCheck($request);
            }
        }else{
            return response()->json([
                'status'=>false,
                'title'=> __('msg.error'),
                'message'=> $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
        
        
    }




    public function userInfo(Request $request){
        $validator = Validator($request->all(),[
            'mobile' =>'required|string|exists:users,mobile'
        ]);
        if(!$validator->fails()){
            $user = User::where('mobile',$request->input('mobile'))->with('wallet')->first();
            return response()->json($user,Response::HTTP_OK);
        }else{
            return response()->json([
                'title'=> __('msg.error'),
                'message' => $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function sendCodeVerificationCharge(Request $request){
       
        CodeCharge::where('email',auth()->user()->email)->delete();
        $code =  mt_rand(100000,999999);
        $verified = new CodeCharge;
        $verified->email = auth()->user()->email;
        $verified->code = $code;
        $verified->save();

        Mail::to(auth()->user())->send(new SendCodeChargeEmail($code));

        return response()->json([
            'status'=>true,
            'message'=> ApiMsg::getMsg($request,'send_code'),
        ],Response::HTTP_OK);

    
}

    public function verifiedCheck(Request $request){
       

            $code = CodeCharge::where('code',$request->input('code'))->first();
            if($this->isExpireCode($request,$code->created_at)){
                $code->delete();
            }
        return true;
        
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
