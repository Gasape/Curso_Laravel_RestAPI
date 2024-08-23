<x-mail::message>

    # Hola {{ $user->name }}

    <p>
        Has cambiado tu correo electrónio. Por favor verifica la nueva dirreción usando el siguiente botón:
    </p>

    <x-mail::button :url="$url" color="primary">
        Verificar Correo
    </x-mail::button>

    Sin mas por el momento nos despedimos.<br>
    {{ config('app.name') }}
</x-mail::message>
