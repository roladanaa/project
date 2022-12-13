@component('mail::message')
# We congratulate you

You have been added as a shipping point in the system, so you can now start your work

<br>
Login data
<br>
Email : {{$paypont->email}}
<br>
Password : {{$password}}
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
