<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $where = [];
        if ($request->customer_id) {
            $where['customer_id'] = $request->customer_id;
        }
        if ($request->user_id) {
            $where['user_id'] = $request->user_id;
        }
        if (sizeof($where) > 0) {
            $orders = Order::orderBy('id', 'DESC')->where($where)->with(['customer.country', 'user'])->withCount(['orderdetails'])->paginate(10);

        } else {
            $orders = Order::orderBy('id', 'DESC')->with(['customer.country', 'user'])->withCount(['orderdetails'])->paginate(10);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Order get successfully!',
            'data' => $orders,
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Data
//        $request->validate([
//            'code' => 'required|string|max:255|unique:products,code,' . $product->id
//        ]);
        $products = json_decode($request->products, true);
        $customer_id = $request->customer_id;
        $user_id = $request->user_id;
        $total_new_price = $request->total_new_price;
        $customer_department = $request->department;

        $order = new Order();
        $order->user_id = $user_id;
        $order->customer_id = $customer_id;
        $order->code = 'HW' . strtoupper(Str::random(3)) . date("Ymd");
        $order->total_price = $total_new_price;
        $order->customer_department = $customer_department;

        if ($order->save()) {
            $customer = Customer::find($customer_id);
            $product_ids = array_column($products, 'id');
//            $customer->products()->attach($product_ids, ['order_id' => $order->id]);
            $customer->products()->syncWithoutDetaching($product_ids);
            foreach ($products as $product) {
                $order_details = new OrderDetail();
                $order_details->order_id = $order->id;
                $order_details->product_id = $product['id'];
                $order_details->new_price = $product['new_price'];
                $order_details->save();
            }

            return response()->json([
                'status' => 200,
                'message' => 'Order created successfully!',
                'order' => Order::with('orderdetails.product')->find($order->id),
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
        ], 500);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function edit($id)
    {
        $order = Order::whereId($id)->with(['customer.country', 'orderdetails.product.category', 'user'])->first();
        return response()->json([
            'status' => 200,
            'message' => 'Order created successfully!',
            'data' => $order
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Request $request, Order $order)
    {
        if ($request->customer_id) {
            $orders = Order::where('customer_id', $request->customer_id)->with('customer.country')->paginate(1);
        } else {
            $orders = Order::with('customer.country')->paginate(1);
        }
        if ($order->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Category deleted successfully!',
                'data' => $orders,
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
            'data' => $orders,
        ], 500);
    }
}
