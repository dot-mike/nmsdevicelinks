<form action="{{ $action }}" method="POST" class="form-horizontal" role="form">
    @csrf
    @if(isset($snmpCommand) && $snmpCommand->id)
    @method('PUT')
    @endif
    <!-- SNMP Command Description -->
    <div class="alert alert-info">
        <strong>SNMP Command Details:</strong>
        <p>
            Provide an OID (Object Identifier) to target a specific SNMP object. Select a Type for the value:
            types such as INTEGER (i), STRING (s), etc., or "=" to use MIB autodetection. Finally set the corresponding Value.
        </p>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-4 control-label">Name</label>
        <div class="col-sm-4">
            <input type="text" name="name" id="name" class="form-control input-sm" value="{{ old('name', $snmpCommand->name ?? '') }}" required>
        </div>
    </div>
    <div class="form-group">
        <label for="oid" class="col-sm-4 control-label">OID</label>
        <div class="col-sm-4">
            <input type="text" name="oid" id="oid" class="form-control input-sm" value="{{ old('oid', $snmpCommand->oid ?? '') }}" required>
        </div>
    </div>
    <div class="form-group">
        <label for="type" class="col-sm-4 control-label">Type</label>
        <div class="col-sm-4">
            <select name="type" id="type" class="form-control input-sm" required>
                <option value="">Select Type</option>
                <option value="=" {{ old('type', $snmpCommand->type ?? '') == '=' ? 'selected' : '' }}>= (Use MIB autodetection)</option>
                <option value="i" {{ old('type', $snmpCommand->type ?? '') == 'i' ? 'selected' : '' }}>INTEGER (i)</option>
                <option value="u" {{ old('type', $snmpCommand->type ?? '') == 'u' ? 'selected' : '' }}>UNSIGNED (u)</option>
                <option value="s" {{ old('type', $snmpCommand->type ?? '') == 's' ? 'selected' : '' }}>STRING (s)</option>
                <option value="x" {{ old('type', $snmpCommand->type ?? '') == 'x' ? 'selected' : '' }}>HEX STRING (x)</option>
                <option value="d" {{ old('type', $snmpCommand->type ?? '') == 'd' ? 'selected' : '' }}>DECIMAL STRING (d)</option>
                <option value="n" {{ old('type', $snmpCommand->type ?? '') == 'n' ? 'selected' : '' }}>NULLOBJ (n)</option>
                <option value="o" {{ old('type', $snmpCommand->type ?? '') == 'o' ? 'selected' : '' }}>OBJID (o)</option>
                <option value="t" {{ old('type', $snmpCommand->type ?? '') == 't' ? 'selected' : '' }}>TIMETICKS (t)</option>
                <option value="a" {{ old('type', $snmpCommand->type ?? '') == 'a' ? 'selected' : '' }}>IPADDRESS (a)</option>
                <option value="b" {{ old('type', $snmpCommand->type ?? '') == 'b' ? 'selected' : '' }}>BITS (b)</option>
            </select>
        </div>
    </div>
    <div class="form-group">
        <label for="value" class="col-sm-4 control-label">Value</label>
        <div class="col-sm-4">
            <input type="text" name="value" id="value" class="form-control input-sm" value="{{ old('value', $snmpCommand->value ?? '') }}" required>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-4 col-sm-offset-4">
            <button type="submit" class="btn btn-default">{{ $buttonText }}</button>
        </div>
    </div>
</form>