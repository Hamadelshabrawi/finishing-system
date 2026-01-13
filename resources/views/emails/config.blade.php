@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Email Configuration</h3>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('email.config.update') }}">
            @csrf
            
            <div class="form-group">
                <label>Mail Driver</label>
                <select name="MAIL_MAILER" class="form-control">
                    <option value="smtp" {{ $config['MAIL_MAILER'] == 'smtp' ? 'selected' : '' }}>SMTP</option>
                    <option value="sendmail" {{ $config['MAIL_MAILER'] == 'sendmail' ? 'selected' : '' }}>Sendmail</option>
                    <option value="mailgun" {{ $config['MAIL_MAILER'] == 'mailgun' ? 'selected' : '' }}>Mailgun</option>
                </select>
            </div>

            <div class="form-group">
                <label>SMTP Host</label>
                <input type="text" name="MAIL_HOST" value="{{ $config['MAIL_HOST'] }}" class="form-control">
            </div>

            <div class="form-group">
                <label>SMTP Port</label>
                <input type="number" name="MAIL_PORT" value="{{ $config['MAIL_PORT'] }}" class="form-control">
            </div>

            <div class="form-group">
                <label>SMTP Username</label>
                <input type="text" name="MAIL_USERNAME" value="{{ $config['MAIL_USERNAME'] }}" class="form-control">
            </div>

            <div class="form-group">
                <label>SMTP Password</label>
                <input type="password" name="MAIL_PASSWORD" value="{{ $config['MAIL_PASSWORD'] }}" class="form-control">
            </div>

            <div class="form-group">
                <label>Encryption</label>
                <select name="MAIL_ENCRYPTION" class="form-control">
                    <option value="">None</option>
                    <option value="tls" {{ $config['MAIL_ENCRYPTION'] == 'tls' ? 'selected' : '' }}>TLS</option>
                    <option value="ssl" {{ $config['MAIL_ENCRYPTION'] == 'ssl' ? 'selected' : '' }}>SSL</option>
                </select>
            </div>

            <div class="form-group">
                <label>From Address</label>
                <input type="email" name="MAIL_FROM_ADDRESS" value="{{ $config['MAIL_FROM_ADDRESS'] }}" class="form-control">
            </div>

            <div class="form-group">
                <label>From Name</label>
                <input type="text" name="MAIL_FROM_NAME" value="{{ $config['MAIL_FROM_NAME'] }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Configuration</button>
        </form>
    </div>
</div>
@endsection