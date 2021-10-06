<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Brand;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Log;

class AdminLocationController extends Controller
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
        $locations = Acl::getMyLocations()->paginate(10);
        $brands = Acl::getMyBrands()->where('active',true)->get();

        return view('admin.locations.index',[
            'locations' => $locations,
            'brands' => $brands
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Acl::getMyBrands()->where('active',true)->get();
        return view('admin.locations.create',[
            'brands' => $brands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Location::$rules);
        //$b_id = $request->brand_id;
        //$request->request->remove('brand_id');
        $location = new Location();
        $location->fill($request->all());
        $location->user_id = Auth::user()->id;
        $location->active = isset($request->active) ? 1 : 0;
        $location->save();
        $location->acls()->sync(Auth::user()->getMyRoot());
        Log::info('Store new location from user: '.\Auth::user()->username);

        return redirect()->back()->with('success', __('admin_locations.success_location_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Location $location, $id)
    {
        if($location = Location::find($id)) {
            $brand = $location->brand->description;
            if($request->ajax()){
                $location->toArray();
                $location = array_add($location,'brand',$brand);
                return response()->json([$location]);
            }
            return view('admin.brands.show',[
                'location' => $location,
                'brand' => $brand,
            ]);
        }

        return redirect()->back()->with('warning', __('admin_locations.warning_location_NOTfound'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function edit(Location $location, $id)
    {
        if($location = Location::find($id)) {
            $brands = Acl::getMyBrands()->where('active',true)->get();
            return view('admin.locations.edit',[
                'location' => $location,
                'brands' => $brands,
            ]);
        }

        return redirect()->back()->with('warning', __('admin_locations.warning_location_NOTfound'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location, $id)
    {

        if($location = Location::find($id)) {
            if($request->ajax()){
                $location->active = $request->active;
                $location->save();
                Log::info('Update location id: '.$id.' from user: '.\Auth::user()->username);
                return response()->json(['success' => __('admin_locations.success_location_updated')]);
            }
            //dd($request->all());
            $this->validate($request, Location::$rules);
            $location->fill($request->all());
            $location->user_id = Auth::user()->id;
            $location->active = isset($request->active) ? $request->active : false;
            $location->save();
            Log::info('Update location id: '.$id.' from user: '.\Auth::user()->username);

            return redirect()->back()->with('success', __('admin_locations.success_location_updated'));
        }
        Log::warning('Fault from updating location id: '.$id.' with error: '.__('admin_locations.warning_location_NOTupdated'));
        return redirect()->back()->with('warning',__( 'admin_locations.warning_location_NOTupdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location, $id)
    {
        if($location = Location::find($id)) {

            $location->acls()->detach();
            $location->delete();
            Log::info('Delete location id: '.$id.' from user: '.\Auth::user()->username);

            return redirect()->back()->with('success', __('admin_locations.success_location_destroy'));
        }
        Log::warning('Fault from deleting location id: '.$id.' with error: '.__('admin_locations.warning_location_NOT_deleted'));
        return redirect()->back()->with('warning',__( 'admin_locations.warning_location_NOT_deleted'));
    }
}
