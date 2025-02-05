@extends('nmsdevicelinks::includes.pluginadmin')

@section('title', 'Create SNMP Command')

@section('content2')
<div class="row">
    <div class="col-md-12">
        <h3>Create SNMP Command</h3>
        {{-- Display validation errors --}}
        @if ($errors->any())
        <div class="text-red-500 text-sm mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">New Command</h3>
            </div>
            <div class="panel-body">
                @include('nmsdevicelinks::snmpcommands._form', [
                'action' => route('plugin.nmsdevicelinks.snmpcommands.store'),
                'buttonText' => 'Create Command',
                'snmpCommand' => null
                ])
            </div>
        </div>
    </div>
</div>
@endsection