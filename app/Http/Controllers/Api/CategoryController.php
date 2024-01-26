<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\ApiController;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CategoryController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $paginate =  $request->input('paginate', 0);
        if ($paginate !== 0) {
            $categories = Category::paginate($paginate);
            $links = CategoryResource::collection($categories)->response()->getData()->links;
            $meta = CategoryResource::collection($categories)->response()->getData()->meta;

            return  $this->successPagintaeResponse("categories", CategoryResource::collection($categories), $links, $meta, $paginate, 200, "List of categories " . $paginate . " to " . $paginate . ":");
        } else {
            $categories = Category::all();
            return $this->successResponse(CategoryResource::collection($categories), 200, "List all of categories:");
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/|unique:categories,name',
            'parent_id' => 'regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'display_name' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/|unique:categories,name',
            'description' => 'regex:/^[a-zA-Z0-9آ-ی\s]+$/'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        DB::beginTransaction();

        $category = Category::create([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);
        return  $this->successResponse(new CategoryResource($category), 201, 'created successfully');

        DB::commit();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return  $this->successResponse(new CategoryResource($category), 200, 'category list of ' . $category->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/|unique:categories,name',
            'parent_id' => 'regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'display_name' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/|unique:categories,name',
            'description' => 'regex:/^[a-zA-Z0-9آ-ی\s]+$/'
        ]);
        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        DB::beginTransaction();
        $category->update([
            'name' => $request->name,
            'display_name' => $request->display_name,
            'description' => $request->description,
        ]);
        return  $this->successResponse(new CategoryResource($category), 200, "updated successfully");

        DB::commit();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        $category->delete();
        DB::commit();
        return  $this->successResponse(new CategoryResource($category), 200, "deleted successfully");
    }
}
