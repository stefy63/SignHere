<?php

namespace App\Http\Controllers;

use App\Models\Acl;
use App\Models\Device;
use Illuminate\Http\Request;
use League\Flysystem\Exception;
use Illuminate\Support\Facades\Log;

class AdminDeviceController extends Controller
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
        $devices = Acl::getMyDevices()->paginate(10);

        return view('admin.devices.index',[
            'devices' => $devices,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = Acl::getMyUsers()->where('active',true)->get();
        return view('admin.devices.create',[
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
        $this->validate($request, Device::$rules);

        $device = new Device();
        $device->fill($request->all());
        $device->user_id = \Auth::user()->id;
        $device->active = isset($request->active) ? 1 : 0;
        $device->save();
        $device->acls()->sync( Auth::user()->getMyRoot());
        Log::info('Store new device from user: '.\Auth::user()->username);

        return redirect()->back()->with('success', __('admin_devices.success_user_create'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,Device $device, $id)
    {
        if($device = Device::find($id)) {
            //$user = Acl::getMyUsers()->where('id',$device->user_id)->get();
            if($request->ajax()){
                $device->toArray();
                //$device = array_add($device,'user',$user->pluck('surname').' '.$user->pluck('name'));
                return response()->json([$device]);
            }
            return view('admin.devices.show',[
                'device' => $device,
                'user' => $user,
            ]);
        }

        return redirect()->back()->with('warning', __('admin_devices.warning_device_NOTfound'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function edit(Device $device,$id )
    {
        if($device = Device::find($id)) {
            return view('admin.devices.edit',[
                'device' => $device,
            ]);
        }

        return redirect()->back()->with('warning', __('admin_devices.warning_device_NOTfound'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Device $device, $id)
    {
        if($device = Device::find($id)) {
            if($request->ajax()){
                $device->active = $request->active;
                $device->save();
                return response()->json(['success' => __('admin_devices.success_device_updated')]);
            }
            //dd($request->all());
            $this->validate($request, Device::$rules);
            $device->fill($request->all());
            $device->user_id = \Auth::user()->id;
            $device->active = isset($request->active) ? $request->active : false;
            $device->save();
            Log::info('Update device id: '.$id.' from user: '.\Auth::user()->username);

            return redirect()->back()->with('success', __('admin_devices.success_device_updated'));
        }
        Log::warning('Fault from updating device id: '.$id.' with error: '.__('admin_devices.warning_device_NOTupdated'));
        return redirect()->back()->with('warning', __('admin_devices.warning_device_NOTupdated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Device  $device
     * @return \Illuminate\Http\Response
     */
    public function destroy(Device $device, $id)
    {
        if($device = Device::find($id)) {

            $device->acls()->detach();
            $device->delete();
            Log::info('Delete device id: '.$id.' from user: '.\Auth::user()->username);

            return redirect()->back()->with('success', __('admin_devices.success_device_destroy'));
        }
        Log::warning('Fault from deleting client id: '.$id.' with error: '.__('admin_devices.warning_device_NOT_deleted'));
        return redirect()->back()->with('warning', __('admin_devices.warning_device_NOT_deleted'));
    }
}
