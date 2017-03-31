<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Brand;
use App\Models\brand_acl;
use App\Models\user_acl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBrandController extends Controller
{

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct(Acl $acls)
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
        $brand->active = isset($request->active) ? $request->active : false;
        $brand->save();
        $brand->acls()->attach(  '1');
        //$acls = brand_acl::create(['brand_id' => $brand->id,'acl_id' => '1']);

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
    public function destroy(Brand $brand, $id)
    {
        if($brand = Brand::find($id)) {

            brand_acl::where('brand_id',$id)->delete();
            $brand->acls()->detach();
            $brand->delete();

            return redirect()->back()->with('success', __('admin_brands.success_brand_destroy'));
        }
        return redirect()->back()->with('warning', 'admin_brands.warning_brand_NOT deleted');
    }
}
