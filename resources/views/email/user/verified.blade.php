@component('mail::message')
# Verified Code 

Welcome, this code for your account, you can use it once and for an hour only .
<br>
Code : <b>{{$code}}</b>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
