<?php

namespace DotMike\NmsDeviceLinks\Models;

use Illuminate\Database\Eloquent\Model;

class SnmpCommand extends Model
{
    protected $table = 'devicelinks_snmpcommands';
    protected $fillable = ['name', 'oid', 'type', 'value'];
}
