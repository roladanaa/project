<?php

namespace App\Http\Controllers;

use App\Mail\SendDataPayPointEmail;
use App\Models\Compony;
use App\Models\Employee;
use App\Models\PayPoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Str;
class PayPointController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(PayPoint::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $pays = PayPoint::where('compony_id',auth()->user()->id)->get();
        return view('paypoint.index',[
            'pays' => $pays
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $compony = Compony::all();
        $roles = Role::where('guard_name','point')->get();
        return view('paypoint.create',[
            'compony' => $compony,
            'roles' => $roles
        ]);
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
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|string',
            'compony_id' => 'required|exists:componies,id',
            'role_id' => 'required|exists:roles,id',
            
        ]);

        if(!$validator->fails()){

            $payPoint = new PayPoint;
            $payPoint->name_en = $request->input('name_en');
            $payPoint->name_ar = $request->input('name_ar');
            $payPoint->mobile = $request->input('mobile');
            $payPoint->email = $request->input('email');
            $payPoint->compony_id = $request->input('compony_id');
            $password = Str::random(6);
            $payPoint->password = Hash::make($password);
            $payPoint->save();

            // givRole
            $payPoint->syncRoles(Role::findOrFail($request->input('role_id')));
            //Send Email To Pay Point
            Mail::to($payPoint)->send(new SendDataPayPointEmail($payPoint,$password));

            return response()->json([
                'title'=> __('msg.success'),
                'message' => __('msg.success_create')
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'title'=> __('msg.error'),
                'message' => $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PayPoint  $payPoint
     * @return \Illuminate\Http\Response
     */
    public function show(PayPoint $payPoint)
    {
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

        return view('paypoint.details',[
            'payPoint' => $payPoint,
            'employee' => $employee
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PayPoint  $payPoint
     * @return \Illuminate\Http\Response
     */
    public function edit(PayPoint $payPoint)
    {
        //
        $compony = Compony::all();
        $roles = Role::where('guard_name','point')->get();
        return view('paypoint.edit',[
            'payPoint' => $payPoint,
            'compony' => $compony,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PayPoint  $payPoint
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PayPoint $payPoint)
    {
        //
        $validator = Validator($request->all(),[
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'mobile' => 'required|string',
            'email' => 'required|string',
            'compony_id' => 'required|exists:componies,id',
            'role_id' => 'required|exists:roles,id',

        ]);

        if(!$validator->fails()){

            $payPoint->name_en = $request->input('name_en');
            $payPoint->name_ar = $request->input('name_ar');
            $payPoint->mobile = $request->input('mobile');
            $payPoint->email = $request->input('email');
            $payPoint->compony_id = $request->input('compony_id');
            $payPoint->save();

            $payPoint->syncRoles(Role::findOrFail($request->input('role_id')));
            return response()->json([
                'title'=> __('msg.success'),
                'message' => __('msg.success_edit')
            ],Response::HTTP_OK);
        }else{
            return response()->json([
                'title'=> __('msg.error'),
                'message' => $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PayPoint  $payPoint
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayPoint $payPoint)
    {
        //
        $isDelete = $payPoint->delete();
        return response()->json([
            'title' => $isDelete ? __('msg.success') : __('msg.error'),
            'message' =>$isDelete ? __('msg.success_delete') : __('msg.error_delete')
        ],$isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }


    public function changeStatus(PayPoint $payPoint){
        if($payPoint->status == 'active'){
            $payPoint->status = 'block';
        }else{
            $payPoint->status = 'active';
        }
        $isSave = $payPoint->save();

        return response()->json([
            'title' => $isSave ? __('msg.success') : __('msg.error'),
            'message' =>$isSave ? __('msg.success_action') : __('msg.error_action')
        ],$isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showReport(PayPoint $payPoint){
        $total = 0;
        $employee = Employee::where('pay_point_id',$payPoint->id)->get();
        foreach($employee as $e){
            foreach($e->senderWalletUsers as $s){
                $total += $s->amount;
            }
        }
        $payPoint->setAttribute('total',$total);
        return view('paypoint.report',[
            'paypoint' => $payPoint,
            'employee' => $employee
        ]);
    }

    public function resourceAbilityMap(){
        return [
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            'showReport'=>'showReport'
        ];
    }

    /**
     * Get the list of resource methods which do not have model parameters.
     *
     * @return array
     */
    protected function resourceMethodsWithoutModels()
    {
        return ['index', 'create', 'store'];
    }
}
