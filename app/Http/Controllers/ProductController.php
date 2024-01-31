<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductImages;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends ApiController
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
            $products = Product::paginate($paginate);
            $links = ProductResource::collection($products)->response()->getData()->links;
            $meta = ProductResource::collection($products)->response()->getData()->meta;

            return  $this->successPagintaeResponse("products", ProductResource::collection($products), $links, $meta, $paginate, 200, "List of products " . $paginate . " to " . $paginate . ":");
        } else {
            $products = Product::all();
            return $this->successResponse(ProductResource::collection($products), 200, "List all of products:");
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
            'title' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'category_id' => 'required|regex:/[0-9]+/',
            'primary_image' => 'required|image',
            'description' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'price' => 'required|regex:/[0-9]+/',
            'quantity' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'delivery_amount' => 'regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'images.*' => 'image'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        $fileName = Carbon::now()->microsecond . "." .  $request->primary_image->extension();
        $request->primary_image->move(public_path('images/products/'), $fileName);
        DB::beginTransaction();
        $product = Product::create([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'primary_image' => $fileName,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'delivery_amount' => $request->delivery_amount,
        ]);
        DB::commit();

        if ($request->has('images')) {
            $ImagesFileNames = [];
            foreach ($request->images as $image) {
                $fileName = Carbon::now()->microsecond . "." .  $image->extension();
                $image->move(public_path('images/products/'), $fileName);
                array_push($ImagesFileNames, $fileName);
            }
        }
        if ($request->has('images')) {
            foreach ($ImagesFileNames as $image) {
                ProductImages::create([
                    'image' => $image,
                    'product_id' => $product->id
                ]);
            }
        }
        return $this->successResponse(new ProductResource($product), 201, "created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return  $this->successResponse(new ProductResource($product), 200, 'product list of ' . $product->id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'category_id' => 'required|regex:/[0-9]+/',
            'primary_image' => 'image',
            'description' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'price' => 'required|regex:/[0-9]+/',
            'quantity' => 'required|regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'delivery_amount' => 'regex:/^[a-zA-Z0-9آ-ی\s]+$/',
            'images.*' => 'image'
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }
        if ($request->has('primary_image')) {
            $FileName =  Carbon::now()->microsecond . "." . $request->primary_image->extension();
            $request->primary_image->move(public_path('images/products'), $FileName);
        }


        if ($request->has('images')) {
            foreach ($product->images as $image) {
                $image->delete();
            }
        }
        if ($request->has('images')) {
            $ImagesFileNames = [];
            foreach ($request->images as $image) {
                $fileName = Carbon::now()->microsecond . "." .  $image->extension();
                $image->move(public_path('images/products/'), $fileName);
                array_push($ImagesFileNames, $fileName);
            }
        }

        $product->update([
            'title' => $request->title,
            'category_id' => $request->category_id,
            'primary_image' => $request->has('primary_image') ? $FileName : $product->primary_image,
            'description' => $request->description,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'delivery_amount' => $request->delivery_amount,
        ]);

        if ($request->has('images')) {
            foreach ($ImagesFileNames as $image) {
                ProductImages::create([
                    'image' => $image,
                    'product_id' => $product->id
                ]);
            }
        }
        return  $this->successResponse(new ProductResource($product), 200, "updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        DB::beginTransaction();
        $product->delete();
        DB::commit();
        return  $this->successResponse(new ProductResource($product), 200, "deleted successfully");
    }


    public function deletes()
    {
        $products = Product::onlyTrashed()->get();

        $productsResource = ProductResource::collection($products);

        return  $this->successResponse($productsResource, 200, "list deleted successfully");
    }

    public function restore(Product $product){

        DB::beginTransaction();
        $product->restore();
        DB::commit();
        return  $this->successResponse(new ProductResource($product), 200, "change off delete successfully");
    }
}
