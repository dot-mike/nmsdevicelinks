@extends('nmsdevicelinks::includes.pluginadmin')

@section('title', 'SNMP Commands')

@section('content2')
<div class="row">
    <div class="col-md-12">
        <h3>SNMP Commands</h3>
        <p>
            SNMP Commands allow you to define custom SNMP operations that can be executed against network devices.
            The commands you define here can be used in device links to execute SNMP operations against devices.
        </p>
        <a href="{{ route('plugin.nmsdevicelinks.snmpcommands.create') }}" class="btn btn-primary">Add SNMP Command</a>
        <table class="table table-striped mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>OID</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($snmpCommands as $command)
                <tr>
                    <td>{{ $command->id }}</td>
                    <td>{{ $command->name }}</td>
                    <td>{{ $command->oid }}</td>
                    <td>{{ $command->type }}</td>
                    <td>{{ $command->value }}</td>
                    <td>
                        <a href="{{ route('plugin.nmsdevicelinks.snmpcommands.edit', $command->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('plugin.nmsdevicelinks.snmpcommands.destroy', $command->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection