@component('mail::message')
# Greetings!

{{ $data['content'] }}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
