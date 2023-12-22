<x-mail::message>
# To {{ $user->name }} ({{ $user->club }}),

{{ $messageBefore }}

<x-mail::panel>
    <table>
        <tbody>
            <tr>
                <td>
                    {{ $status }}
                </td>
            </tr>
        </tbody>
    </table>
</x-mail::panel>

Please click [here](https://financial-reporting.kent-rugby.org/login?email={{ $user->email }}) to login.

{{ $messageAfter }}
</x-mail::message>
