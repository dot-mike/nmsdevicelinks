<form action="{{ $action }}" method="POST" class="form-horizontal" role="form">
    @csrf
    @isset($method)
    @method($method)
    @endisset
    <div class="form-group">
        <label for="link_type" class="col-sm-4 control-label">Link Type</label>
        <div class="col-sm-4">
            <select name="link_type" id="link_type" class="form-control input-sm">
                <option value="url" {{ old('link_type', $link['link_type'] ?? 'url') == 'url' ? 'selected' : '' }}>Normal URL</option>
                <option value="snmp" {{ old('link_type', $link['link_type'] ?? '') == 'snmp' ? 'selected' : '' }}>SNMP Command</option>
            </select>
        </div>
    </div>
    <div class="form-group" id="snmp_commands" style="display: none;">
        <label for="snmp_command_id" class="col-sm-4 control-label">SNMP Command</label>
        <div class="col-sm-4">
            <select name="snmp_command_id" id="snmp_command_id" class="form-control input-sm">
                @foreach($snmpCommands as $command)
                <option value="{{ $command->id }}" {{ old('snmp_command_id', $link['snmp_command_id'] ?? '') == $command->id ? 'selected' : '' }}>{{ $command->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="url" class="col-sm-4 control-label">URL</label>
        <div class="col-sm-4">
            <input type="text" name="url" id="url" class="form-control input-sm" value="{{ old('url', $link['url'] ?? '') }}" required>
        </div>
    </div>
    <div class="form-group">
        <label for="title" class="col-sm-4 control-label">Title</label>
        <div class="col-sm-4">
            <input type="text" name="title" id="title" class="form-control input-sm" value="{{ old('title', $link['title'] ?? '') }}" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-4">
            <button type="submit" class="btn btn-default">{{ $buttonText }}</button>
        </div>
    </div>
</form>
<script>
    const linkTypeEl = document.getElementById('link_type');
    const snmpCommandsEl = document.getElementById('snmp_commands');
    const urlEl = document.getElementById('url');

    function toggleFields() {
        const isSnmp = linkTypeEl.value === 'snmp';
        snmpCommandsEl.style.display = isSnmp ? 'block' : 'none';
        urlEl.disabled = isSnmp;
    }

    linkTypeEl.addEventListener('change', toggleFields);
    toggleFields();
</script>