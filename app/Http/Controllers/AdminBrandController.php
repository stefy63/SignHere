<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\brands2acl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::where('active',true)->paginate(10);

        return view('admin.brands.index',[
            'brands' => $brands,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $this->validate($request, Brand::$rules);

        $acl_id = brands2acl::create(['acl_id' => '1']);

        $brand = new Brand();
        $brand->fill($request->all());
        $brand->user_id = Auth::user()->id;
        $brand->brands2acl_id = $acl_id->id;
        $brand->active = isset($request->active) ? $request->active : false;

        $brand->save();
        return redirect()->back()->with('success', __('admin_brands.success_brand_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        dd('SHOW');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand, $id)
    {
        if($brand = Brand::find($id)) {
            return view('admin.brands.edit',[
                'brand' => $brand,
            ]);
        }

        return redirect()->back()->with('warning', 'admin_brands.warning_brand_NOTfound');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Brand $brand, $id)
    {
        if($brand = Brand::find($id)) {

            //dd($request->all());
            $brand->fill($request->all());
            $brand->active = isset($request->active) ? $request->active : false;
            $brand->save();
            return redirect()->back()->with('success', __('admin_brands.success_brand_updated'));
        }
        return redirect()->back()->with('warning', 'admin_brands.warning_brand_NOTupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy(Brand $brand)
    {
       return redirect()->back()->with('success', __('admin_brands.success_brand_destroy'));
    }
}
