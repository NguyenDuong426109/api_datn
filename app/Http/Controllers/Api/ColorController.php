<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Contracts\Filesystem\Cloud;
use Illuminate\Http\Request;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'color'=>Color::get(),
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
            $color = new Color();
            $color->namecolor =  (!empty($request->namecolor)) ? $request->namecolor : null;
            $color->save();
            return response()->json([
                'thông báo' => 'thêm thành công'
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
        $color = Color::findOrFail($id);
        return response()->json([
            'color'=>$color,
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
            $color = Color::findOrFail($id);
            $color->namecolor =  (!empty($request->namecolor)) ? $request->namecolor : null;
            $color->product_id =  $request->product_id;
            $color->save();
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
        $color = Color::findOrFail($id);
        $color->delete();
        return response()->json([
            'thông báo'=>'Xóa thành công'
        ],200); 
    }
}
