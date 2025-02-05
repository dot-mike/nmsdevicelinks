<?php

namespace DotMike\NmsDeviceLinks\Traits;

use App\Models\Device;

use LibreNMS\Config;

use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Process;
use Illuminate\Contracts\Process\ProcessResult;

trait SNMPSetTrait
{
    /**
     * Perform an SNMP set operation.
     *
     * @param Device $device The device to perform the set operation on.
     * @param string $oid The OID to set.
     * @param string $type The type of the value to set
     * @param mixed $value The value to set
     * @param array $options Additional options
     */
    public function snmpSet($device, $oid, $type, $value, $options = null): ProcessResult
    {
        $cmd = ["snmpset"];

        $cmd = [];

        $cmd[] = "snmpset";

        $version = $device->snmpver; // v1 or v2c or v3

        if ($version == 'v1' || $version == 'v2c') {
            $cmd[] = "-v" . substr($version, 1);
            $cmd[] = "-c";
            $cmd[] = $device->community;
        } elseif ($version == 'v3') {
            $cmd[] = "-v3";
            $cmd[] = "-l";
            $cmd[] = $device->authlevel ?? 'authPriv';  // authNoPriv, authPriv, or noAuthNoPriv
            $cmd[] = "-u";
            $cmd[] = $device->authname;

            // Authentication parameters
            if ($device->authlevel != 'noAuthNoPriv') {
                $cmd[] = "-a";
                $cmd[] = $device->authalgo ?? 'SHA';    // MD5 or SHA
                $cmd[] = "-A";
                $cmd[] = $device->authpass;
            }

            // Privacy/encryption parameters
            if ($device->authlevel == 'authPriv') {
                $cmd[] = "-x";
                $cmd[] = $device->cryptoalgo ?? 'AES';  // AES or DES
                $cmd[] = "-X";
                $cmd[] = $device->cryptopass;
            }
        } else {
            return "Invalid SNMP version";
        }

        $mib_path = Config::get('mib_dir');
        $cmd[] = "-M";
        $cmd[] = $mib_path;

        $transport = $device->transport ?? 'udp';
        $port = $device->port ?? '161';
        $target = sprintf('%s:%s:%s', $transport, $device->hostname, $port);
        $cmd[] = $target;

        // Add OID, type and value
        $cmd[] = $oid;
        $cmd[] = $type;
        $cmd[] = $value;

        $result = Process::run($cmd);

        return $result;
    }
}
