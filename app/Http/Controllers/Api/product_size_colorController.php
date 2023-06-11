<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use App\Models\product_size_color;
use App\Models\Size;
use Illuminate\Http\Request;

class product_size_colorController extends Controller
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
            $product_size_color = product_size_color::with([
                 'size',
                 'color'
            ])
                ->select(['product_id','size_id','color_id','quantity'])
                ->get();
            //    dd($product);

            return response()->json([
               
                // // 'product_size'=> DB::table('product_size')
                // //    // ->leftJoin('size', 'size.id', '=', 'product_size.size_id')
                // //   // ->select('product_size.*','size.namesize as size',)
                // ->get(),
                'product_size_color'=>$product_size_color,
                'size'=>Size::get(),
                'color'=>Color::get(),
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
        try {
            $product_size_color = new product_size_color();
            $product_size_color->size_id =  $request->size_id;
            $product_size_color->product_id = $request->product_id;
            $product_size_color->color_id = $request->color_id;
            $product_size_color->quantity =   $request->quantity;
            $product_size_color->save();
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
     
        $product_size_color = Size::findOrFail($id);
        return response()->json([
            'product_size_color'=>$product_size_color,
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
            $product_size_color = product_size_color::findOrFail($id);
            $product_size_color->size_id =  $request->size_id;
            $product_size_color->product_id = $request->product_id;
            $product_size_color->color_id = $request->color_id;
            $product_size_color->quantity =   $request->quantity;
            $product_size_color->save();
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
        //
    }
}
