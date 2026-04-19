<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use App\Models\Subcategory;
use App\Models\Supplier;
use App\Models\WareHouse;
use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Spatie\Permission\Models\Role;

class ProductController extends Controller
{
    public function AllCategory()
    {
        $category = ProductCategory::latest()->get();
        return view('admin.backend.category.all_category', compact('category'));
    }
    //End Method

    public function StoreCategory(Request $request)
    {

        ProductCategory::insert([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);

        $notification = array(
            'message' => 'ProductCategory Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    //End Method

    public function EditCategory($id)
    {
        $category = ProductCategory::find($id);
        return response()->json($category);
    }
    //End Method

    public function UpdateCategory(Request $request)
    {
        $cat_id = $request->cat_id;

        ProductCategory::find($cat_id)->update([
            'category_name' => $request->category_name,
            'category_slug' => strtolower(str_replace(' ', '-', $request->category_name)),
        ]);

        $notification = array(
            'message' => 'ProductCategory Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    //End Method

    public function DeleteCategory($id)
    {

        ProductCategory::find($id)->delete();
        $notification = array(
            'message' => 'ProductCategory Delete Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    //End Method


    ///// Subcategory all Methods

    public function AllSubcategory()
    {
        $subcategory = Subcategory::with('category')->latest()->get();
        return view('admin.backend.subcategory.all_subcategory', compact('subcategory'));
    }
    //End Method

    public function AddSubcategory()
    {
        $categories = ProductCategory::all();
        return view('admin.backend.subcategory.add_subcategory', compact('categories'));
    }
    //End Method

    public function StoreSubcategory(Request $request)
    {

        Subcategory::insert([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = array(
            'message' => 'Subcategory Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    //End Method

    public function EditSubcategory($id)
    {
        $subcategory = Subcategory::find($id);
        return response()->json($subcategory);
    }
    //End Method

    public function EditSubcategoryPage($id)
    {
        $subcategory = Subcategory::find($id);
        $categories = ProductCategory::all();
        return view('admin.backend.subcategory.edit_subcategory', compact('subcategory', 'categories'));
    }
    //End Method

    public function UpdateSubcategory(Request $request)
    {
        $subcat_id = $request->id;

        Subcategory::find($subcat_id)->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->subcategory_name,
            'subcategory_slug' => strtolower(str_replace(' ', '-', $request->subcategory_name)),
        ]);

        $notification = array(
            'message' => 'Subcategory Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    //End Method

    public function DeleteSubcategory($id)
    {

        Subcategory::find($id)->delete();
        $notification = array(
            'message' => 'Subcategory Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    //End Method


    ///// Add Product all Methods


    public function AllProduct()
    {
        $allData = Product::with(['category', 'subcategory', 'images', 'brand', 'allowedRoles'])->orderBy('id', 'desc')->get();
        return view('admin.backend.product.product_list', compact('allData'));
    }
    //End Method

    public function AddProduct()
    {
        $categories = ProductCategory::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        $subcategories = Subcategory::all();
        $roles = Role::all();
        return view('admin.backend.product.add_product', compact('categories', 'brands', 'suppliers', 'warehouses', 'subcategories', 'roles'));
    }
    //End Method

    public function StoreProduct(Request $request)
    {
        $request->validate([
            'role_ids' => ['required', 'array', 'min:1'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ]);

        $product = Product::create([
            'name' => $request->name,
            'code' => $request->code,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'brand_id' => $request->brand_id,
            // 'warehouse_id' => $request->warehouse_id,
            // 'supplier_id' => $request->supplier_id,
            // 'price' => $request->price,
            // 'stock_alert' => $request->stock_alert,
            'note' => $request->note,
            'product_qty' => $request->product_qty,
            // 'status' => $request->status,
            'created_at' => now(),
        ]);

        $product->load(['category', 'subcategory', 'brand']);
        $product->sku = Product::generateSKU(
            $product->category?->category_name ?? '',
            $product->subcategory?->subcategory_name ?? '',
            $product->brand?->name ?? '',
            $product->name ?? '',
            (int) $product->id
        );
        $product->save();

        $product->allowedRoles()->sync($request->input('role_ids', []));

        $product_id = $product->id;

        /// Multiple Image Upload
        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                $imgs = $manager->read($img);
                $imgs->resize(150, 150)->save(public_path('upload/productimg/' . $name_gen));
                $save_url = 'upload/productimg/' . $name_gen;

                ProductImage::create([
                    'product_id' => $product_id,
                    'image' => $save_url
                ]);
            }
        }

        $notification = array(
            'message' => 'Product Inserted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.product')->with($notification);

    }
    //End Method

    public function EditProduct($id)
    {
        $editData = Product::with('allowedRoles')->findOrFail($id);
        $categories = ProductCategory::all();
        $brands = Brand::all();
        $suppliers = Supplier::all();
        $warehouses = WareHouse::all();
        $subcategories = Subcategory::where('category_id', $editData->category_id)->get();
        $multiimg = ProductImage::where('product_id', $id)->get();
        $roles = Role::all();
        return view('admin.backend.product.edit_product', compact('categories', 'brands', 'suppliers', 'warehouses', 'editData', 'multiimg', 'subcategories', 'roles'));
    }
    //End Method

    public function UpdateProduct(Request $request)
    {
        $request->validate([
            'role_ids' => ['required', 'array', 'min:1'],
            'role_ids.*' => ['integer', 'exists:roles,id'],
        ]);

        $pro_id = $request->id;

        $product = Product::findOrFail($pro_id);

        $product->name = $request->name;
        $product->code = $request->code;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->stock_alert = $request->stock_alert;
        $product->note = $request->note;
        $product->warehouse_id = $request->warehouse_id;
        $product->supplier_id = $request->supplier_id;
        $product->product_qty = $request->product_qty;
        $product->status = $request->status;
        $product->save();

        $product->allowedRoles()->sync($request->input('role_ids', []));

        if ($request->hasFile('image')) {
            foreach ($request->file('image') as $img) {
                $manager = new ImageManager(new Driver());
                $name_gen = hexdec(uniqid()) . '.' . $img->getClientOriginalExtension();
                $imgs = $manager->read($img);
                $imgs->resize(150, 150)->save(public_path('upload/productimg/' . $name_gen));

                $product->images()->create([
                    'image' => 'upload/productimg/' . $name_gen
                ]);

            }
        }


        if ($request->has('remove_image')) {
            foreach ($request->remove_image as $removeImageId) {
                $img = ProductImage::find($removeImageId);
                if ($img) {
                    if (file_exists(public_path($img->image))) {
                        unlink(public_path($img->image));
                    }
                    $img->delete();
                }
            }
        }

        $notification = array(
            'message' => 'Product Updaetd Successfully',
            'alert-type' => 'success'
        );
        return redirect()->route('all.product')->with($notification);

    }
    //End Method

    public function DeleteProduct($id)
    {
        $product = Product::findOrFail($id);

        /// Delete associated images
        $images = ProductImage::where('product_id', $id)->get();
        foreach ($images as $img) {
            $imagePath = public_path($img->image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }

        // Delete image from records
        ProductImage::where('product_id', $id)->delete();

        // Delete the product
        $product->delete();

        $notification = array(
            'message' => 'Product Deleted Successfully',
            'alert-type' => 'success'
        );
        return redirect()->back()->with($notification);

    }
    //End Method

    public function DetailsProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.backend.product.details_product', compact('product'));
    }
    //End Method


    ///// Get Subcategory by Category (AJAX)

    public function GetSubcategory($category_id)
    {
        $subcategories = Subcategory::where('category_id', $category_id)->get();
        return response()->json($subcategories);
    }
    //End Method



}
