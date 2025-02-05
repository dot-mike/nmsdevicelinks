<ul class="nav nav-tabs">
    <li role="presentation" class="{{ Request::routeIs('plugin.nmsdevicelinks.index') ? 'active' : '' }}">
        <a href="{{ route('plugin.nmsdevicelinks.index') }}">Plugin Index</a>
    </li>
    <li role="presentation" class="{{ Request::routeIs('plugin.nmsdevicelinks.devicelinks.index') ? 'active' : '' }}">
        <a href="{{ route('plugin.nmsdevicelinks.devicelinks.index') }}">Device Links</a>
    </li>
    <li role="presentation" class="{{ Request::routeIs('plugin.nmsdevicelinks.snmpcommands.index') ? 'active' : '' }}">
        <a href="{{ route('plugin.nmsdevicelinks.snmpcommands.index') }}">SNMP Command Links</a>
    </li>
</ul>