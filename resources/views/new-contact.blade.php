@extends('layouts.app')
@push('script')
    <script src="{{asset("js/jquery.min.js")}}"></script>
    <script src="{{asset("js/jquery.mask.min.js")}}" defer></script>
    <script>
        /**
         * @return {string}
         */
        let CpfCnpjMaskBehavior = function (val) {
                return val.replace(/\D/g, '').length <= 11 ? '000.000.000-009' : '00.000.000/0000-00';
            },
            cpfCnpjpOptions = {
                onKeyPress: function(val, e, field, options) {
                    field.mask(CpfCnpjMaskBehavior.apply({}, arguments), options);
                }
            };
        $(function(){
            $("#document").mask(CpfCnpjMaskBehavior, cpfCnpjpOptions);
        });
    </script>
@endpush
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Adicionar Contato</div>
                <div class="card-body">
                    <form method="get" action="{{ route('new.contact') }}">
                        <div class="form-group row">
                            <label for="document" class="col-md-4 col-form-label text-md-right">CPF/CNPJ</label>

                            <div class="col-md-6">
                                <input id="document" type="text" class="form-control @error('document') is-invalid @enderror" name="document" value="{{ old('document') }}" required autocomplete="document">

                                @error('document')
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-success">
                                    Adicionar
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
