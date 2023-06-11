<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\news;
use PhpParser\Node\Expr\New_;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
class NewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'news'=>news::get(),
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $new = new news(); 
            // $new->name =  (!empty($request->name)) ? $request->name : null;
            $new->title = $request->title;     
            $new->content = $request->content;
            $new->description = $request->description;
            if ($request->hasFile('avatar_path')) {
                // Store the file and get the path
                $path = $request->file('avatar_path')->store('post');
                // Assign the path to dataCategorypostCreate['avatar_path']
                $new->avatar_path = $path;
            }
            $new->save();
         
            DB::commit();
            return response()->json(['message' => 'Nhập thành công']);
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
            DB::rollback();
            return response()->json([
                'message' => 'ko dc'
            ]);
         
           
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
        return response()->json([
            'new'=>news::find($id),
        ]);
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
            $new = news::findOrFail($id);
            // $new->name =  (!empty($request->name)) ? $request->name : null;
            $new->title = $request->title;
            $new->content = $request->content;
            $new->description = $request->description;
            if ($request->hasFile('avatar_path')) {
                // Store the file and get the path
                $path = $request->file('avatar_path')->store('post');
                // Assign the path to dataCategorypostCreate['avatar_path']
                $new->avatar_path = $path;
            }
            $new->save();

            return response()->json([
                'new'=> $new,
                'new_id' => $new->id
            ],200); 
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
       
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
        $news = news::findOrFail($id);
        $news->delete();
        return response()->json([
            'thông báo'=>'Xóa thành công'
        ],200); 
    }
    public function newHome()
    {
        $new_first= news::latest()->first();
        $new_down = news::where('id','<>',$new_first->id)->latest()->limit(3)->get();
        return response()->json([
            'new_first'=>$new_first,
            'new_down' => $new_down
        ]);
    }
}
