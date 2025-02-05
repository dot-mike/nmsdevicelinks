@extends('nmsdevicelinks::includes.pluginadmin')

@section('title', 'SNMP Command Execution')

@section('content2')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            This window will close in <span id="countdown"></span> seconds.
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Command Execution Result</h3>
            </div>
            <div class="panel-body">
                <h4>Command Details:</h4>
                <dl class="dl-horizontal">
                    <dt>Device:</dt>
                    <dd>{{ $device->hostname }}</dd>
                    <dt>Command:</dt>
                    <dd>{{ $command->name }}</dd>
                    <dt>OID:</dt>
                    <dd>{{ $command->oid }}</dd>
                    <dt>Value:</dt>
                    <dd>{{ $command->value }}</dd>
                </dl>

                <h4>Execution Result:</h4>
                <div class="alert alert-{{ $status === 'success' ? 'success' : 'danger' }}">
                    <pre>{{ $result ?? 'No output' }}</pre>
                </div>
                <button onclick="window.close();" class="btn btn-primary">Back to Device</button>
            </div>
        </div>
    </div>
</div>

<script>
    let timeLeft = 35;
    const countdownElement = document.getElementById('countdown');

    const countdown = setInterval(function() {
        timeLeft--;
        countdownElement.textContent = timeLeft;

        if (timeLeft <= 0) {
            clearInterval(countdown);
            window.close();
        }
    }, 1000);
</script>
@endsection