<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Repositories\ProductRepositoryInterface;
use App\Services\ProductService;

class ProductController extends Controller
{
    protected $productRepository;
    protected $productService;

    public function __construct(ProductRepositoryInterface $productRepository, ProductService $productService)
    {
        $this->productRepository = $productRepository;
        $this->productService = $productService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $subcategory_id = [0];
        $subcat = [0];
        $colors = ['color' => 'All'];
        if ($request->category_id != 0) {
            $category_id = $request->category_id;
            $subcat = Category::where('parent_id', $category_id)->pluck('id');
            if ($request->subcategory_id == 0) {
                $subcategory_id = Category::where('parent_id', $category_id)->pluck('id');
            } else {
                $subcategory_id = array($request->subcategory_id);
            }
            $products = Product::whereIn('category_id', $subcategory_id)
                ->where('code', 'like', '%' . $request->search . '%')
                ->where('color', 'like', '%' . $request->color . '%')
                ->whereBetween('price', $request->price)
                ->with(['category', 'customers', 'package'])
                ->paginate(10);
            $total = Product::whereIn('category_id', $subcategory_id)
                ->where('code', 'like', '%' . $request->search . '%')
                ->where('color', 'like', '%' . $request->color . '%')
                ->whereBetween('price', $request->price)
                ->count();
            $colors = Product::whereIn('category_id', $subcategory_id)
                ->where('code', 'like', '%' . $request->search . '%')
                ->whereBetween('price', $request->price)
                ->select('color')->groupBy('color')->get()->toArray();
        } else {
            $products = Product::with(['category', 'customers', 'package'])
                ->where('code', 'like', '%' . $request->search . '%')
                ->where('color', 'like', '%' . $request->color . '%')
                ->whereBetween('price', $request->price)
                ->paginate(10);
            $total = Product::with(['category', 'customers', 'package'])
                ->where('code', 'like', '%' . $request->search . '%')
                ->where('color', 'like', '%' . $request->color . '%')
                ->whereBetween('price', $request->price)->count();
            $colors = Product::where('code', 'like', '%' . $request->search . '%')
                ->whereBetween('price', $request->price)
                ->select('color')->groupBy('color')
                ->get()->toArray();
        }
        return response()->json([
            'status' => 200,
            'message' => 'User created successfully!',
            'data' => $products,
            'total' => $total,
            'colors' => $colors,
            'categories' => Category::where('parent_id', null)->with('subcategories')->get(),
            'subcategories' => Category::whereIn('id', $subcat)->get(),
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::where('parent_id', null)->with('subcategories')->get();
        return response()->json([
            'status' => 200,
            'message' => 'User created successfully!',
            'categories' => $categories,
            'packages' => Package::all(),
        ], 200);
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
        $request->validate([
            'code' => 'required|string|max:255|unique:products',
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'materials' => 'required|string',
            //            'weaving' => 'string',
            //            'info' => 'string',
            'price' => 'required|gt:0',
            'color' => 'required|string',
            'size_l' => 'required',
            'size_w' => 'required',
            'size_h' => 'required',
            'ctn_qty' => 'required',
            'ctn_l' => 'required',
            'ctn_w' => 'required',
            'ctn_h' => 'required',
            'package_id' => 'required',
        ]);
        //Set Data Object
        $product = new Product();
        $params  =  $request->all();
        $params['cbm'] =  number_format(($request->ctn_l * $request->ctn_w * $request->ctn_h) / 1000000, 3, '.', '');

        if ($request->hasFile('images')) {
            $images_path = [];
            $images = $request->file('images');
            $types = $request->types;
            foreach ($images as $key => $image) {
                $tmp = [];
                //$path = Storage::putFile('products', $image);
                $path = $this->productService->upload($image);
                $tmp['type'] = $types[$key];
                $tmp['url'] = '/storage/' . $path;
                $images_path[] = $tmp;
            }
            // $product->images = json_encode($images_path);
            $params['images'] = json_encode($images_path);
        }
        //Check status HTTP
        if ($this->productRepository->create($params)) {
            return response()->json([
                'status' => 200,
                'message' => 'Product created successfully!',
                'data' => $product,
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
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product = Product::with(['category', 'customers', 'package'])->find($product->id);
        $categories = Category::where('parent_id', null)->with('subcategories')->get();
        return response()->json([
            'status' => 200,
            'data' => $product,
            'categories' => $categories,
            'packages' => Package::all(),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {

        //Validate Data
        $request->validate([
            'code' => 'required|string|max:255|unique:products,code,' . $product->id,
            'name' => 'required|string|max:255',
            'category_id' => 'required',
            'materials' => 'required|string',
            'price' => 'required|gt:0',
            'color' => 'required|string',
            'size_l' => 'required',
            'size_w' => 'required',
            'size_h' => 'required',
            'ctn_qty' => 'required',
            'ctn_l' => 'required',
            'ctn_w' => 'required',
            'ctn_h' => 'required',
            'package_id' => 'required',
        ]);
        //Set Data Object
        $params  =  $request->all();
        $params['cbm'] =  number_format(($request->ctn_l * $request->ctn_w * $request->ctn_h) / 1000000, 3, '.', '');
        if ($request->hasFile('images')) {
            $images_path = json_decode($request->images_old);
            $images = $request->file('images');
            $types = $request->types;
            foreach ($images as $key => $image) {
                $tmp = [];
                // $path = Storage::putFile('products', $image);
                $path = $this->productService->upload($image);
                $tmp['type'] = $types[$key];
                $tmp['url'] = '/storage/' . $path;
                $images_path[] = $tmp;
            }
            $params['images'] = json_encode($images_path);
        } else {
            $params['images'] = $request->images_old;
        }
        //Check status HTTP
        if ($product->save()) {
            return response()->json([
                'status' => 200,
                'message' => 'Product updated successfully!',
                'data' => $product,
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
        ], 500);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //Check status HTTP
        if ($product->delete()) {
            return response()->json([
                'status' => 200,
                'message' => 'Product deleted successfully!',
            ], 200);
        }
        return response()->json([
            'status' => 500,
            'message' => 'Some error occurred. Please try again!',
        ], 500);
    }
}
