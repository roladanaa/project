<?php

namespace App\Http\Controllers;

use App\Models\PayPoint;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Symfony\Component\HttpFoundation\Response;

class RolePermissionController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::all();
        return view('role.index',[
            'roles' => $roles
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

        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator($request->all(),[
            'name' => 'required|string',
            'guard' => 'required|string|in:users,compony,employee,point',
        ]);

        if(!$validator->fails()){
            $role = new Role;
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard');
            $role->save();

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


        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        // 
        $permissions = Permission::where('guard_name',$role->guard_name)->get();
        $rolePermission = $role->permissions;
        if(count($rolePermission) > 0){
            foreach($permissions as $perm){
                $perm->setAttribute('assign',false);
                foreach($rolePermission as $rolePerm){
                    if($rolePerm->id == $perm->id){
                        $perm->setAttribute('assign',true);
                    }
                }
            }
        }
            return view('role.permission',[
            'role' => $role,
            'permissions' => $permissions
        ]);
    }


    public function givPermissionRole(Request $request, Role $role){

        $validator = Validator($request->all(),[
            'permission_id' => 'required|exists:permissions,id'
        ]);
        if(!$validator->fails()){

            $permission = Permission::findOrFail($request->input('permission_id'));
            if($role->hasPermissionTo($permission)){
                $role->revokePermissionTo($permission);
            }else{
                $role->givePermissionTo($permission);
            }
            return response()->json([
                'title'=> __('msg.success'),
                'message' => __('msg.giv_permission')
            ],Response::HTTP_OK);

        }else{
            return response()->json([
                'title'=> __('msg.error'),
                'message' => $validator->getMessageBag()->first()
            ],Response::HTTP_BAD_REQUEST);
        }
    }




    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        //
        return view('role.edit',[
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        //
        $validator = Validator($request->all(),[
            'name' => 'required|string',
            'guard' => 'required|string|in:users,compony,employee,point',
        ]);

        if(!$validator->fails()){
            $role->name = $request->input('name');
            $role->guard_name = $request->input('guard');
            $role->save();

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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //
        $isDelete = $role->delete();
        return response()->json([
            'title' => $isDelete ? __('msg.success') : __('msg.error'),
            'message' =>$isDelete ? __('msg.success_delete') : __('msg.error_delete')
        ],$isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
