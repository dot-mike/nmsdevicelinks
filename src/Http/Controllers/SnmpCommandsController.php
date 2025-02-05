<?php

namespace DotMike\NmsDeviceLinks\Http\Controllers;

use DotMike\NmsDeviceLinks\Models\SnmpCommand;
use DotMike\NmsDeviceLinks\Traits\SNMPSetTrait;
use App\Models\Device;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\ToastInterface;

use Illuminate\Http\Request;

class SnmpCommandsController extends Controller
{
    use SNMPSetTrait;

    public function index()
    {
        $snmpCommands = SnmpCommand::all();
        return view('nmsdevicelinks::snmpcommands.snmpcommands', compact('snmpCommands'));
    }

    public function create()
    {
        $snmpCommand = new SnmpCommand();
        return view('nmsdevicelinks::snmpcommands.create-snmp-command');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string',
            'oid'   => 'required|string',
            'type'  => 'required|string',
            'value' => 'required|string'
        ]);

        SnmpCommand::create($request->only('name', 'oid', 'type', 'value'));

        return redirect()->route('plugin.nmsdevicelinks.snmpcommands.index');
    }

    public function edit(int $id)
    {
        $snmpCommand = SnmpCommand::findOrFail($id);
        return view('nmsdevicelinks::snmpcommands.edit-snmp-command', compact('snmpCommand'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name'  => 'required|string',
            'oid'   => 'required|string',
            'type'  => 'required|string',
            'value' => 'required|string'
        ]);

        $snmpCommand = SnmpCommand::findOrFail($id);
        $snmpCommand->update($request->only('name', 'oid', 'type', 'value'));

        return redirect()->route('plugin.nmsdevicelinks.snmpcommands.index');
    }

    public function destroy(int $id)
    {
        $snmpCommand = SnmpCommand::findOrFail($id);
        $snmpCommand->delete();

        return redirect()->route('plugin.nmsdevicelinks.snmpcommands.index');
    }

    public function execute(Request $request, Device $device, SnmpCommand $command, ToastInterface $toast)
    {
        try {
            $processResult = $this->snmpSet(
                $device,
                $command->oid,
                $command->type,
                $command->value
            );

            if ($processResult->successful()) {
                return view('nmsdevicelinks::snmpcommands.execute', [
                    'device' => $device,
                    'command' => $command,
                    'result' => $processResult->output(),
                    'status' => 'success'
                ]);
            } elseif ($processResult->failed()) {
                return view('nmsdevicelinks::snmpcommands.execute', [
                    'device' => $device,
                    'command' => $command,
                    'result' => $processResult->errorOutput(),
                    'status' => 'error'
                ]);
            }
        } catch (\Exception $e) {
            return view('nmsdevicelinks::snmpcommands.execute', [
                'device' => $device,
                'command' => $command,
                'result' => $e->getMessage(),
                'status' => 'error'
            ]);
        }
    }
}
