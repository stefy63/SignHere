<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Visibility;
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
        $tree = $this->_makeTree();

        return view('admin.visibility.index',[
            'acls' => $acls,
            'tree' => $tree,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Acl::getMyBrands()->where('active',true)->count() == 0)
        {
            return redirect()->back()->with('warning', __('admin_acls.warning_acl_brands_necessity'));
        }
        $acls = Acl::getMyAcls()->where('active',true)->get();
        $brands = Acl::getMyBrands()->where('active',true)->get();
        $locations = Acl::getMyLocations()->where('active',true)->get();
        $devices = Acl::getMyDevices()->where('active',true)->get();
        $users = Acl::getMyUsers()->where('active',true)->get();
        $profiles = Acl::getMyProfiles()->where('active',true)->get();

        return view('admin.visibility.create',[
            'brands' => $brands,
            'acls' => $acls,
            'locations' => $locations,
            'devices' => $devices,
            'users' => $users,
            'profiles' => $profiles,
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
        $this->validate($request, Visibility::$rules);

        $visibility = new Acl();
        $visibility->name = $request->name;
        $visibility->description = $request->description;
        $visibility->user_id = \Auth::user()->id;
        $visibility->parent_id = $request->parent_id;
        $visibility->save();

        $users = (is_array($request->users))?$request->users:array();
        //(array_key_exists('1',$users))?:$users = ['1' => '1'];
        $visibility->brands()->sync([$request->brand_id]);
        ($request->locations)?$visibility->locations()->sync(array_keys($request->locations)):$visibility->locations()->detach();
        ($request->devices)?$visibility->devices()->sync(array_keys($request->devices)):$visibility->devices()->detach();
        ($request->profiles)?$visibility->profiles()->sync(array_keys($request->profiles)):$visibility->profiles()->detach();
        $visibility->users()->sync(array_keys($users));

        return redirect()->back()->with('success', __('admin_acls.success_acl_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Acl $acl,$id)
    {
        if ($request->ajax()) {
            $acl = Acl::find($id);
            $brands = $acl->brands()->where('active', true)->get();
            $locations = $acl->locations()->where('active', true)->get();
            $devices = $acl->devices()->where('active', true)->get();
            $users = $acl->users()->where('active', true)->get();
            $profiles = $acl->profiles()->where('active', true)->get();

            return response()->json([$brands, $locations, $devices, $users,$profiles]);
        }
        return redirect()->back()->with('warning', __('admin_acls.warning_acl_NOTfound'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Acl  $acl
     * @return \Illuminate\Http\Response               dd($userAcls);
 dd($userAcls);

     */
    public function edit(Acl $acl,$id)
    {
        if(Acl::getMyBrands()->where('active',true)->count() == 0)
        {
            return redirect()->back()->with('warning', __('admin_acls.warning_acl_brands_necessity'));
        }
        $acl = Acl::find($id);
        $parent = $acl->getMyAcls()->where('active',true)->get();
        $brands = $acl->getMyBrands()->where('active',true)->get();
        $locations = $acl->getMyLocations()->where('active',true)->get();
        $devices = $acl->getMyDevices()->where('active',true)->get();
        $users = $acl->getMyUsers()->where('active',true)->get();
        $profiles = $acl->getMyProfiles()->where('active', true)->get();

        return view('admin.visibility.edit',[
            'brands' => $brands,
            'locations' => $locations,
            'devices' => $devices,
            'users' => $users,
            'parent' => $parent,
            'acl' => $acl,
            'profiles' => $profiles,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Acl $acl,$id)
    {
        if($visibility = Acl::find($id)) {
            $this->validate($request, Visibility::$rules);

            $visibility->name = $request->name;
            $visibility->description = $request->description;
            $visibility->user_id = \Auth::user()->id;
            $visibility->parent_id = $request->parent_id;
            $visibility->save();

            $users = (is_array($request->users))?$request->users:array();
            //(array_key_exists('1',$users))?:$users = ['1' => '1'];
            ($request->brand_id)?$visibility->brands()->sync([$request->brand_id]):$visibility->brands()->detach();
            ($request->locations)?$visibility->locations()->sync(array_keys($request->locations)):$visibility->locations()->detach();
            ($request->devices)?$visibility->devices()->sync(array_keys($request->devices)):$visibility->devices()->detach();
            ($request->profiles)?$visibility->profiles()->sync(array_keys($request->profiles)):$visibility->profiles()->detach();
            $visibility->users()->sync(array_keys($users));

            return redirect()->back()->with('success', __('admin_acls.success_acl_edit'));
             }
        return redirect()->back()->with('warning', __('admin_acls.warning_acl_NOTupdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Acl  $acl
     * @return \Illuminate\Http\Response
     */
    public function destroy(Acl $acl,$id)
    {
        if($id != 1) {
            $visibility = Acl::find($id);
            $visibility->delete();

            return redirect()->back()->with('success', __('admin_acls.success_acl_destroy'));
        }
        return redirect()->back()->with('warning', __('admin_acls.warning_acl_NOT_deleted'));
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
            $users = Acl::getMyUsers()->where('active',true)->get()->toArray();
            $profiles = Acl::getMyProfiles()->where('active',true)->get()->toArray();

            return response()->json([$locations,$devices,$users,$profiles]);
        }
        return redirect()->back()->with('warning', 'admin_acls.warning_acl_NOTfound');
    }

   /* protected function _makeTree($root = false){
        ($root)? :$root = \Auth::user()->getMyForest();
        $temp = "\n<ul>\n";
        foreach ($root[0] as $v ) {
            $temp .= "<li id='".$v['id']."'>".$v['name'];
            if (isset($v['branch'])){
                $temp .= $this->_makeTree([$v['branch']]);
            }
            $temp .= "</li>\n";
        }
        $temp .= "</ul>\n";
        return $temp;
    } */

    protected function _makeTree($roots = false){
        ($roots)? :$roots = \Auth::user()->getMyForest();//dd($roots);
        $temp = "\n<ul>\n";
        foreach ($roots as $v ) {
            $temp .= "<li id='".$v['id']."'>".$v['name'];
            if (isset($v['branch'])){
                $temp .= $this->_makeTree($v['branch']);
            }
            $temp .= "</li>\n";
        }
        $temp .= "</ul>\n";
        return $temp;
    }

}
