@extends('nmsdevicelinks::includes.pluginadmin')

@section('title', 'Edit Device Link')

@section('content2')
<div class="row">
    <div class="col-md-12">
        <h3>Edit Device Link</h3>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Edit Link</h3>
            </div>
            <div class="panel-body">
                @include('nmsdevicelinks::devicelinks._form', [
                'action' => route('plugin.nmsdevicelinks.devicelinks.update', $index),
                'method' => 'PUT',
                'buttonText' => 'Update Link',
                'link' => $link,
                'snmpCommands'=> $snmpCommands
                ])
            </div>
        </div>
    </div>
</div>
@endsection