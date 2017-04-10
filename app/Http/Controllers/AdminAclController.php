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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
            //
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
            $brands = Acl::find($id)->getMyBrands()->get();
            $locations = Acl::find($id)->getMyLocations()->get();
            $devices = Acl::find($id)->getMyDevices()->get();
            $users = Acl::find($id)->getMyUsers()->get();

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



}
