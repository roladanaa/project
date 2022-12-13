<?php

namespace App\Http\Controllers;

use App\Http\Trait\CustomTrait;
use App\Models\Category;
use App\Models\City;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubCategoryController extends Controller
{
    use CustomTrait;

    public function __construct()
    {
        $this->authorizeResource(SubCategory::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $subCategory = SubCategory::whereHas('category',function($q){
            $q->where('compony_id',auth()->user()->id);
        })->get();
        return view('subcategory.index',[
            'subCategory' => $subCategory
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
        $city = City::where('active',true)->get();
        $category = Category::where('status','active')->where('compony_id',auth()->user()->id)->get();
        return view('subcategory.create',[
            'city' => $city,
            'category' => $category
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
            'image' => 'required|image|mimes:jpg,png,jpeg,gif',
            'category_id' => 'required|exists:categories,id',
            'city_id' => 'required|exists:cities,id',
            'active' => 'nullable',
        ]);

        if(!$validator->fails()){

            $subCategory = new SubCategory;
            $subCategory->name_en = $request->input('name_en');
            $subCategory->name_ar = $request->input('name_ar');
            if($request->hasFile('image')){
                $filePath = $this->uploadFile($request->file('image'));
            }
            $subCategory->image = $filePath;
            $subCategory->category_id = $request->input('category_id');
            $subCategory->city_id = $request->input('city_id');
            $subCategory->status = $request->input('active') == 'true' ? 'active' : 'block';
            $subCategory->save();

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
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
        return view('subcategory.details',[
            'subCategory' => $subCategory
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        //
        $city = City::where('active',true)->get();
        $category = Category::where('status','active')->get();
        return view('subcategory.edit',[
            'subCategory' => $subCategory,
            'city' => $city,
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        //
        $validator = Validator($request->all(),[
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'image' => $this->getImageValidate($request->hasFile('image'))['image'],
            'category_id' => 'required|exists:categories,id',
            'city_id' => 'required|exists:cities,id',
            'active' => 'nullable',
        ]);

        if(!$validator->fails()){

            $subCategory->name_en = $request->input('name_en');
            $subCategory->name_ar = $request->input('name_ar');
            if($request->hasFile('image')){
                $filePath = $this->uploadFile($request->file('image'));
            }
            $subCategory->image = $filePath;
            $subCategory->category_id = $request->input('category_id');
            $subCategory->city_id = $request->input('city_id');
            $subCategory->status = $request->input('active') == 'true' ? 'active' : 'block';
            $subCategory->save();

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

    public function getImageValidate($bool){
        if($bool){
            return ['image' => 'required|image|mimes:jpg,png,jpeg,gif'];
        }
        return ['image' => 'nullable'];
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubCategory $subCategory)
    {
        //
        $isDelete = $subCategory->delete();
        return response()->json([
            'title' => $isDelete ? __('msg.success') : __('msg.error'),
            'message' =>$isDelete ? __('msg.success_delete') : __('msg.error_delete')
        ],$isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }


    public function changeStatus(SubCategory $subCategory){
        if($subCategory->status == 'active'){
            $subCategory->status = 'block';
        }else{
            $subCategory->status = 'active';
        }
        $isSave = $subCategory->save();
        return response()->json([
            'title' => $isSave ? __('msg.success') : __('msg.error'),
            'message' =>$isSave ? __('msg.success_action') : __('msg.error_action')
        ],$isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }

    public function showReport(SubCategory $subCategory){
        $total = 0;

        foreach($subCategory->walletSubCategory as $w){
            $total += $w->balance;

        }
        $subCategory->setAttribute('total',$total);
        return view('subcategory.report',[
            'subCategory' => $subCategory
        ]);
    }
}
