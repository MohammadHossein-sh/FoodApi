<?php

namespace App\Http\Controllers;

use App\Http\Resources\AddressResource;
use App\Http\Resources\UserResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AddressController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        return  $this->successResponse(new  UserResource($user->load('address')), 200, 'user and list adress');
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
            'address' => 'required|regex:/^[\p{L}\p{N}]+$/u',
        ]);


        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }

        $user = auth()->user();
        DB::beginTransaction();
        $address =  Address::create([
            'address' => $request->address,
            'user_id' => $user->id
        ]);
        DB::commit();
        return  $this->successResponse(new  AddressResource($address), 201, 'created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Address $address)
    {
        $user = auth()->user();
        if($address->user_id == $user->id){
            return  $this->successResponse(new  AddressResource($address), 200, 'show of : ' . $address->id);
        }else{
            return $this->errorResponse('This address was not found for this user', 422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'address' => 'required|regex:/^[\p{L}\p{N}]+$/u',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->messages(), 422);
        }


        $user = auth()->user();
        $address = $user->address()->get();

        DB::beginTransaction();
        foreach ($address as $addres) {
            if ($addres->id == $id) {
                $addres->update([
                    'address' => $request->address
                ]);
                DB::commit();
                return  $this->successResponse(new AddressResource($addres), 200, 'updated address successfully');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Address $address)
    {
        DB::beginTransaction();
        $address->delete();
        DB::commit();
        return  $this->successResponse(new AddressResource($address), 200, 'delete successfully');
    }
    public function deleted()
    {
        $user = auth()->user();
        $addresses = $user->address()->onlyTrashed()->get();

        $addressResources = AddressResource::collection($addresses);

        return $this->successResponse($addressResources, 200, 'List of delete addresses');
    }

    public function restore($id)
    {
        $user = auth()->user();
        $address = $user->address()->onlyTrashed()->get();

        DB::beginTransaction();
        foreach ($address as $addres) {
            if ($addres->id == $id) {
                $addres->restore();
                DB::commit();
                return  $this->successResponse(new AddressResource($addres), 200, 'restore address');
            }
        }
    }
}
