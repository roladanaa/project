@component('mail::message')
# Shipping process documentation

We have received a notification of a new shipment and this is the process authentication code
<br>
# Code : {{$code}}


Thanks,<br>
{{ config('app.name') }}
@endcomponent
