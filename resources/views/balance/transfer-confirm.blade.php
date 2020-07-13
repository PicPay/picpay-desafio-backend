@extends('layouts.app')

@section('content')
<div class="container">

    
    <div class="row justify-content-center">
        <div class="col-md-5 text-center">
            
            @include('includes.alerts')

            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Confirmar Transferência Saldo</h4>
                </div>
                <div class="card-body">
                    <p><strong>Recebedor: </strong> {{ $sender->name }}</p>
                    <p><strong>Seu Saldo Atual: </strong> {{ number_format($balance->amount, 2, ',', '.') }}</p>

                    <form action="{{ route('transfer.store') }}" method="post">
                        @csrf
                        
                        <input type="hidden" name="sender_id" value="{{ $sender->id }}">

                        <div class="form-group">
                            <input type="text" name="value" placeholder="Valor: R$" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-block btn-success">Transferir</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
