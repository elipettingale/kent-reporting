<x-mail::message>
# To {{ $user->name }} ({{ $user->club }}),

{{ $messageBefore }}

<x-mail::panel>
@foreach($breakdown as $season => $status)
<table>
    <tbody>
        <tr>
        <td>
            <strong>{{ $season }} Season:</strong>
        </td>
        <td>
            {{ $status }}
        </td>
        </tr>
    </tbody>
</table>
@endforeach
</x-mail::panel>

Please click [here](https://financial-reporting.kent-rugby.org/login?email={{ $user->email }}) to login.

{{ $messageAfter }}
</x-mail::message>
