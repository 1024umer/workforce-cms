<x-mail::message>
# Welcome {{$user->name}}

Your Login Details Are

<x-mail::table>
|        |          |
| ------------- |:-------------:|
| Email      | {{$user->email}}      |
| Password      | {{$password}} |
</x-mail::table>
<x-mail::button :url="$url">Login now</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
