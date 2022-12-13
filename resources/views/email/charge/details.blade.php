@component('mail::message')
# Balance has been charged

Recharged from a charging point (  {{$data['sender']->PayPoint->name_en}}  )

@component('mail::table')
|Pay Point       | Employee         | Amount  |
|:------------- |:-------------:| --------:|
| {{$data['sender']->PayPoint->name_en}}     | {{$data['sender']->name}}      | ${{$data['sender']->amount}}      |

@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent

