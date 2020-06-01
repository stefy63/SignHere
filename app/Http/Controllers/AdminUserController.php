<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Acl;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

class AdminUserController extends Controller
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
        $users = Acl::getMyUsers()->paginate(10);

        return view('admin.users.index',[
            'users' => $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $profiles = Acl::getMyProfiles()->get();
        $locations = Acl::getMyLocations()->where('active',true)->get();

        return view('admin.users.create',[
                'profiles' => $profiles,
                'locations'=> $locations
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

        $this->validate($request,User::$rules);
        $user = new User();
        try{
            if ($locations = $request->locations){
                $user->fill($request->except('locations'));
            } else {
                $user->fill($request->all());
            }
            $user->active = isset($request->active) ? 1 : 0;
            $user->api_token = str_random(60);
            $user->user_id = \Auth::user()->id;
            $user->password = bcrypt($request->password);
            $user->save();
            $user->acls()->sync(Auth::user()->getMyRoot());
            if($locations){
                $user->locations()->sync($locations);
            }
            Log::info('Store new user from user: '.\Auth::user()->username);
        } catch (\Exception $e) {
            Log::error('Fault from store new user with error: '.$ex->getMessage());
            return redirect()->back()->with('alert', $e->getMessage());
        }
        Log::warning('Fault from store new user with error: '.__('admin_users.success_user_create'));
        return redirect()->back()->with('success', __('admin_users.success_user_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if($user = User::find($id)) {
            $profiles = Acl::getMyProfiles()->get();
            $locations = Acl::getMyLocations()->where('active',true)->get();


            return view('admin.users.edit',[
                'user' => $user,
                'profiles' => $profiles,
                'locations'=> $locations,
            ]);
        }

        return redirect()->back()->with('warning', __('admin_users.warning_user_NOTfound'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if($user = User::find($id)) {
            if($request->ajax()){
                if($id != 1) {
                    $user->active = $request->active;
                    $user->save();
                    Log::info('Update user id: '.$id.' from user: '.\Auth::user()->username);
                    return response()->json(['success' => __('admin_users.success_user_updated')]);
                } else {
                    Log::info('Fault update user id: '.$id.' from user: '.\Auth::user()->username);
                    return response()->json(['warning' => __('admin_users.warning_user_NOTupdated')]);
                }
            }
            Validator::make($request->all(),['username'=>['required',Rule::unique('users')->ignore($id)],'email'=>['required',Rule::unique('users')->ignore($id)]])->validate();

            try{
                if ($locations = $request->locations){
                    $user->fill($request->except('locations'));
                } else {
                    $user->fill($request->all());
                }
                 $user->active = ($id == 1)? 1 :isset($request->active) ? 1 : 0;
                 $user->user_id = \Auth::user()->id;
                 $user->profile_id = $request->profile_id;
                 $user->save();
                 if($locations){
                    $user->locations()->sync($locations);
                 }
                Log::info('Update user id: '.$id.' from user: '.\Auth::user()->username);
                Log::info('Update user id: '.$id.' from user: '.\Auth::user()->username);
            } catch (\Exception $e) {
                Log::error('Fault from updating user id: '.$id.' with error: '.$e->getMessage());
                return redirect()->back()->with('alert', $e->getMessage());
            }
            Log::warning('Fault from updating user id: '.$id.' with error: '.__('admin_users.success_user_updated'));
            return redirect()->back()->with('success', __('admin_users.success_user_updated'));
        }

        Log::warning('Fault from updating user id: '.$id.' with error: '.__('admin_users.warning_user_NOTupdated'));
        return redirect()->back()->with('warning', __('admin_users.warning_user_NOTupdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($user = User::find($id) && $id > 1) {

            $user->acls()->detach();
            $user->modules()->detach();
            $user->devices()->detach();
            $user->locations()->detach();
            $user->locations()->detach();
            $user->delete();
            Log::info('Delete user id: '.$id.' from user: '.\Auth::user()->username);

            return redirect()->back()->with('success', __('admin_users.success_user_destroy'));
        }
        Log::warning('Fault from deleting user id: '.$id.' with error: '.__('admin_users.warning_user_NOTupdated'));
        return redirect()->back()->with('warning', __('admin_users.warning_user_NOT_deleted'));
    }

    public function permission()
    {
        return redirect()->back()->with('warning',__( 'admin_users.warning_user_NOT_permission'));
    }
    public function store_permission(Request $request)
    {
        return redirect()->back()->with('warning', __('admin_users.warning_user_NOT_permission'));
    }

    public function resetPwd(Request $request,$id)
    {
        if($user = User::find($id)) {
            if ($request->ajax()) {
                $user->toArray();
                return response()->json([$user]);
            }
            return view('admin.users.edit', [
                'user' => $user,
            ]);
            return redirect()->back()->with('warning', __('admin_users.warning_user_NOT_resetPwd'));
        }
    }
    public function update_resetPwd(Request $request)
    {
        if($user = User::find($request->id)) {
            $this->validate($request, User::$rules_change_pwd);

            $user->password = bcrypt($request->new_password);
            $user->save();
            Log::info('Reset pwd from user id: '.$id.' from user: '.\Auth::user()->username);

            return redirect()->back()->with('success', __('admin_users.success_user_updated'));
        }
        Log::warning('Fault from reset pwd from user id: '.$id.' with error: '.__('admin_users.warning_user_NOTupdated'));
        return redirect()->back()->with('warning',__( 'admin_users.warning_user_NOTupdated'));
    }

}
