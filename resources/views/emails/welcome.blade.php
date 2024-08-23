<x-mail::message>
    
    # Hola {{ $user->name }}

    <p>
        Gracias por crear una cuenta. Por favor verificala usando el siguiente botón:
    </p>

    <x-mail::button :url="$url" color="primary">
        Verificar Correo
    </x-mail::button>

    Sin mas por el momento nos despedimos.<br>
    {{ config('app.name') }}
</x-mail::message>
