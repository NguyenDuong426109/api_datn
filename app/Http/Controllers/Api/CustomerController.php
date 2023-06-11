<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'customer'=>Customer::get(),
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $customer = new Customer();
            $customer->name =  (!empty($request->name)) ? $request->name : null;
            $customer->adress = $request->adress;
            $customer->email = $request->email;

            $customer->phone = $request->phone;
      
            $customer->save();
            return response()->json([
                'thông báo'=>'thêm thành công'
            ],200); 
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'thông báo'=>'thêm thất bại'
            ],200); 
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        return response()->json([
            'customer'=>$customer,
        ],200); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        try {
            $customer = Customer::findOrFail($id);
            $customer->name =  (!empty($request->name)) ? $request->name : null;
            $customer->adress = $request->adress;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
    
            $customer->save();


            return response()->json([
                'thông báo'=> "sửa thành công",
             
            ],200); 
        } catch (\Exception $e) {
            //throw $th;
            return response()->json([
                'thông báo'=>'sửa thất bại'
            ],200); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return response()->json([
            'thông báo'=>'Xóa thành công'
        ],200); 
    }
}
