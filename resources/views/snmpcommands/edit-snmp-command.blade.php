@extends('nmsdevicelinks::includes.pluginadmin')

@section('title', 'Edit SNMP Command')

@section('content2')
<div class="row">
    @if ($errors->any())
    <div class="text-red-500 text-sm mb-4">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="col-md-12">
        <h3>Edit SNMP Command</h3>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Command</h3>
            </div>
            <div class="panel-body">
                @include('nmsdevicelinks::snmpcommands._form', [
                'action' => route('plugin.nmsdevicelinks.snmpcommands.update', $snmpCommand->id),
                'buttonText' => 'Update Command',
                'snmpCommand' => $snmpCommand
                ])
            </div>
        </div>
    </div>
</div>
@endsection