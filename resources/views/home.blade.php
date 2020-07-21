@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Carteira
                    @if(Auth::user()->default())
                        <a class="send btn" href="{{route("contacts")}}">Fazer transferência</a>
                    @endif
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <p>Saldo em carteira</p>
                            <h1><span class="text-success">R$</span> {{ Auth::user()->wallet() }} </h1>
                        </div>
                        <div class="col-md-6">
                            <p>Transações nos últimos 30 dias</p>

                            @if(count($transactions) > 0)
                            @foreach($transactions as $transaction)
                                <p>
                                    <a target="_blank" href="{{route('show.transaction', $transaction->id)}}" style="color: #000; text-decoration: none">
                                    <!-- Check if user send or received the transaction -->
                                    <small>{{ $transaction->received() ? $transaction->sender->name : $transaction->receiver->name }}
                                        <small>{{ $transaction->date() }}</small>
                                    </small>
                                    <br/>
                                    <span class="{{$transaction->received() ? "text-success" : "text-danger"}}">
                                        {{$transaction->received() ? "+" : "-"}} R$ {{ $transaction->value() }}
                                    </span>
                                    </a>
                                </p>
                            @endforeach
                            @else
                                <small>Nenhum resultado.</small>
                            @endif

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
