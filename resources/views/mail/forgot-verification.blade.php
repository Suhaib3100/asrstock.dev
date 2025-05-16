<div class="message">
    <p>Hi {{ $customer->first_name.' '.$customer->last_name }},</p>
    <p>We received a request to reset your password. Click the link below to reset it:</p>
    <p>
        <a href="{{ $resetUrl }}" style="color: #3490dc;">Reset Password</a>
    </p>
    <p>If you didn't request this, you can safely ignore this email.</p>
    <p>Thanks,<br>{{ getOption('app_name')  }}</p>
</div>
