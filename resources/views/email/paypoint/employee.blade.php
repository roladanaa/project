@component('mail::message')
# We congratulate you

You have been added at the point of sale and approved, congratulations.

<br>
Login data
<br>
Email : {{$employee->email}}
<br>
Password : {{$password}}
<br>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
