<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Employee;
use App\Models\PayPoint;
use App\Models\SubCategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::guard('point')->check()){
            return $this->getDataPayPoint();
        }elseif(Auth::guard('employee')->check()){
            return $this->getDataEmployee();
        }elseif(Auth::guard('compony')->check()){
            return $this->getDataCompony();
        }
        return view('index');


    }


    public function getDataCompony(){

        $employee = Employee::whereHas('PayPoint',function($q){
            $q->where('compony_id',auth()->user()->id);
        })->get();
        return view('index',[
            'compony' => auth()->user(),
            'pays' => PayPoint::where('compony_id',auth()->user()->id)->get(),
            'subCategory' => SubCategory::all(),
            'category' => Category::all(),
            'employee' => $employee,
            'users' => User::all(),
            'city' => City::all()
        ]);
    }



    public function getDataEmployee(){
        return view('index',[
            'employee' => auth()->user()
        ]);
    }

    public function getDataPayPoint(){
        $payPoint = auth()->user();
        $total = 0;
        $clients = 0;
        $total_charge = 0;
        $employee = Employee::where('pay_point_id',$payPoint->id)->get();
        foreach($employee as $e){
            foreach($e->senderWalletUsers as $s){
                $total += $s->amount;
                $clients++;
                $total_charge++;
            }
        }
        $payPoint->setAttribute('total',$total);
        $payPoint->setAttribute('empCount',$employee->count());
        $payPoint->setAttribute('clients',$clients);
        $payPoint->setAttribute('totalCharge',$total_charge);
        return view('index',[
            'payPoint' => $payPoint,
            'employee' => $employee
        ]);
    }

    public function setLocal(Request $request){

        $validator = Validator($request->all(),[
            'keylang' => 'required|string|in:en,ar'
        ]);
        if(!$validator->fails()){
            session()->put('lang', $request->input('keylang'));
            return response()->json(['message'=>'تم تغير اللغة بنجاح'],Response::HTTP_OK);
        }else{
            return response()->json(['message'=>$validator->getMessageBag()->first()],Response::HTTP_BAD_REQUEST);
        }
    }

    public function showNotification(){

        return view('admin.notification');
    }

    public function readNotification(){
        auth()->user()->unreadNotifications->markAsRead();
    }
}
