@extends('layouts.app')

@section('content')
<div class="container">

    
    <div class="row justify-content-center">
        <div class="col-md-5 text-center">
            
            @include('includes.alerts')

            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Transferir Saldo</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('confirm.transfer') }}" method="post">
                        @csrf

                        <div class="form-group">
                            <input type="text" name="sender" placeholder="Nome, E-mail, CPF ou CNPJ" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-block btn-success">Próxima Etapa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
