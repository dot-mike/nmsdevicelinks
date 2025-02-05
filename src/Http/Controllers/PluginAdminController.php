<?php

namespace DotMike\NmsDeviceLinks\Http\Controllers;

use \DotMike\NmsDeviceLinks\Traits\SNMPSetTrait;

use App\Models\Device;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use Gate;
use Validator;

class PluginAdminController extends Controller
{
    use SNMPSetTrait;

    // show plugin main page
    // GET /plugins/nmsdevicelinks
    public function index()
    {
        Gate::authorize('admin');

        return view('nmsdevicelinks::main');
    }
}
