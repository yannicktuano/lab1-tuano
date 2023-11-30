<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Ramsey\Uuid\Type\Hexadecimal;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    //
    public function AllBrand()
    {
        $brands = Brand::latest()->paginate(10);
        $trashCat = Brand::onlyTrashed()->latest()->paginate(10);
        return view('brand.index', compact('brands', 'trashCat'));
    }

    public function AddBrand(Request $request)
    {
        $validated = $request->validate([
            'brand_name' => 'required|unique:brands|max:255',
            'brand_image' => 'required|mimes:jpg,jpeg,png',
        ], [
            'brand_name.required' => 'please input brand name',
            'brand_name.max' => 'Brand name must be less the 255 characters',

        ]);

        $brand_image = $request->file('brand_image');

        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($brand_image->getClientOriginalExtension());
        $image_name = $name_gen . '.' . $img_ext;
        $up_loc = 'image/brand/';
        $last_img = $up_loc . $image_name;

        $brand_image->move($up_loc, $image_name);

        Brand::insert([
            'brand_name' => $request->brand_name,
            'brand_image' => $last_img,
            'created_at' => Carbon::now()
        ]);
        return redirect()->back()->with('success', 'Brand Inserted Successfully');
    }


    public function Edit($id)
    {
        $brands = Brand::find($id);
        return view('brand.edit', compact('brands'));
    }

    public function Update(Request $request, $id)
    {
        Brand::find($id)->update([
            'brand_name' => $request->brand_name,
        ]);
        return Redirect()->route('brand')->with('success', 'Updated Succesfully');
    }

    public function RemoveCat($id)
    {
        $remove = Brand::find($id)->delete();
        return Redirect()->back()->with('success', 'Category Removed Successfully');
    }

    public function RestoreCat($id)
    {
        $restore = Brand::withTrashed()->find($id)->restore();
        return Redirect()->back()->with('success', 'Category Restored Successfully');
    }

    public function DeleteCat($id)
    {
        $delete = Brand::onlyTrashed()->find($id)->forceDelete();
        return Redirect()->back()->with('success', 'Category Deleted Successfully');
    }
}
