@extends('nmsdevicelinks::includes.pluginadmin')

@section('title', 'LibreNMS Device Links - Links')

@section('content2')

<div class="row">
    <div class="col-md-12">
        <h3>Manage Device Links</h3>
        <p>Device Link is either an URL or an SNMP command that can be executed on a device. You can add, edit or delete device links here.</p>
        <a href="{{ route('plugin.nmsdevicelinks.devicelinks.create') }}" class="btn btn-primary">Add Device Link</a>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>URL</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($processedLinks as $index => $link)
                <tr>
                    <td>{{ $index }}</td>
                    <td>{{ $link['title'] }}</td>
                    <td>
                        @if($link['is_snmp'])
                        <span class="badge badge-info">SNMP Command</span> <i>{{ $link['command_name'] }}</i>
                        @else
                        {{ $link['url'] }}
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('plugin.nmsdevicelinks.devicelinks.edit', $index) }}" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> Edit</a>
                        <form action="{{ route('plugin.nmsdevicelinks.devicelinks.destroy', $index) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection