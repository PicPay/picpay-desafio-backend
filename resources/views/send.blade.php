@extends('layouts.app')

@push('script')
    <script src="{{asset("js/jquery.min.js")}}"></script>
    <script src="{{asset("js/mask.money.min.js")}}" defer></script>
    <script>
        $(function(){
            $("#value").maskMoney({ decimal: ',', thousands: '', precision: 2 })
        });
     </script>
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Saldo R$ <b>{{ Auth::user()->wallet() }}</b></div>
                <div class="card-body">
                    @error('transaction')
                    <div class="alert alert-danger" role="alert">
                        {{ $message }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @enderror

                    <form method="POST" action="{{ route('call', $contact->id) }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">Enviar para</label>

                            <div class="col-md-6">

                                <span class="form-control border-0">
                                    <strong>{{ $contact->name }}</strong> -
                                    <small>{{ $contact->document() }}</small>
                                </span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="value" class="col-md-4 col-form-label text-md-right">Valor</label>

                            <div class="col-md-6">
                                <input id="value" type="text" class="form-control" name="value" value="{{ old('value') }}" required autocomplete="value">
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    Enviar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
