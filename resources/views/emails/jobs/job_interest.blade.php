@component('mail::message')
# Job Interest

{{ $interested->name }} is interested in the job

@component('mail::button', ['url' => route('users.show', $interested)])
View 
@endcomponent
  
Thanks,<br>
{{ config('app.name') }}
@endcomponent