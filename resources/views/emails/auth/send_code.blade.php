@component('mail::message')
    # Confirmation Code

    Hello {{ $name }},
    <br>
    This is your confirmation code: {{ $code }}

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
