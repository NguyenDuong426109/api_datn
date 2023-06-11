<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\oder;
use App\Models\oder_detail;
use App\Models\Product;
// use App\Models\news;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $totalOrder = oder::all()->count();
        // $totalMember = user::all()->count();
        $totalProduct = Product::all()->count();
        // $totalPost = $this->post->all()->count();
        // $totalViewPost = $this->post->sum('view');
        // $totalViewProduct = $this->product->sum('view');
        // $totalOrderProduct = $this->product->sum('pay');
        $totalPriceOrder = oder::sum('totalMoney');
        
        //dd($totalPost);
        // lấy bài viết mới nhất
        // $listCategoryPost = $this->categoryPost->getALlCategoryChildrenAndSelf(2);
        //  dd($listCategoryPost);
        // $postNews = $this->post->with('translations')->where('category_id', 2)->latest()->limit(10)->get();
        // dd('a');
        // dd($listCategoryProduct);
        $productNews = Product::latest()->limit(10)->get();
        return response()->json([
            'totalOrder' => $totalOrder,
            // 'totalMember' => $totalMember,
            'totalProduct' => $totalProduct,
            // 'totalPost' => $totalPost,
            // 'totalViewPost' => $totalViewPost,
            // 'totalOrderProduct' => $totalOrderProduct,
            // 'totalViewProduct' => $totalViewProduct,
            'totalPriceOrder' => $totalPriceOrder,
            // 'postNews' => $postNews,
            'productNews' => $productNews,
        ], 200);
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
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
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
