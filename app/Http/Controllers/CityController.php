<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CityController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(City::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $city = City::all();
        return view('city.index',[
            'city' => $city
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
        return view('city.create');
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
            'name_en'=>'required|string',
            'name_en'=>'required|string',
            'active'=>'required|boolean'
        ]);

        if(!$validator->fails()){
            $city = new City;
            $city->name_en = $request->input('name_en');
            $city->name_ar = $request->input('name_ar');
            $city->active = $request->input('active');
            $isSave = $city->save();
           
            
            return response()->json(['title'=>__('msg.success'),'message'=>$isSave ? __('msg.success_create') : __('msg.error_create')],Response::HTTP_OK);
        }else{
            return response()->json(['title'=>__('msg.error'),'message'=>$validator->getMessageBag()->first()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function show(City $city)
    {
        //
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function edit(City $city)
    {
        //
        return view('city.edit',[
            'city' => $city
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, City $city)
    {
        //
        $validator = Validator($request->all(),[
            'name_en'=>'required|string',
            'name_en'=>'required|string',
            'active'=>'nullable|boolean'
        ]);

        if(!$validator->fails()){
            $city->name_en = $request->input('name_en');
            $city->name_ar = $request->input('name_ar');
            $city->active = $request->input('active');
            $isSave = $city->save();
            return response()->json(['title'=>__('msg.success'),'message'=>$isSave ? __('msg.success_edit') : __('msg.error_edit')],Response::HTTP_OK);
        }else{
            return response()->json(['title'=>__('msg.error'),'message'=>$validator->getMessageBag()->first()],Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\Response
     */
    public function destroy(City $city)
    {
        //
        $isDelete = $city->delete();
        return response()->json([
            'title' => $isDelete ? __('msg.success') : __('msg.error'),
            'message' =>$isDelete ? __('msg.success_delete') : __('msg.error_delete')
        ],$isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
    
    public function changeStatus(City $city){
        if($city->active){
            $city->active = false;
        }else{
            $city->active = true;
        }
        $isSave = $city->save();

        return response()->json([
            'title' => $isSave ? __('msg.success') : __('msg.error'),
            'message' =>$isSave ? __('msg.success_action') : __('msg.error_action')
        ],$isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
