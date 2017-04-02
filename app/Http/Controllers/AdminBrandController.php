<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Brand;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBrandController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('hasRole');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Acl::getMyBrands()->paginate(10);

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
        $this->validate($request, Brand::$rules);

        $brand = new Brand();
        $brand->fill($request->all());
        $brand->user_id = Auth::user()->id;
        $brand->active = isset($request->active) ? 1 : 0;
        $brand->save();
        $brand->acls()->attach(  '1');

        return redirect()->back()->with('success', __('admin_brands.success_brand_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Brand $brand, $id)
    {
        if($brand = Brand::find($id)) {
            if($request->ajax()){
                return response()->json([$brand]);
            }
            return view('admin.brands.show',[
                'brand' => $brand,
            ]);
        }

        return redirect()->back()->with('warning', 'admin_brands.warning_brand_NOTfound');
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
            if($request->ajax()){
                $brand->active = $request->active;
                $brand->save();
                return response()->json(['success' => __('admin_brands.success_brand_updated')]);
            }
            //dd($request->all());
            $this->validate($request, Brand::$rules);

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
    public function destroy(Brand $brand, $id)
    {
        if($brand = Brand::find($id)) {

            $brand->acls()->detach();
            Location::where('brand_id',$brand->id)->delete();
            $brand->delete();

            return redirect()->back()->with('success', __('admin_brands.success_brand_destroy'));
        }
        return redirect()->back()->with('warning', 'admin_brands.warning_brand_NOT deleted');
    }
}
