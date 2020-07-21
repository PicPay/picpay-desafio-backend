@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Contatos
                    <a class="send btn" href="{{route("new.contact")}}" title="Novo Contato">+</a>
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
                    <ul class="list-group">
                        @foreach(Auth::user()->contacts()->get() as $contact)
                            <li class="list-group-item">
                                {{$contact->user->name}} <br/>
                                <small>{{$contact->user->document()}}</small>
                                <a class="send btn" href="{{route("send", ['contact' => $contact->user->id])}}">Enviar</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="card-footer text-right">
                    Saldo R$ <b>{{ Auth::user()->wallet() }}</b>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
