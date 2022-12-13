<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(User::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();
        return view('user.index',[
            'users' => $users
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //
        return view('user.details',[
            'user' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
        $isDelete = $user->delete();
        return response()->json([
            'title' => $isDelete ? __('msg.success') : __('msg.error'),
            'message' =>$isDelete ? __('msg.success_delete') : __('msg.error_delete')
        ],$isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }


    public function changeStatus(User $user){
        if($user->status == 'active'){
            $user->status = 'block';
        }else{
            $user->status = 'active';
        }
        $isSave = $user->save();
        return response()->json([
            'title' => $isSave ? __('msg.success') : __('msg.error'),
            'message' =>$isSave ? __('msg.success_action') : __('msg.error_action')
        ],$isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showReport(User $user){
        return view('user.report',[
            'user' => $user
        ]);
    }

    public function editUserPermission(Request $request , User $user){
        $permissions = Permission::where('guard_name','users')->get();
        $adminPermissions = $user->permissions;
        if(count($adminPermissions) > 0){
            foreach($permissions as $permission){
                $permission->setAttribute('assign',false);
                foreach($adminPermissions as $empPermission){
                    if($empPermission->id == $permission->id){
                        $permission->setAttribute('assign',true);
                    }
                }
            }
        }
        return view('user.permission',['user'=>$user,'permissions'=>$permissions]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Patient  $patient
     * @return \Illuminate\Http\Response
     */
    public function updateUserPermission(Request $request , User $user ){

        $validator = Validator($request->all(),[
            'permission_id' =>'required|exists:permissions,id'
        ]);

        if(!$validator->fails()){
            $permission = Permission::findOrFail($request->input('permission_id'));
            if($user->hasPermissionTo($permission)){
                $user->revokePermissionTo($permission);
            }else{
                $user->givePermissionTo($permission);
            }
            return response()->json([
                'title' => __('msg.success'),
            'message' => __('msg.giv_permission')
            ],Response::HTTP_OK);
        }else{
        return response()->json(['title'=>__('msg.error'),'message'=>$validator->getMessageBag()->first()],Response::HTTP_BAD_REQUEST);
        }
    }

    
}
