<x-mail::message>
Reset password Link

Here is your Reset password link for reseting your password. do not share this link with anyone.

<x-mail::button :url="$url">
Reset password
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
