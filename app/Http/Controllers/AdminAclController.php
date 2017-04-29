<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Visibility;
use App\Models\Brand;
use App\Models\User;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use MongoDB\BSON\Javascript;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $this->validate($request, Acl::$rules);

        $visibility = new Acl();
        $visibility->name = $request->nsigname;
        $visibility->description = $request->description;
        $visibility->parent_id = $request->parent_id;
        $visibility->user_id = \Auth::user()->id;
        DB::beginTransaction();
        try {
            $visibility->save();

            $visibility->brands()->sync([$request->brand_id]);
            $users = (is_array($request->users)) ? $request->users : array();
            ($request->locations) ? $visibility->locations()->sync(array_keys($request->locations)) : $visibility->locations()->detach();
            ($request->devices) ? $visibility->devices()->sync(array_keys($request->devices)) : $visibility->devices()->detach();
            ($request->profiles) ? $visibility->profiles()->attach(array_keys($request->profiles)) : $visibility->profiles()->detach();
            $visibility->users()->sync(array_keys($users));
            DB::commit();

            return redirect()->back()->with('success', __('admin_acls.success_acl_create'));
        } catch (Exception $e) {
            DB::rollback();
            return redirect()->back()->with('DB-error', $e->getMessage());
        }
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
     * @return \Illuminate\Http\Response
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
            $this->validate($request, Acl::$rules);

            $myRoots = \Auth::user()->getMyRoot();
            $visibility->name = $request->name;
            $visibility->description = $request->description;
            (array_search($id,$myRoots)>=0)? :$visibility->parent_id = $request->parent_id;
            $visibility->user_id = \Auth::user()->id;
            DB::beginTransaction();
            try {
                $visibility->save();

                $visibility->brands()->sync([$request->brand_id]);
                $users = (is_array($request->users))?$request->users:array();
                if(in_array($id,$myRoots)){
                    (array_key_exists(Auth::user()->id,$users))? :$users = array_add($users,Auth::user()->id,'on');
                } else {
                    if($visibility->locations()->count()>0){
                        ($request->locations)?$visibility->locations()->sync(array_keys($request->locations)):$visibility->locations()->detach();
                    }

                    if($visibility->devices()->count()>0){
                        ($request->devices)?$visibility->devices()->sync(array_keys($request->devices)):$visibility->devices()->detach();
                    }
                    if($visibility->profiles()->count()>0){
                        ($request->profiles)?$visibility->profiles()->sync(array_keys($request->profiles)):$visibility->profiles()->detach();
                    }
                }
                $myUsers = Acl::getMyUsers()->get();
                $visibility->users()->sync(array_keys($users));

                foreach ($myUsers as $user){
                    if($user->acls()->get()->count()<1){
                        $user->acls()->attach($myRoots[0]);
                    }
                }
                DB::commit();
                return redirect()->back()->with('success', __('admin_acls.success_acl_edit'));
            } catch (Exception $e) {
                DB::rollback();
                return redirect()->back()->with('DB-error', $e->getMessage());
            }
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
            $users = Acl::getMyUsers()->where('active',true)->get();
            $profiles = Acl::getMyProfiles()->where('active',true)->get();

            return response()->json([$locations,$devices,$users,$profiles]);
        }
        return redirect()->back()->with('warning', 'admin_acls.warning_acl_NOTfound');
    }

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
