@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Saldo: ') . float_to_money($balance)}}
                        @if($can_pay)
                            <a href="/transaction" onclick="startLoading();"
                               class="btn btn-success" style="float: right;color: #fff;">
                                Pagar
                            </a>
                        @endif
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <ul class="list-group list-group-flush">
                            @foreach($transactions as $transaction)
                                <li class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">
                                            @if($transaction->payer_id == $user->id)
                                                Você pagou a {{ $transaction->payee->name }}
                                                @php($color = '#e3342f')
                                            @else
                                                {{ $transaction->payer->name }} pagou a você
                                                @php($color = '#38c172')
                                            @endif
                                        </h5>
                                        <small>{{ $transaction->created_at->format('d/m/Y H:i') }}</small>
                                    </div>
                                    <p class="mb-1">
                                        {{ $transaction->message }}
                                    </p>
                                    <small style="color: {{ $color }}">{{ float_to_money($transaction->value) }}</small>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
