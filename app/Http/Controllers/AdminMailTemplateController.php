<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\MailTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use League\Flysystem\Exception;

class AdminMailTemplateController extends Controller
{
    protected $Fields;
    
    public function __construct() {
        $this->middleware('hasRole');
        $this->Fields = array('{nome}','{cognome}','{azienda}','{link}','{data}');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myBrands = Acl::getMyBrands()->pluck('id');
        $templates = MailTemplate::whereIn('brand_id', $myBrands)->paginate(10);
        return view('admin.mail_template.index',[
            'templates' => $templates,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Acl::getMyBrands()->get();
        $arFields = str_replace(['{', '}'], '', $this->Fields);
        return view('admin.mail_template.create',[
            'brands' => $brands,
            'arFields' => json_encode($arFields)
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
        $this->validate($request, MailTemplate::$rules);
        if(MailTemplate::where('brand_id', $request->brand_id)) {
            return redirect()->back()->withInput()->with('warning', __('admin_mail_template.existing_template_brand'));
        }
        $mailTemplate = new MailTemplate();
        $mailTemplate->fill($request->all());
        $mailTemplate->active = isset($request->active) ? 1 : 0;
        $mailTemplate->user_id = Auth::user()->id;
        $mailTemplate->save();
        Log::info('Store new mail template from user: '.\Auth::user()->username);
        
        return redirect()->back()->with('success', __('admin_mail_template.success_template_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function show(MailTemplate $mailTemplate)
    {
        return redirect()->back();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function edit(MailTemplate $mailTemplate, $id)
    {
        try {
            $myBrands = Acl::getMyBrands();
            $template = MailTemplate::whereIn('brand_id', $myBrands->pluck('id'))->findOrFail($id);
            $arFields = str_replace(['{', '}'], '', $this->Fields);
            return view('admin.mail_template.edit',[
                'brands'    => $myBrands->get(),
                'template'  => $template,
                'arFields'  => json_encode($arFields)
            ]);
            
        } catch (Exception $e) {
            return redirect()->back()->withInput()->with('warning', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MailTemplate $mailTemplate, $id)
    {
        DB::beginTransaction();
        try {
            $myBrands = Acl::getMyBrands()->pluck('id');
            $mailTemplate = MailTemplate::whereIn('brand_id', $myBrands)->findOrFail($id);
            if($request->ajax()){
                $mailTemplate->active = $request->active;
                $mailTemplate->save();
                DB::commit();
                Log::info('Update mail template id: '.$id.' from user: '.\Auth::user()->username);
                return response()->json(['success' => __('admin_mail_template.success_template_updated')]);
            }
            $this->validate($request, MailTemplate::$rules);
            $mailTemplate->fill($request->all());
            $mailTemplate->active = isset($request->active) ? 1 : 0;
            $mailTemplate->user_id = Auth::user()->id;
            $mailTemplate->save();
            DB::commit();
            Log::info('Update mail template id: '.$id.' from user: '.\Auth::user()->username);
            return redirect()->back()->with('success', __('admin_mail_template.success_template_updated'));
            
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('Fault from updating mail template id: '.$id.' with error: '.$ex->getMessage());
            return redirect()->back()->withInput()->with('warning', $ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MailTemplate  $mailTemplate
     * @return \Illuminate\Http\Response
     */
    public function destroy(MailTemplate $mailTemplate, $id)
    {
        DB::beginTransaction();
        try {
            $myBrands = Acl::getMyBrands()->pluck('id');
            $template = MailTemplate::whereIn('brand_id', $myBrands)->findOrFail($id);
            $template->delete();
            DB::commit();
            Log::info('Delete mail template id: '.$id.' from user: '.\Auth::user()->username);
            return redirect()->back()->with('success', __('admin_mail_template.success_template_destroy'));
        } catch (Exception $ex) {
            DB::rollBack();
            Log::error('Fault from deleting mail template id: '.$id.' with error: '.$ex->getMessage());
            return redirect()->back()->withInput()->with('warning', $ex->getMessage());
        }
    }
}
