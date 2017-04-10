<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminModuleController extends Controller
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
        $modules = Module::paginate(10);

        return view('admin.modules.index',[
            'modules' => $modules,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.modules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reqAll = $request->all();
        if (empty($request->short_name)) {
            $reqAll['short_name'] = strtolower(str_replace(' ','_',$request->name));
            $request->replace($reqAll);
        }

        $this->validate($request, Module::rules());

        $module = new Module();
        $module->fill($request->all());
        $module->user_id = \Auth::user()->id;
        $module->active = isset($request->active) ? 1 : 0;
        $module->isadmin = isset($request->isadmin) ? 1 : 0;
        $module->save();
        $module->profiles()->attach([1 => ['permission' => 'ALL']]);

        return redirect()->back()->with('success', __('admin_modules.success_module_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Module $module, $id)
    {
        if($module = Module::find($id)) {
            if($request->ajax()){
                $module->toArray();
                return response()->json([$module]);
            }
            return view('admin.module.show',[
                'module' => $module,
            ]);
        }

        return redirect()->back()->with('warning', 'admin_modules.warning_module_NOTfound');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function edit(Module $module, $id)
    {
        if($module = Module::find($id)) {
            return view('admin.modules.edit',[
                'module' => $module,
            ]);
        }

        return redirect()->back()->with('warning', 'admin_modules.warning_module_NOTfound');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Module $module, $id)
    {

        if($module = Module::find($id)) {
            if($request->ajax()){
                $module->active = $request->active;
                $module->save();
                return response()->json(['success' => __('admin_modules.success_module_updated')]);
            }

            $reqAll = $request->all();
            if (empty($request->short_name)) {
                $reqAll['short_name'] = strtolower(str_replace(' ','_',$request->name));
                $request->replace($reqAll);
            }
            //dd($request->all());
            $this->validate($request, Module::rules($id));
            $module->fill($request->all());
            $module->active = isset($request->active) ? $request->active : false;
            $module->isadmin = isset($request->isadmin) ? 1 : 0;
            $module->save();

            return redirect()->back()->with('success', __('admin_modules.success_module_updated'));
        }
        return redirect()->back()->with('warning', 'admin_modules.warning_module_NOTupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Module  $module
     * @return \Illuminate\Http\Response
     */
    public function destroy(Module $module, $id)
    {
        if($module = Module::find($id)) {

            $module->profiles()->detach();
            $module->delete();

            return redirect()->back()->with('success', __('admin_modules.success_module_destroy'));
        }
        return redirect()->back()->with('warning', 'admin_modules.warning_module_NOT_deleted');
    }
}
