<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ExportPdfMutiple;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
    }

    public function index(Request $request)
    {
        $price = $request->price;
//
//        print_r($price);
//        die;
        if (!isset($price) || $price == null || $price[0] == null) {
            $price = [0, 10000];
        }
        $page_size = ($request->size) ? ($request->size) : 20;
        $category_id = $request->category_id;
        $subcategory_id = $request->subcategory_id;
        $subcategories = [];
        if (!empty($request->customer_id)) {
            $product_ids = DB::table('customer_product')->where('customer_id', $request->customer_id)->pluck('product_id');
            $products = Product::whereIn('id', $product_ids)
                ->where('code', 'like', '%' . $request->search . '%')
                ->where('color', 'like', '%' . $request->color . '%')
                ->whereBetween('price', $price)
                ->with(['category', 'customers', 'package'])->paginate($page_size);
            $colors = Product::whereIn('id', $product_ids)
                ->where('code', 'like', '%' . $request->search . '%')
                ->whereBetween('price', $price)
                ->select('color')->groupBy('color')->get()->toArray();
            $max_price = Product::whereIn('id', $product_ids)
                ->where('code', 'like', '%' . $request->search . '%')
                ->max('price');
            $min_price = Product::whereIn('id', $product_ids)
                ->where('code', 'like', '%' . $request->search . '%')
                ->min('price');
        } else {
            if ($category_id != 0 && !empty($category_id)) {
                if (!isset($subcategory_id)) {
                    $subcategory_id = Category::where('parent_id', $category_id)->pluck('id');
                }
                $subcategories = Category::where('parent_id', $category_id)->get();
                $products = Product::whereIn('category_id', $subcategory_id)
                    ->where('code', 'like', '%' . $request->search . '%')
                    ->where('color', 'like', '%' . $request->color . '%')
                    ->whereBetween('price', $price)
                    ->with(['category', 'customers', 'package'])->paginate($page_size);
                $colors = Product::whereIn('category_id', $subcategory_id)
                    ->where('code', 'like', '%' . $request->search . '%')
                    ->whereBetween('price', $price)
                    ->select('color')->groupBy('color')->get()->toArray();
                $min_price = Product::whereIn('category_id', $subcategory_id)
                    ->where('code', 'like', '%' . $request->search . '%')
                    ->min('price');
                $max_price = Product::whereIn('category_id', $subcategory_id)
                    ->where('code', 'like', '%' . $request->search . '%')
                    ->max('price');
            } else {
                $products = Product::with(['category', 'customers', 'package'])
                    ->where('code', 'like', '%' . $request->search . '%')
                    ->where('color', 'like', '%' . $request->color . '%')
                    ->whereBetween('price', $price)
                    ->paginate($page_size);
                $colors = Product::where('name', 'like', '%' . $request->search . '%')
                    ->whereBetween('price', $price)
                    ->select('color')->groupBy('color')->get()->toArray();
                $min_price = Product::where('name', 'like', '%' . $request->search . '%')
                    ->min('price');
                $max_price = Product::where('name', 'like', '%' . $request->search . '%')
                    ->max('price');
            }
        }
        return response()->json([
            'status' => 200,
            'message' => 'Get Product List successfully!',
            'products' => $products,
            'colors' => $colors,
            'price' => [$min_price, $max_price],
            'subcategories' => $subcategories,
        ], 200);
    }

    public function getListProduct(Request $request, $id)
    {
        $category_id = $request->category_id;
        $subcategories = Category::where('parent_id', $id)->get();
        if (!$category_id) $category_id = Category::where('parent_id', $id)->pluck('id');
        $products = Product::whereIn('category_id', $category_id)->with(['category', 'customers', 'package'])->paginate(1);
        $total_record = Product::whereIn('category_id', $category_id)->count();
        return response()->json([
            'status' => 200,
            'message' => 'Get Product List successfully!',
            'data' => $products,
            'subcategories' => $subcategories,
            'total_record' => $total_record,
        ], 200);
    }

    public function getProducts(Request $request)
    {
        $products = Product::with(['category', 'customers', 'package'])->paginate(10);
        return response()->json([
            'status' => 200,
            'message' => 'Get Product List successfully!',
            'data' => $products,
        ], 200);
    }

    public function getCategories()
    {
        return response()->json([
            'status' => 200,
            'message' => 'Get Category List successfully!',
            'data' => Category::with('subcategories')->get(),
            'listCategory' => Category::where('parent_id', null)->with('subcategories')->get(),
        ], 200);
    }

    public function getProductDetail($id)
    {
        $product = Product::with(['category', 'customers', 'package'])->find($id);
        $related_products = Product::with(['category', 'customers', 'package'])->where('category_id', $product->category_id)->where('id', '!=', $id)->limit(10)->get();
        return response()->json([
            'status' => 200,
            'message' => 'Get Product successfully!!',
            'item_data' => $product,
            'related_items' => $related_products,
        ], 200);
    }

    public function getCustomers()
    {
        $customers = Customer::with('country')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Get Customers successfully!!',
            'customers' => $customers,
        ], 200);
    }

    public function downloadPDF(Request $request)
    {
        $data = $request->items;

        $images = json_decode($data[0], true);
        $images = $images['images_export'];
        $pdf = PDF::loadView('exports.export-pdf', ['images' => $images]);
//        $pdf->setPaper('a4', 'landscape');
        return $pdf->download('invoice.pdf');
    }

    public function exportExcel(Request $request)
    {
        $product_ids = $request->product_ids;
        $products_price = $request->products_price;
        $department = $request->department;

        $data = Product::whereIn('id', $product_ids)->get()->toArray();
        $type = $request->type;
        $customer = Customer::with(['country'])->find($request->customer_id);
        return Excel::download(new ExportPdfMutiple(['data' => $data, 'products_price' => $products_price], $type, $customer, $department), 'OK.xlsx');
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|max:255',
        ]);
        $user = User::find($request->id);
        //Set Data Object
        $user->password = bcrypt($request->password);
        $user->active = 1;
        //Check status HTTP
        if ($user->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'User updated successfully!',
                'data' => $user,
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
        ], 500);
    }
}
