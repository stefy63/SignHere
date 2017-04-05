<?php

namespace App\Http\Controllers;

use App\Models\Doctype;
use Illuminate\Http\Request;
use App\Models\Acl;

class AdminDoctypeController extends Controller
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
        $doctypes = Doctype::paginate(10);

        return view('admin.doctypes.index',[
            'doctypes' => $doctypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.doctypes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, Doctype::$rules);

        $doctype = new Doctype();
        $doctype->fill($request->all());
        $doctype->user_id = \Auth::user()->id;
        $doctype->active = isset($request->active) ? 1 : 0;
        $doctype->save();

        return redirect()->back()->with('success', __('admin_doctypes.success_user_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctype  $doctype
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Doctype $doctype, $id)
    {
        if($doctype = Doctype::find($id)) {
            if($request->ajax()){
                $doctype->toArray();
                return response()->json([$doctype]);
            }
            return view('admin.doctype.show',[
                'doctype' => $doctype,
            ]);
        }

        return redirect()->back()->with('warning', 'admin_doctypes.warning_doctype_NOTfound');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Doctype  $doctype
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctype $doctype, $id)
    {
        if($doctype = Doctype::find($id)) {
            return view('admin.doctypes.edit',[
                'doctype' => $doctype,
            ]);
        }

        return redirect()->back()->with('warning', 'admin_doctypes.warning_doctype_NOTfound');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Doctype  $doctype
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctype $doctype, $id)
    {
        if($doctype = Doctype::find($id)) {
            if($request->ajax()){
                $doctype->active = $request->active;
                $doctype->save();
                return response()->json(['success' => __('admin_doctypes.success_doctype_updated')]);
            }
            $this->validate($request, Doctype::$rules);
            $doctype->fill($request->all());
            $doctype->user_id = \Auth::user()->id;
            $doctype->active = isset($request->active) ? $request->active : false;
            $doctype->save();

            return redirect()->back()->with('success', __('admin_doctypes.success_doctype_updated'));
        }
        return redirect()->back()->with('warning', 'admin_doctypes.warning_doctype_NOTupdated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctype  $doctype
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctype $doctype, $id)
    {
        if($doctype = Doctype::find($id)) {

            $doctype->delete();

            return redirect()->back()->with('success', __('admin_doctypes.success_doctype_destroy'));
        }
        return redirect()->back()->with('warning', 'admin_doctypes.warning_doctype_NOT_deleted');
    }
}
