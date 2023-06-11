<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\bill_import;

class bil_importController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            // sử dụng model
            $bill_import = bill_import::with([
                'bill_import_det',  
                ])
                ->select(['producer_name', 'adress','phone',])
                ->get();
            //    dd($product);

            return response()->json([
                
                // 'product'=> DB::table('product')
                // ->leftJoin('category', 'category.id', '=', 'product.categories_id')
                // ->leftJoin('product_size', 'product_size.product_id', '=', 'product.id')
                // ->leftJoin('size', 'size.id', '=', 'product_size.size_id')
                // ->select('product.*','size.namesize as size',)
                // ->get(),
                'bill_import'=>$bill_import,
                // 'test_array'=>$product->category,
             
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
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
        // dd($request->all());
        try {
            $bill_import = new bill_import();
            $bill_import->producer_name =$request->producer_name;
            $bill_import->adress =$request->adress;
            $bill_import->phone =$request->phone;
            // dd($bill_import->adress);
            $bill_import->save();
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
        
        $bill_import = bill_import::findOrFail($id);
        return response()->json([
            'bill_import'=>$bill_import,
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
            $bill_import = bill_import::findOrFail($id);
            $bill_import->producer_name =$request->producer_name;
            $bill_import->adress =$request->adress;
            $bill_import->phone =$request->phone;
            $bill_import->save();
            return response()->json([
                'thông báo'=>'sửa thành công'
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
        $bill_import = bill_import::findOrFail($id);
        $bill_import->delete();
        return response()->json([
            'thông báo'=>'Xóa thành công'
        ],200); 
    }
}
