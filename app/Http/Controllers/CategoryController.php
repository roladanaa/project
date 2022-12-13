<?php

namespace App\Http\Controllers;

use App\Http\Trait\CustomTrait;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    use CustomTrait;

    public function __construct()
    {
        $this->authorizeResource(Category::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::where('compony_id',auth()->user()->id)->get();
        return view('category.index',[
            'category' => $category
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
        return view('category.create');
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
            'active' => 'nullable',
        ]);

        if(!$validator->fails()){

            $category = new Category;
            $category->name_en = $request->input('name_en');
            $category->name_ar = $request->input('name_ar');
            $category->compony_id = auth()->user()->id;
            if($request->hasFile('image')){
                $filePath = $this->uploadFile($request->file('image'));
            }
            $category->image = $filePath;
            $category->status = $request->input('active') == 'true' ? 'active' : 'block';
            $category->save();

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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        return view('category.show',[
            'category' => $category
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        return view('category.edit',[
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        $validator = Validator($request->all(),[
            'name_en' => 'required|string',
            'name_ar' => 'required|string',
            'active' => 'nullable',
            'image' => $this->getImageValidate($request->hasFile('image'))['image'],
        ]);

        if(!$validator->fails()){

            $category->name_en = $request->input('name_en');
            $category->name_ar = $request->input('name_ar');
            $category->compony_id = auth()->user()->id;
            if($request->hasFile('image')){
                $filePath = $this->uploadFile($request->file('image'));
                $category->image = $filePath;
            }
            $category->status = $request->input('active') == 'true' ? 'active' : 'block';
            $category->save();

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
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        $isDelete = $category->delete();
        return response()->json([
            'title' => $isDelete ? __('msg.success') : __('msg.error'),
            'message' =>$isDelete ? __('msg.success_delete') : __('msg.error_delete')
        ],$isDelete ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }


    public function changeStatus(Category $category){
        if($category->status == 'active'){
            $category->status = 'block';
        }else{
            $category->status = 'active';
        }
        $isSave = $category->save();
        return response()->json([
            'title' => $isSave ? __('msg.success') : __('msg.error'),
            'message' =>$isSave ? __('msg.success_action') : __('msg.error_action')
        ],$isSave ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
    }
}
