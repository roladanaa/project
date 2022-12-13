<?php

namespace App\Http\Controllers;

use App\Mail\SendDataEmployeeEmail;
use App\Models\City;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;
use Str;
class EmployeeController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Employee::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $employee = Employee::where('pay_point_id',auth()->user()->id)->get();
        return view('employee.index',[
            'employee' => $employee
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
        $city  = City::where('active',true)->get();
        $roles = Role::where('guard_name','employee')->get();
        return view('employee.create',[
            'city' => $city,
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
            'name' => 'required|string',
            'national_id' => 'required|string|unique:employees,national_id',
            'mobile' => 'required|string',
            'email' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'role_id' => 'required|exists:roles,id',
            
        ]);

        if(!$validator->fails()){

            $employee = new Employee;
            $employee->name = $request->input('name');
            $employee->mobile = $request->input('mobile');
            $employee->email = $request->input('email');
            $employee->national_id = $request->input('national_id');
            $employee->pay_point_id = auth()->user()->id;
            $employee->city_id = $request->input('city_id');
            $password = Str::random(6);
            $employee->password = Hash::make($password);
            $employee->save();

            // givRole
            $employee->syncRoles(Role::findOrFail($request->input('role_id')));
            //Send Email To Pay Point
            Mail::to($employee)->send(new SendDataEmployeeEmail($employee,$password));

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
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
        
        return view('employee.details',[
            'employee' => $employee,
            
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
        $city  = City::where('active',true)->get();
        $roles = Role::where('guard_name','employee')->get();
        return view('employee.edit',[
            'employee' => $employee,
            'city' => $city,
            'roles' => $roles
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
        $validator = Validator($request->all(),[
            'name' => 'required|string',
            'national_id' => 'required|string|unique:employees,national_id',
            'mobile' => 'required|string',
            'email' => 'required|string',
            'city_id' => 'required|exists:cities,id',
            'role_id' => 'required|exists:roles,id',
            
        ]);

        if(!$validator->fails()){

            $employee->name = $request->input('name');
            $employee->mobile = $request->input('mobile');
            $employee->email = $request->input('email');
            $employee->national_id = $request->input('national_id');
            $employee->pay_point_id = auth()->user()->id;
            $employee->city_id = $request->input('city_id');
            $password = Str::random(6);
            $employee->password = Hash::make($password);
            $employee->save();

            // givRole
            $employee->syncRoles(Role::findOrFail($request->input('role_id')));
            //Send Email To Pay Point

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
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
        $isDelete = $employee->delete();
        return response()->json([
            'title' => $isDelete ? __('msg.success') : __('msg.error'),
            'message' =>$isDelete ? __('msg.success_delete') : __('msg.error_delete')
        ],$isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function changeStatus(Employee $employee){
        if($employee->status == 'active'){
            $employee->status = 'block';
        }else{
            $employee->status = 'active';
        }
        $isSave = $employee->save();

        return response()->json([
            'title' => $isSave ? __('msg.success') : __('msg.error'),
            'message' =>$isSave ? __('msg.success_action') : __('msg.error_action')
        ],$isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showReport(Employee $employee){
        $total = 0;
        foreach($employee->senderWalletUsers as $e){
            $total += intval($e->amount);
        }
        $employee->setAttribute('total',$total);
        return view('employee.report',[
            'employee' => $employee
        ]);
    }
}
