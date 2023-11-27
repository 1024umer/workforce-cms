<x-mail::message>
# Project Invitation

You have been invited by {{$user->name}}

<x-mail::button :url="$url">Accept Invitation</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
