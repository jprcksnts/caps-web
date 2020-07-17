@component('mail::message')
# Greetings!

{{ $data['message'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
