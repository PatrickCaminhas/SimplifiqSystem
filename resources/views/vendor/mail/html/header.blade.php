@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Simplifiq System')
                <img src="https://camo.githubusercontent.com/629b90980b8129e219e5473152e1d0810984e1f667098bc36c28b6e6a384c4eb/68747470733a2f2f692e696d6775722e636f6d2f776877694e62702e706e67"
                    class="logo" alt="Laravel Logo">
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
