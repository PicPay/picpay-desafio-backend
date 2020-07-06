@component('mail::message')
    Status da Transação {{ $message }}
    <br>
    Você recebeu um pagamento de {{ $user->name }} no valor de {{ $value }}
@endcomponent