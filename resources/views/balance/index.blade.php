@extends('layouts.app')

@section('content')
<div class="container">    
    <div class="row justify-content-center">
        <div class="col-md-5 text-center">

            @include('includes.alerts')

            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Saldo</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">R$ {{ number_format($amount, 2, ',', '.') }}</h1>
                    
                    <a href="{{ route('balance.deposit') }}" type="button" class="btn btn-lg btn-block btn-primary"><i class="fas fa-wallet"></i> Recarregar</a>
                    @if($amount > 0)
                        <a href="{{ route('balance.withdraw') }}" class="btn btn-lg btn-block btn-danger"><i class="fas fa-cart-arrow-down"></i> Sacar</a>

                        @if( strlen(auth()->user()->cpf_cnpj) <= 14 )
                            <a href="{{ route('balance.transfer') }}" class="btn btn-lg btn-block btn-info"><i class="fas fa-exchange-alt"></i> Transferir</a>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
