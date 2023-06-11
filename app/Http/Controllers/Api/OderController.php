<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\oder;
use App\Models\oder_detail;
use App\Models\Size;
use Illuminate\Support\Facades\DB;

class OderController extends Controller
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
            $order = oder::with([
                 
                 'oder_detail' ,
                 'customer'
                
                ])
               
                ->select(['id','order_note','totalMoney','payment_status','order_code'])
                ->whereNot('payment_status',1)
                ->get();
            //    dd($product);

            return response()->json([
                
                // 'product'=> DB::table('product')
                // ->leftJoin('category', 'category.id', '=', 'product.categories_id')
                // ->leftJoin('product_size', 'product_size.product_id', '=', 'product.id')
                // ->leftJoin('size', 'size.id', '=', 'product_size.size_id')
                // ->select('product.*','size.namesize as size',)
                // ->get(),
                'order'=>$order,
                'customer'=>Customer::get(),
                'oder_detail'=>oder_detail::get(),
            ]);
        } catch (\Exception $e) {
            dd($e);
        }
    }
    public function Order_processing()
    {
        $orders = oder::with('oder_detail')->where('payment_status', 1)->get();
        return response()->json(
            $orders
        );
    }
    public function updateStatus(Request $request, $id)
    {
        try {
            $order = oder::findOrFail($id);
            $order->payment_status = $request->payment_status;
            $order->save();
            // dd($statusText);
            // Lấy thông tin khách hàng và địa chỉ email
            // $customer = User::findOrFail($order->customer_id);
            // $email = $customer->email;
            // dd($email);
            // Gửi email thông báo cập nhật trạng thái đơn hàng cho khách hàng
            // Mail::to($email)->send(new OrderStatusUpdate($order));
            // session()->flash('success', 'Email thông báo đã được gửi thành công.');
            // return view('emails.order_status_update', compact('order','orderDetails'));
            return response()->json([
                'message' => 'Cập nhật trạng thái đơn hàng thành công'
            ]);
        } catch (\Exception $e) {
            dd('aaaa',$e);
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
        DB::beginTransaction();
        try {
            $order = new oder();
            $maxId = oder::max('id') + 1;
            $order->order_code = 'MDH_' . $maxId;
            $order->order_note = $request->order_note;
            // $order->order_note = 'ssss';
            $order->totalMoney = $request->totalMoney;
            $order->save();

            $customer = new Customer();
            $customer->oder_id = $order->id;
            $customer->name = (!empty($request->name)) ? $request->name : null;
            $customer->adress = $request->adress;
            $customer->email = $request->email;
            $customer->phone = $request->phone;
            $customer->save();
  
            foreach ($request->oder_detail as $oder_detail) {
                oder_detail::create([
                    'order_id' => $order->id,
                    'product_id' => $oder_detail['product_id'],
                    // 'size_id' => $oder_detail['size_id'],
                    // 'color_id' => $oder_detail['color_id'],
                    'price' => $oder_detail['price'],                    
                    'quantity' => $oder_detail['quantity'],   
                    'img_oder' => $oder_detail['img_oder'],                      
                                 
                ]);
            }
            // dd($order_product->product_id); 

            DB::commit();
            return response()->json([
                
                'messege' => 'thành công rồi',
                'order' => $order,
            ], 200);
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return response()->json([
                'messege' => 'Thất bại!',
            ], 200);
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
        //
    }
    public function get_oder_detail($oder_id)
    {
        $oder_detail =  oder_detail::with([
            // 'product_size_color'
            
            'product'
        ])->where('order_id',$oder_id)->get();
        $order_customer =  Customer::where('oder_id',$oder_id)->get();
        return response()->json([
            'oder_detail'=>$oder_detail,
            'oder_customer'=>$order_customer
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
        $oder = oder::findOrFail($id);
        $oder->delete();
        $oder->oder_detail()->delete();
        $oder->customer()->delete();
        return response()->json([
            'thông báo'=>'Xóa thành công'
        ],200);
        return response()->json([
            'thông báo'=>'Xóa thành công'
        ],200); 
    }
}
