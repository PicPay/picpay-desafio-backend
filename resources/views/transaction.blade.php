@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><b>Transação #{{$transaction->id}}</b></div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">

                            @if($transaction->received())
                                <p>Transação efetuada por: <b>{{$transaction->sender->name}} ({{$transaction->sender->document()}})</b></p>
                            @else
                                <p>Transação efetuada para: <b>{{$transaction->receiver->name}} ({{$transaction->receiver->document()}})</b></p>
                            @endif
                            <p>Valor: <b>R$ {{$transaction->value()}}</b></p>
                            <p>Data: <b>{{$transaction->date()}}</b></p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
