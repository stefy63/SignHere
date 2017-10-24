<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use Illuminate\Support\Facades\Auth;
use App\Models\Module;
use App\Models\Profile;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Array_;

class AdminProfileController extends Controller
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
    public function index(Request $request)
    {
        $profiles = Acl::getMyProfiles()->get();
        $modules = Module::where('active',true)->get();
        //dd($modules);
        return view('admin.profiles.index',[
            'profiles' => $profiles,
            'modules'  => $modules
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modules = Module::where('active',true)->get();
        return view('admin.profiles.create',[
            'modules'  => $modules
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
        $this->validate($request, Profile::$rules);

        $profile = new Profile();
        $profile->name = $request->name;
        $profile->user_id = \Auth::user()->id;
        $profile->save();
        $Modules = array();
        foreach ($request->permission as $module => $functions) {
            if($functions) {
                $permission = "";
                foreach ($functions as $func => $val){
                 $permission .= $func.',';
                }
                $permission = rtrim($permission,',');
                $Modules = array_add($Modules,$module , ['permission' => $permission]);
            }
        }
        $profile->modules()->sync($Modules);
        $profile->acls()->sync(Auth::user()->getMyRoot());
        return redirect()->back()->with('success', __('admin_profiles.success_profile_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        if($request->ajax()){
            $profile = Profile::find($id)->getModules()->get();
            return response()->json([$profile]);
        }
        return redirect()->back()->with('warning', __('admin_profiles.warning_profile_NOTfound'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function edit(Profile $profile, $id)
    {
        $profile = Profile::find($id);
        $modules = Module::where('active',true)->get();
        //$my_modules = $profile->getModules();
        //dd(modules);
        return view('admin.profiles.edit',[
            'profile' => $profile,
            'modules'  => $modules,
            //'my_modules'  => $my_modules
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Profile $profile, $id)
    {
        //dd($request->permission);

        if($profile = Profile::find($id)) {

            $this->validate($request, Profile::$rules);
            $profile->name = $request->name;
            $profile->user_id = \Auth::user()->id;
            $profile->save();
            $Modules = array();
            foreach ($request->permission as $module => $functions) {
                if($functions) {
                    $permission = "";
                    foreach ($functions as $func => $val){
                     $permission .= $func.',';
                    }
                    $permission = rtrim($permission,',');
                    $Modules = array_add($Modules,$module , ['permission' => $permission]);
                }
            }
            $profile->modules()->sync($Modules);
            return redirect()->back()->with('success', __('admin_profiles.success_profile_updated'));
        }
        return redirect()->back()->with('warning', __('admin_profiles.warning_profile_NOTupdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Profile  $profile
     * @return \Illuminate\Http\Response
     */
    public function destroy(Profile $profile, $id)
    {
        if($profile = Profile::find($id)) {

            $profile->modules()->detach();
            $profile->delete();

            return redirect()->back()->with('success', __('admin_profiles.success_profile_destroy'));
        }
        return redirect()->back()->with('warning', __('admin_profiles.warning_profile_NOT_deleted'));
    }
}
