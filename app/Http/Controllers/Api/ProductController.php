<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Color;
use App\Models\img;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\product_information;
use App\Models\product_size;
use App\Models\product_size_color;
use App\Models\Size;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
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
            $product = Product::with([
                'category',
                 'size',
                 'color',
                 'image'=> function ($query) {
                    $query->select('img_product', 'product_id')->orderBy('product_id')->distinct();
                },
                ])
             
                ->select(['id', 'name','price', 'description','status' ,'categories_id',])
                ->orderBy('id','desc')
                ->limit(6)
                ->get();
            //    dd($product);

            return response()->json([
                
                // 'product'=> DB::table('product')
                // ->leftJoin('category', 'category.id', '=', 'product.categories_id')
                // ->leftJoin('product_size', 'product_size.product_id', '=', 'product.id')
                // ->leftJoin('size', 'size.id', '=', 'product_size.size_id')
                // ->select('product.*','size.namesize as size',)
                // ->get(),
                'product'=>$product,
                'size'=>Size::get(),
                'color'=>Color::get(),
                // 'test_array'=>$product->category,
                'category'=>Category::get(),
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    //     return response()->json([
    //         'product'=>Product::get(),
            
    //     ]);
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
            $product = new Product(); 
            $product->name =  (!empty($request->name)) ? $request->name : null;
            $product->categories_id = $request->categories_id;     
            $product->price = $request->price;
            $product->description = $request->description;
            $product->save();
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $image) {
                    // Kiểm tra file có phải là ảnh và dung lượng không quá giới hạn cho phép
                    if ($image->isValid() && in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']) && $image->getSize() <= 5048000) {
                        // chuỗi đặt tên file ảnh
                        $filename = time() . '-' . Str::slug($image->getClientOriginalName(), '-') . '.' . $image->getClientOriginalExtension();
                        // Lưu ảnh vào thư mục image/product
                        $image->storeAs('image/product', $filename);

                        // Thêm bản ghi vào bảng images
                        img::create([
                           
                            'img_product' => $filename,
                            'product_id' => $product->id,
                        ]);
                    }
                }
            }
         
          
            DB::commit();
            return response()->json(['message' => 'Nhập  thành công']);
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
            DB::rollback();
            return response()->json([
                'message' => 'ko dc'
            ]);
         
           
        }   
    }
    public function create_size(Request $request)
    {   
        try {
            $size = new Size();
            $size->namesize =  (!empty($request->namesize)) ? $request->namesize : null;
            $size->product_id = $request->product_id;
            $size->quantity = $request->quantity;
            $size->save();
            return response()->json([
                'thông báo'=>'thêm thành công',
                // 'size'=>$size,
            ],200); 
        } catch (\Exception $e) {
            //throw $th;
            // dd($e);
            return response()->json([
                'thông báo'=>'thêm thất bại'
            ],200); 
        }
    }
    public function create_color(Request $request)
    {   
        
        try {
            $color = new Color();
            $color->namecolor =  (!empty($request->namecolor)) ? $request->namecolor : null;
            $color->product_id = $request->product_id;
            $color->save();
            return response()->json([
                'thông báo'=>'thêm thành công',
                // 'size'=>$size,
            ],200); 
        } catch (\Exception $e) {
            //throw $th;
            // dd($e);
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
        $products = Product::with([
            // 'product_size_color'
            'size',
            'color',
            'image',
            'category',
        ]) ->findOrFail($id);
        $product_similar = Product::with([
            'size',
            'color',
            'image',
            'category'
        ]) -> where('categories_id',$products->categories_id)->whereNotIn('id',[$id])->get();
        $images = $products->image ;
        $sizes = $products->size;
        $colors = $products->color;
        // dd($products);
        return response()->json([
         
            'product'=>$products,
            'product_similar'=>$product_similar,
            'image' => $images,
            'size' => $sizes,
            'color' => $colors
        ],200); 
    }
    public function show_id($id)
    {
        $products = Product::with([
            // 'product_size_color'
            'size',
            'color',
            'image'
        ])->where('categories_id','=', $id) ->findOrFail($id);
        $images = $products->image ;
        $sizes = $products->size;
        $colors = $products->color;
        // dd($products);
        return response()->json([
            'product'=>$products,
            
        ],200); 
    }
    
    
    public function getsize($product_id)
    {
        $size =  Size::where('product_id',$product_id)->get();
        return response()->json([
            'size'=>$size
        ],200);
    }
    public function getcolor($product_id)
    {
        $color =  Color::where('product_id',$product_id)->get();
        return response()->json([
            'color'=>$color
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
            $product = Product::findOrFail($id);
            $product->name =  (!empty($request->name)) ? $request->name : null;
            $product->categories_id = $request->categories_id;
            $product->price = $request->price;
            $product->description = $request->description;
          
            $imageIds = $request->input('image_ids', []);

            // Xóa hình ảnh không được chọn để lưu giữ
            $imagesToDelete = $product->image()->whereNotIn('id', $imageIds)->get();
            foreach ($imagesToDelete as $image) {
                Storage::delete('image/product/' . $image->img_product);
                $image->delete();
            }
            $product->save();
            if ($request->hasFile('image')) {
                $images = $request->file('image');
                foreach ($images as $image) {
                    // Kiểm tra file có phải là ảnh và dung lượng không quá giới hạn cho phép
                    if ($image->isValid() && in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'png', 'gif']) && $image->getSize() <= 5048000) {
                        // chuỗi đặt tên file ảnh
                        $filename = time() . '-' . Str::slug($image->getClientOriginalName(), '-') . '.' . $image->getClientOriginalExtension();
                        // Lưu ảnh vào thư mục image/product
                        $image->storeAs('image/product', $filename);

                        // Thêm bản ghi vào bảng images
                        img::create([
                           
                            'img_product' => $filename,
                            'product_id' => $product->id,
                        ]);
                    }
                }
            }
            return response()->json([
                'product'=> $product,
                'product_id' => $product->id
            ],200); 
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
       
            return response()->json([
                'thông báo'=>'sửa thất bại'
            ],200); 
        }
    }
    public function update_size(Request $request, $id)
    {
       
        try {
            $size = Size::findOrFail($id);
            $size->namesize =  (!empty($request->namesize)) ? $request->namesize : null;
            $size->product_id = $request->product_id;
            $size->quantity = $request->quantity;

            $size->save();
            return response()->json([
                'thông báo'=>'sửa thành công'
            ],200); 
        } catch (\Exception $e) {
            //throw $th;
            dd($e);
            return response()->json([
                'thông báo'=>'sửa thất bại'
            ],200); 
        }
    }
    public function update_color(Request $request, $id)
    {
       
        try {
            $color = Color::findOrFail($id);
            $color->namecolor =  (!empty($request->namecolor)) ? $request->namecolor : null;
            $color->product_id =  $request->product_id ;
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
    // public function update(Request $request, $id)
    // {
    //     try {
    //         $product = Product::findOrFail($id);
    //         $product->name =  (!empty($request->name)) ? $request->name : null;
    //         $product->categories_id = $request->categories_id;
    //         $product->price = $request->price;
    //         $product->description = $request->description;
    //         $product->status = $request->status;
    //         $product->save();


    //         return response()->json([
    //             'thông báo'=>'sửa thành công',
    //             'product_id' => $product->id
    //         ],200); 
    //     } catch (\Exception $e) {
    //         //throw $th;
    //         return response()->json([
    //             'thông báo'=>'sửa thất bại'
    //         ],200); 
    //     }
    // }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        $product = Product::findOrFail($id);
        $product->delete();
        $product->size()->delete();
        $product->color()->delete();
        return response()->json([
            'thông báo'=>'Xóa thành công'
        ],200); 
    }
    public function destroy_size($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();
        return response()->json([
            'thông báo'=>'Xóa thành công'
        ],200); 
    }

    public function destroy_color($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();
        return response()->json([
            'thông báo'=>'Xóa thành công'
        ],200); 
    }
    
}
