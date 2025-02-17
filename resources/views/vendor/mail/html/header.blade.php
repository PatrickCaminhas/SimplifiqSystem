@props(['url'])
<tr>
    <td class="header">
        <a href="{{ $url }}" style="display: inline-block;">
            @if (trim($slot) === 'Simplifiq System')
                <img src="https://camo.githubusercontent.com/b88892e22d5e9fbb84f1b3eb6d1dd7a8a1129272f96bd49adf2b5c021be6c5f4/68747470733a2f2f692e696d6775722e636f6d2f3130506c4f46322e706e67"
                    class="logo" alt="Laravel Logo">
                    <div class="logo-text"><center>
                        <h1>Simplifiq System</h1>
                    </center></div>
            @else
                {{ $slot }}
            @endif
        </a>
    </td>
</tr>
