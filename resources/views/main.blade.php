@extends('nmsdevicelinks::includes.pluginadmin')

@section('title', 'LibreNMS Device Links - Admin')

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
        <h3>About Device Links Plugin</h3>
        <p>This plugin allows you to create and manage external device links directly from the LibreNMS web UI. Instead of having to execute CLI commands to add custom links, this plugin makes it possible to manage device links directly from the LibreNMS web UI.</p>
        <p><strong>Version:</strong> {{ $nmsdevicelinks_version }}</p>
    </div>
</div>

@endsection