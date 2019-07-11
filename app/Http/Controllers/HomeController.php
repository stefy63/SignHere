<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Helpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('home');
        return redirect('sign');
    }

    public function resetPwd(Request $request,$id) {
        if($user = User::find($id)) {
            if ($request->ajax()) {
                $user->toArray();
                return response()->json([$user]);
            }
            return view('frontend.user.reset_password', [
                'user' => $user,
            ]);
            return redirect()->back()->with('warning', __('admin_users.warning_user_NOT_resetPwd'));
        }
    }

    public function store_resetPwd(Request $request) {
        if($user = User::find($request->user_id)) {
            $this->validate($request, User::$rules_change_pwd);

            $user->password = bcrypt($request->new_password);
            $user->save();

            return redirect('sign')->with('success', __('admin_users.success_user_updated'));
        }
            return redirect()->back()->with('warning',__( 'admin_users.warning_user_NOTupdated'));
    }
}
