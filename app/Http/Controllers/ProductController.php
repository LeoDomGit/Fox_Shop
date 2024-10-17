<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Gallery;
use App\Models\ProductCategory;
use App\Models\Products;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Controllers\Controller;
use App\Traits\HasCrud;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Leo\Categories\Models\Categories;
use Illuminate\Support\Facades\Auth;
class ProductController extends Controller
{
    use HasCrud;
    protected $model;
    public function __construct()
    {
        $this->model = Products::class;
    }

    public function index()
    {
        $result = $this->model::with('categories', 'brands')->get();
        $categories = \App\Models\Categories::active()->get();
        $brands = Brand::active()->get();
        return Inertia::render('Products/Index', ['dataproducts' => $result, 'databrands' => $brands, 'datacategories' => $categories]);
    }
    public function Active()
    {
        $result = $this->model::with('categories', 'brands', 'gallery')
            ->where('status', 1)
            ->where('gallery.status', 1)
            ->paginate(3);
        return response()->json($result);
    }
    public function Single_Active($id)
    {
        $product = $this->model::with('categories', 'brands')
            ->where('status', 1)
            ->where('id', $id)
            ->first();
        $result = Gallery::where('id_parent', $id)->pluck('image')->toArray();
        $gallery = [];
        foreach ($result as  $value) {
            $gallery[] = Storage::url('products/' . $id . '/' . $value);
        }
        return response()->json(['result' => $product, 'gallery' => $gallery]);
    }

    public function UploadImages(Request $request, $id)
    {
        if (!request()->has('files')) {
            return response()->json(['check' => false, 'msg' => 'Files is required   ']);
        }
        $result = [];
        foreach ($request->file('files') as $file) {

            $imageName = $file->getClientOriginalName();

            $extractTo = storage_path('app/public/products/');

            $file->move($extractTo, $imageName);

            Gallery::create([

                'id_parent' => $id,

                'image' => $imageName,

                'status' => 0

            ]);

            $result[] = Storage::url('products/' . $imageName);
        }

        $oldImages = Gallery::where('id_parent', $id)->pluck('image')->toArray();

        if (count($oldImages) > 0) {

            foreach ($oldImages as  $value) {

                $result[] = Storage::url('products/' . $id . '/' . $value);
            }
        }

        $result = array_merge($oldImages, $result);

        Products::where('id', $id)->update(['status' => 0]);

        return response()->json(['check' => true, 'result' => $result]);
    }



    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:products,name',
            'price' => 'required|numeric',
            'color' => 'required',
            'idBrand' => 'required|exists:brands,id',
            'content' => 'required',
            'files' => 'required|array',
            'files.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'in_stock' => 'required|min:0',
            'categories'=>'required|array',
            'categories.*'=>'exists:categories,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }
        $data = [];
        $data['name'] = $request->name;
        $slug = Str::slug($data['name']);
        $data['slug'] = $slug;
        $data['compare_price'] = $request->price;
        $data['id_brand'] = $request->idBrand;
        $data['color'] = $request->color;
        $data['price'] = $request->discount;
        $data['content'] = $request->content;
        $data['discount']=0;
        $data['in_stock'] = $request->in_stock;
        $data['created_at'] = now();
        $id = $this->model::insertGetId($data);
        foreach ($request->categories as $key => $value) {
           ProductCategory::create(['id_product'=>$id,'id_categories'=>$value,'created_at'=>now()]);
        }
        foreach ($request->file('files') as $file) {

            $imageName = $file->getClientOriginalName();

            $extractTo = storage_path('app/public/products/');

            $file->move($extractTo, $imageName);

            Gallery::create([

                'id_parent' => $id,

                'image' => $imageName,

                'status' => 0

            ]);

            $result[] = Storage::url('products/' . $imageName);
        }

        $result = $this->model::with('categories', 'brands')->get();

        return response()->json(['check' => true, 'data' => $result]);
    }



    public function show($identifier)
    {
        $result = $this->model::with('brands','categories')->find($identifier);
        $oldImages = Gallery::where('id_parent', $identifier)->pluck('image')->toArray();

        $gallery = [];

        foreach ($oldImages as  $value) {

            $gallery[] = Storage::url('products/' .  $value);
        }
        $categories = \App\Models\Categories::active()->get();
        $brands = Brand::active()->get();

        $image = Gallery::where('id_parent', $identifier)->where('status', 1)->value("image");

        if ($image) {
            return Inertia::render('Products/Edit', ['dataId' => $identifier, 'dataBrand' => $brands, 'dataCate' => $categories, 'dataproduct' => $result, 'datagallery' => $gallery, 'dataimage' => Storage::url('products/' . $image)]);
        } else {
            return Inertia::render('Products/Edit', ['dataId' => $identifier, 'dataBrand' => $brands, 'dataCate' => $categories, 'dataproduct' => $result, 'datagallery' => $gallery, 'dataimage' => Storage::url('products/' . $image)]);
        }
    }



    public function setImage($id, $imageName)

    {

        Gallery::where('id_parent', $id)->update(['status' => 0]);

        Gallery::where('id_parent', $id)

            ->where('image', $imageName)

            ->update(['status' => 1]);

        $result = Storage::url('products/' . $imageName);

        return response()->json(['check' => true, 'result' => $result]);
    }



    public function removeImage($id, $imageName)

    {

        $filePath = "public/products/{$imageName}";

        Storage::delete($filePath);

        Gallery::where('id_parent', $id)

            ->where('image', $imageName)

            ->delete();

        $oldImages = Gallery::where('id_parent', $id)->pluck('image')->toArray();

        $gallery = [];

        foreach ($oldImages as  $value) {

            $gallery[] = Storage::url('products/' . $value);
        }

        return response()->json(['check' => true, 'gallery' => $gallery]);
    }



    public function importImages(Request $request, $identifier)

    {

        $extractTo = storage_path('app/public/products/' . $identifier);

        $zip = new ZipArchive;

        if (request()->has('file')) {

            $zipFile = $request->file;

            if ($zip->open($zipFile) == true) {

                $zip->extractTo($extractTo);

                $zip->close();

                $files = File::files($extractTo);

                foreach ($files as $file) {

                    Gallery::create(['image' => $file->getFilename(), 'id_parent' => $identifier]);
                }



                Products::where('id', $identifier)->update(['status' => 0]);

                return response()->json(['check' => true]);
            } else {

                echo 'Failed to extract files.';
            }
        } else {

            return response()->json(['check' => false, 'msg' => 'file is required']);
        }
    }



    public function switchProduct(Request $request, $identifier)
    {
        $result = Products::findOrFail($identifier);
        if (!$result) {
            return response()->json(['check' => false, 'msg' => 'Not exists']);
        }
        $old = $result->status;
        if ($old == 0) {
            Products::where('id', $identifier)->update(['status' => 1]);
        } else {
            Products::where('id', $identifier)->update(['status' => 0]);
        }
        $result = $this->model::with('categories', 'brands')->get();
        return response()->json(['check' => true, 'data' => $result]);
    }

    public function update(Request $request, $identifier)
    {
        $validator = Validator::make($request->all(), [
            'price' => 'numeric|min:0',
            'discount' => 'numeric|min:0',
            'categories.*' => 'exists:categories,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }
        $data = $request->all();
        if ($request->name != '') {
            $data['slug'] = Str::slug($request->name);
        }
        if($request->has('categories')){
            unset($data['categories']);
            ProductCategory::where('id_product',$identifier)->delete();
            foreach ($request->categories as $key => $value) {
                ProductCategory::create(['id_product'=>$identifier,'id_categories'=>$value,'created_at'=>now()]);
            }
        }
        $result = $this->updateTraits($this->model, $identifier, $data);
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $file->storeAs('gallery', $fileName);
            Gallery::create([
                'image' => $fileName,
                'id_parent' => $result->id,
                'status' => 0,
            ]);
        }

        $result = $this->model::with('categories', 'brands')->get();
        return response()->json(['check' => true, 'data' => $result]);
    }



    public function destroy($identifier)
    {
        $product = Products::where('id', $identifier)->first();
        if (!$product) {
            return response()->json(['check' => false, 'msg' => 'Không tìm thấy sản phẩm']);
        }
        // $bill = Bill_Detail::where('id_product', $identifier)->first();
        // if ($bill) {
        //     return response()->json(['check' => false, 'msg' => 'Không thể xóa sản phẩm vì có tồn tại LSMH']);
        // }
        $images = Gallery::where('id_parent', $identifier)->select('image')->get();
        foreach ($images as $image) {
            $filePath = "public/products/{$image->image}";
            Storage::delete($filePath);
        }
        Gallery::where('id_parent', $identifier)->delete();
        Products::where('id', $identifier)->delete();
        $result = $this->model::with('categories', 'brands')->get();
        if (count($result) > 0) {
            return response()->json(['check' => true, 'result' => $result]);
        }
        return response()->json(['check' => true]);
    }
    public function import(Request $request)
    {
        if ($request->has('file')) {
            $file = $request->file('file');
            Excel::import(new ProductImport(), $file);
            return response()->json(['check' => true]);
        } else {
            return response()->json(['check' => false, 'msg' => 'File is required']);
        }
    }

    public function api_product(Request $request)
    {
        if ($request->has('limit')) {
            $result = Products::join('gallery', 'products.id', '=', 'gallery.id_parent')
                ->where('products.status', 1)
                ->where('gallery.status', 1)->select('products.*', 'gallery.image as image')
                ->take($request->limit)->get();
            return response()->json($result);
        } else {
            $result = Products::join('gallery', 'products.id', '=', 'gallery.id_parent')
                ->where('products.status', 1)
                ->where('gallery.status', 1)->select('products.*', 'gallery.image as image')
                ->paginate(16);
            return response()->json($result);
        }
    }
    // --------------------------------------
    public function api_search_product($slug)
    {
        $result = Products::join('gallery', 'products.id', '=', 'gallery.id_parent')
            ->where('products.status', 1)
            ->where('gallery.status', 1)
            ->where(function ($query) use ($slug) {
                $query->where('products.name', 'like', '%' . $slug . '%')
                    ->orWhere('products.slug', 'like', '%' . $slug . '%');
            })
            ->select('products.*', 'gallery.image as image')
            ->get();
        if (count($result) == 0) {
            return response()->json(['product' => []]);
        }
        return response()->json(['products' => $result]);
    }
    // --------------------------------------
    public function api_single_product($slug)
    {
        $result = Products::with(['brands', 'categories'])
        ->where('products.slug', $slug)
        ->where('products.status', 1)
        ->select('products.*')
            ->first();
        // $result = Products::with(['brands', 'categories', 'comments'])->where('products.slug', $slug)->where('products.status', 1)->select('products.*')
        //     ->first();
        if (!$result) {
            return response()->json([]);
        }
        $medias = Gallery::where('id_parent', $result->id)
        ->pluck('image');
        $result=ProductCategory::where('id_product',$result->id)->first();
        $id_cate=$result->id_categories;
        $cate_products = Products::join('product_categories', 'products.id', '=', 'product_categories.id_product')
        ->join('gallery', 'products.id', '=', 'gallery.id_parent')
        ->where('products.status', 1)
        ->where('product_categories.id_categories', $id_cate)
        ->where('gallery.status', 1)
        ->select('products.*', 'gallery.image as image')
        ->take(4);
        $brand_products = Products::join('gallery', 'products.id', '=', 'gallery.id_parent')
            ->where('products.status', 1)
            ->where('products.id_brand', $result->idBrand)
            ->where('gallery.status', 1)
            ->select('products.*', 'gallery.image as image')
            ->take(4);
        if ($brand_products->exists() && $cate_products->exists()) {
            $links = $cate_products->union($brand_products)->get();
        } elseif (!$brand_products->exists()) {
            $links = $cate_products->get();
        } else {
            $links = $brand_products->get();
        }
        return response()->json(['product' => $result, 'medias' => $medias, 'links' => $links]);
    }

    public function api_gallery_by_product_id(Request $request, $productId)
    {
        $product = Products::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        $images = Gallery::where('id_parent', $productId)
            ->where('status', 1)
            ->pluck('image');
        return response()->json(['images' => $images]);
    }

    public function api_load_cart_product(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cart' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(['check' => false, 'msg' => $validator->errors()->first()]);
        }
        $arr = [];
        foreach ($request->cart as $item) {
            $product = Products::join('gallery', 'products.id', '=', 'gallery.id_parent')->where('gallery.status', 1)->where('products.id', $item[0])->select('products.id', 'gallery.image', 'slug', 'name', 'price', 'discount')->get();
            foreach ($product as $item1) {
                $item2 = [
                    'id' => $item1->id,
                    'name' => $item1->name,
                    'slug' => $item1->slug,
                    'quantity' => $item[1],
                    'discount' => (int)$item1->discount,
                    'price' => (int)$item1->price,
                    'image' => $item1->image,
                    'total' => (int)$item1->discount * $item[1],
                ];
                array_push($arr, $item2);
            }
        }
        return response()->json($arr);
    }}
