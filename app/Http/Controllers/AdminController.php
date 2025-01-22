<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;

class AdminController extends Controller
{
    public function index(){
        return view ('admin.index');
    }

    public function brands(){
        $brands = Brand::orderBy('id','DESC')->paginate(10);
        return view('admin.brands', compact('brands'));
    }

    public function add_brand(){
        return view('admin.brand-add');
    }
    public function brand_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug',
            'image' => 'required|mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        $brand = new Brand();
        $brand->name = $request -> name;
        $brand->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp . '.' . $file_extension;
        $this->GenerateBrandThumbnailsImage($image,$file_name);
        $brand->image = $file_name;
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand has been added Successfully!');
    }


    public function GenerateBrandThumbnailsImage($image, $imageName){
        $destinationPath = public_path('assets/uploads/brands');
        $img = Image::read($image->getPathname());
        $img->cover(124,124,"top");
        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }

    //TO EDIT
    public function brand_edit($id){
        $brand= Brand::find($id);
        return view('admin.brand-edit', compact('brand'));
    }
    public function brand_update(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:brands,slug,',
            'image' => 'mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        $brand = Brand::find($request->id);
        $brand->name = $request -> name;
        $brand->slug = Str::slug($request->name);
        if($request->hasFile('image')){
            if(File::exists(public_path('assets/uploads/brands').'.'.$brand->image)){
                File::delete(public_path('assets/uploads/brands'). '.'.$brand->image);
            }
            $image = $request->file('image');
            $file_extension = $request->file('image')->extension();
            $file_name = Carbon::now()->timestamp . '.' . $file_extension;
            $this->GenerateBrandThumbnailsImage($image,$file_name);
            $brand->image = $file_name;
        }
        $brand->save();
        return redirect()->route('admin.brands')->with('status', 'Brand has been updated Successfully!');
    }

    public function brand_delete($id){
        $brand = Brand::find($id);
        if(File::exists(public_path('assets/uploads/brands'). '.'.$brand->image)){
            File::delete(public_path('assets/uploads/brands'). '.'.$brand->image);
        }
        $brand->delete();
        return redirect()->route('admin.brands')->with('status','Brand Deleted Successfully!');
    }

    public function categories(){
        $categories = Category::orderBy('id','DESC')->paginate(10);
        return view('admin.categories',compact('categories'));
    }

    public function category_add(){
        return view('admin.category-add');
    }
    public function category_store(Request $request){
        $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories,slug,',
            'image' => 'mimes:jpg,jpeg,png,gif,svg|max:2048',
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->slug = Str::slug($request->name);
        $image = $request->file('image');
        $file_extension = $request->file('image')->extension();
        $file_name = Carbon::now()->timestamp. '.' .$file_extension;
        $this->GenerateCategoryThumbnailsImage($image,$file_name);
        $category->image = $file_name;
        $category->save();
        return redirect()->route('admin.categories')->with('status','Category has been added Successfully!');
    }
    public function GenerateCategoryThumbnailsImage($image, $imageName){
        $destinationPath = public_path('assets/uploads/categories');
        $img = Image::read($image->getPathname());
        $img->cover(124,124,"top");
        $img->resize(124,124,function($constraint){
            $constraint->aspectRatio();
        })->save($destinationPath.'/'.$imageName);
    }

}
