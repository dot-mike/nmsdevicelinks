<?php

namespace DotMike\NmsDeviceLinks\Http\Controllers;

use DotMike\NmsDeviceLinks\Models\SnmpCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Http\Interfaces\ToastInterface;


class DeviceLinksController extends Controller
{
    public function index()
    {
        if (!Schema::hasTable('config')) {
            abort(404, 'Config table not found');
        }
        $value = DB::table('config')
            ->where('config_name', 'html.device.links')
            ->value('config_value');
        $links = $value ? json_decode($value, true) : [];
        $processedLinks = $this->processLinksForDisplay($links);
        return view('nmsdevicelinks::devicelinks.device-links', compact('processedLinks'));
    }

    protected function validateLinkRequest(Request $request)
    {
        $request->validate([
            'link_type'       => 'required|in:url,snmp',
            'snmp_command_id' => 'required_if:link_type,snmp',
            'title'           => 'required|string',
            'url'             => $request->input('link_type') === 'url' ? 'required|string' : 'nullable',
        ]);
    }

    public function store(Request $request, ToastInterface $toast)
    {
        $this->validateLinkRequest($request);
        if (!Schema::hasTable('config')) {
            abort(404, 'Config table not found');
        }
        $value = DB::table('config')
            ->where('config_name', 'html.device.links')
            ->value('config_value');
        $links = $value ? json_decode($value, true) : [];
        if ($request->input('link_type') === 'snmp') {
            $snmpCommand = SnmpCommand::findOrFail($request->input('snmp_command_id'));
            $calculatedUrl = $this->calculateSnmpLink($snmpCommand);
            $newLink = [
                'url'             => $calculatedUrl,
                'title'           => $request->input('title'),
                'link_type'       => 'snmp',
                'snmp_command_id' => $snmpCommand->id,
            ];
        } else {
            $newLink = [
                'url'       => $request->input('url'),
                'title'     => $request->input('title'),
                'link_type' => 'url',
            ];
        }
        if (!in_array($newLink, $links, true)) {
            $links[] = $newLink;
            DB::table('config')->updateOrInsert(
                ['config_name' => 'html.device.links'],
                ['config_value' => json_encode($links)]
            );
        }

        $toast->success('Device link added successfully');
        return redirect()->back();
    }

    public function destroy(Request $request, int $index)
    {
        if (!Schema::hasTable('config')) {
            abort(404, 'Config table not found');
        }
        $value = DB::table('config')
            ->where('config_name', 'html.device.links')
            ->value('config_value');
        $links = $value ? json_decode($value, true) : [];
        if (isset($links[$index])) {
            unset($links[$index]);
            $links = array_values($links);
            if (empty($links)) {
                DB::table('config')->where('config_name', 'html.device.links')->delete();
            } else {
                DB::table('config')->updateOrInsert(
                    ['config_name' => 'html.device.links'],
                    ['config_value' => json_encode($links)]
                );
            }
        }
        $toast->success('Device link deleted successfully');
        return redirect()->route('plugin.nmsdevicelinks.devicelinks.index');
    }

    public function edit(int $index)
    {
        if (!Schema::hasTable('config')) {
            abort(404, 'Config table not found');
        }
        $value = DB::table('config')
            ->where('config_name', 'html.device.links')
            ->value('config_value');
        $links = $value ? json_decode($value, true) : [];
        if (!isset($links[$index])) {
            abort(404, 'Link not found');
        }
        $link = $links[$index];

        $snmpCommands = SnmpCommand::all();

        return view('nmsdevicelinks::devicelinks.edit-device-link', compact('link', 'index', 'snmpCommands'));
    }

    // Add the update method to process edit submissions.
    public function update(Request $request, int $index, ToastInterface $toast)
    {
        $this->validateLinkRequest($request);

        if (!Schema::hasTable('config')) {
            abort(404, 'Config table not found');
        }
        $value = DB::table('config')
            ->where('config_name', 'html.device.links')
            ->value('config_value');
        $links = $value ? json_decode($value, true) : [];

        if (!isset($links[$index])) {
            abort(404, 'Link not found');
        }

        if ($request->input('link_type') === 'snmp') {
            $snmpCommand = SnmpCommand::findOrFail($request->input('snmp_command_id'));
            $calculatedUrl = $this->calculateSnmpLink($snmpCommand);
            $links[$index] = [
                'url'             => $calculatedUrl,
                'title'           => $request->input('title'),
                'link_type'       => 'snmp',
                'snmp_command_id' => $snmpCommand->id,
            ];
        } else {
            $links[$index] = [
                'url'       => $request->input('url'),
                'title'     => $request->input('title'),
                'link_type' => 'url',
            ];
        }

        DB::table('config')->updateOrInsert(
            ['config_name' => 'html.device.links'],
            ['config_value' => json_encode($links)]
        );

        $toast->success('Device link updated successfully');
        return redirect()->route('plugin.nmsdevicelinks.devicelinks.index');
    }

    public function create()
    {
        $link = ['url' => '', 'title' => ''];
        $snmpCommands = SnmpCommand::all();
        return view('nmsdevicelinks::devicelinks.create-device-link', compact('link', 'snmpCommands'));
    }

    protected function calculateSnmpLink(SnmpCommand $snmpCommand)
    {
        // Get the URL pattern without resolving parameters
        $baseUrl = app('url')->route('plugin.nmsdevicelinks.snmpcommands.execute', [
            'device' => '_DEVICE_ID_',
            'command' => $snmpCommand->id
        ], false);

        // Replace the placeholder with Blade syntax
        return str_replace('_DEVICE_ID_', '{{ $device->device_id }}', $baseUrl);
    }

    public function getCommandNameFromUrl($url)
    {
        try {
            $basePath = '/plugins/nmsdevicelinks/snmpcommands/execute/';
            if (strpos($url, $basePath) !== false) {
                // Extract the command ID from the end of the URL
                $parts = explode('/', trim($url, '/'));
                $commandId = (int) end($parts);
                if ($commandId > 0) {
                    $command = SnmpCommand::find($commandId);
                    return $command ? $command->name : null;
                }
            }
            return null;
        } catch (\Exception $e) {
            return null;
        }
    }

    private function processLinksForDisplay($links)
    {
        return array_map(function ($link) {
            $commandName = $this->getCommandNameFromUrl($link['url']);
            return array_merge($link, [
                'is_snmp' => !is_null($commandName),
                'command_name' => $commandName
            ]);
        }, $links);
    }
}
