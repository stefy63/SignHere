<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Brand;
use Illuminate\Http\Request;
use MongoDB\BSON\Javascript;

class AdminAclController extends Controller
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
        $acls = Acl::getMyAcls()->get();

        return view('admin.visibility.index',[
            'acls' => $acls,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $acls = Acl::getMyAcls();
        $brands = Acl::getMyBrands()->where('active',true)->get();
        $locations = Acl::getMyLocations()->where('active',true)->get();
        $devices = Acl::getMyDevices()->where('active',true)->get();
        $users = Acl::getMyUsers()->where('active',true)->get();

        return view('admin.visibility.create',[
            'brands' => $brands,
            'locations' => $locations,
            'devices' => $devices,
            'users' => $users,
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
        dd($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Acl $acl,$id)
    {
        if($request->ajax()){
            $acl = Acl::find($id);
            $brands = $acl->getMyBrands()->where('active',true)->get();
            $locations = $acl->getMyLocations()->where('active',true)->get();
            $devices = $acl->getMyDevices()->where('active',true)->get();
            $users = $acl->getMyUsers()->where('active',true)->get();

            return response()->json([$brands,$locations,$devices,$users]);
        }
        return redirect()->back()->with('warning', 'admin_acls.warning_acl_NOTfound');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function edit(Acl $acl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acl $acl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acl $acl)
    {
        //
    }


    /**
     * Return the specified resource from storage.
     *
     * @param  \App\Models\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function getItem(Request $request, $id)
    {
        if($request->ajax()){
            $locations = Acl::getMyLocations()
                ->where('brand_id',$id)
                ->where('active',true)
                ->get();
            $devices = Acl::getMyDevices()->where('active',true)->get();
            $users = Acl::getMyUsers()->where('active',true)->get();

            return response()->json([$locations,$devices,$users]);
        }
        return redirect()->back()->with('warning', 'admin_acls.warning_acl_NOTfound');
    }

}
