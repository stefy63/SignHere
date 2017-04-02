<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Models\Acl;
use Illuminate\Support\Facades\Auth;

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
        $users = Acl::getMyBrands()->get();
        return view('admin.users.create',[
            'users' => $users
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
        $this->validate($request, User::$rules);

        $user = new User();
        $user->fill($request->all());
        $user->active = isset($request->active) ? 1 : 0;
        $user->api_token = str_random(60);
        $user->password = bcrypt($request->password);
        $user->save();
        $user->acls()->attach(  '1');

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
        //
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
            return view('admin.users.edit',[
                'user' => $user,
            ]);
        }

        return redirect()->back()->with('warning', 'admin_users.warning_user_NOTfound');
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
                $user->active = $request->active;
                $user->save();
                return response()->json(['success' => __('admin_users.success_user_updated')]);
            }
            //dd($request->all());
            $this->validate($request, User::$rules);
            $user->fill($request->all());
            $user->active = isset($request->active) ? 1 : 0;
            if(bcrypt($user->password) != bcrypt($request->password))
                    $user->password = bcrypt($request->password);
            $user->save();

            return redirect()->back()->with('success', __('admin_users.success_user_updated'));
        }
        return redirect()->back()->with('warning', 'admin_users.warning_user_NOTupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($user = User::find($id)) {

            $user->acls()->detach();
            $user->modules()->detach();
            $user->devices()->detach();
            $user->delete();

            return redirect()->back()->with('success', __('admin_users.success_user_destroy'));
        }
        return redirect()->back()->with('warning', 'admin_users.warning_user_NOT_deleted');
    }

    public function permission()
    {
        //
        return redirect()->back()->with('warning', 'admin_users.warning_user_NOT_permission');
    }
    public function store_permission(Request $request)
    {
        return redirect()->back()->with('warning', 'admin_users.warning_user_NOT_permission');
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
            return redirect()->back()->with('warning', 'admin_users.warning_user_NOT_resetPwd');
        }
    }
    public function update_resetPwd(Request $request)
    {
        if($user = User::find($request->id)) {
            //dd($request->all());
            $this->validate($request, User::$rules_change_pwd);

            if(bcrypt($user->password) != bcrypt($request->new_password))
                    $user->password = bcrypt($request->new_password);
            $user->save();

            return redirect()->back()->with('success', __('admin_users.success_user_updated'));
        }
        return redirect()->back()->with('warning', 'admin_users.warning_user_NOTupdated');
    }

}
