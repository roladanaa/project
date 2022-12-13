<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Helper\ApiMsg;
use App\Http\Resources\HistoryWalletResource;
use App\Http\Resources\MainResource;
use App\Http\Resources\WalletResource;
use App\Models\HistoryWallet;
use App\Models\SubCategory;
use App\Models\User;
use App\Models\Wallet;
use App\Models\WalletSubCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function sendMonyToUser(Request $request){

        if(!auth()->user()->can('Send-mony')){
            return response()->json([
                'status' => false,
                'message' => 'unauthorized'
            ],Response::HTTP_FORBIDDEN);
        }

        $validator = Validator($request->all(),[
            'mobile' => 'required|string|exists:users,mobile',
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        if(!$validator->fails()){
            $resever = User::where('mobile',$request->input('mobile'))->first();
            $sender = auth()->user();

            // Get Wallet , because Update Relation table is Failed
            $senderWallet = Wallet::where('user_id',auth()->user()->id)->first();
            $reseverWallet = Wallet::where('user_id',$resever->id)->first();


            if($senderWallet->balance < $request->amount){
                return response()->json([
                    'status' => false,
                    'message' => ApiMsg::getMsg($request,'balance_lessthan')
                ],Response::HTTP_BAD_REQUEST);
            }


            // Create History For Wallet on two users
            $sender->senderWalletUsers()->create([
                'type' => 'Pay',
                'amount' => $request->input('amount'),
                'description' => $request->input('description'),
                'user_id' => $resever->id
            ]);

            // Update balance on two users
            $senderWallet->balance = intval($senderWallet->balance) - intval($request->input('amount'));
            $senderWallet->save();
            $reseverWallet->balance = intval($reseverWallet->balance) + intval($request->input('amount'));
            $reseverWallet->save();


            return response()->json(
                new MainResource(new WalletResource($senderWallet),Response::HTTP_OK,ApiMsg::getMsg($request,'success'))
                ,Response::HTTP_OK);

        }else{
            return response()->json([
                'status'=>false,
                'title'=> ApiMsg::getMsg($request,'error'),
                'message'=> $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function sendMonyToCategory(Request $request, SubCategory $subCategory){

        if(!auth()->user()->can('Send-mony')){
            return response()->json([
                'status' => false,
                'message' => 'unauthorized'
            ],Response::HTTP_FORBIDDEN);
        }
        $validator = Validator($request->all(),[
            'amount' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        if(!$validator->fails()){
            $resever = $subCategory;
            $sender = auth()->user();

            // Get Wallet , because Update Relation table is Failed
            $senderWallet = Wallet::where('user_id',auth()->user()->id)->first();



            if($senderWallet->balance < $request->input('amount')){
                return response()->json([
                    'status' => false,
                    'message' => ApiMsg::getMsg($request,'balance_lessthan')
                ],Response::HTTP_BAD_REQUEST);
            }

            
            // Update balance on two users
            $senderWallet->balance = intval($senderWallet->balance) - intval($request->input('amount'));
            $senderWallet->save();
            // Create History For Wallet on users
            $reseverWallet = new WalletSubCategory;
            $reseverWallet->balance = $request->input('amount');
            $reseverWallet->description = $request->input('description');
            $reseverWallet->user_id = $sender->id;
            $reseverWallet->sub_category_id = $resever->id;
            $reseverWallet->save();


            return response()->json(
                new MainResource(new WalletResource($senderWallet),Response::HTTP_OK,ApiMsg::getMsg($request,'success'))
                ,Response::HTTP_OK);

        }else{
            return response()->json([
                'status'=>false,
                'title'=> ApiMsg::getMsg($request,'error'),
                'message'=> $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function historyPay(Request $request){
        if(!auth()->user()->can('History-wallet')){
            return response()->json([
                'status' => false,
                'message' => 'unauthorized'
            ],Response::HTTP_FORBIDDEN);
        }
        $user = User::where('id',auth()->user()->id)->with(['senderWalletUsers','reseverWalletUsers','walletSubCategores'])->first();
        return response()->json(
            new MainResource(new HistoryWalletResource($user),Response::HTTP_OK,ApiMsg::getMsg($request,'success_get'))
        ,Response::HTTP_OK);
    }


    
}
