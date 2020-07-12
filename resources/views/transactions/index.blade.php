@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        {{ __('Saldo: ') . float_to_money($balance)}}
                    </div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item active">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">
                                        Contatos
                                    </h5>
                                </div>
                            </li>
                            @foreach($users as $user)
                                <li class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">
                                            <label for="pay-{{ $user->id }}" style="cursor: pointer;">
                                                {{ $user->email }}
                                            </label>
                                        </h5>
                                        <input type="radio" id="pay-{{ $user->id }}" name="pay" value="{{ $user->id }}"
                                               style="cursor: pointer;">
                                    </div>
                                    <p class="mb-1">
                                        <label for="pay-{{ $user->id }}" style="cursor: pointer;">
                                            {{ $user->name }}
                                        </label>
                                    </p>
                                    <div class="row div-info-pay" id="div-info-pay-{{ $user->id }}"
                                         style="display: none;">
                                        <div class="col-md-10">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">R$</div>
                                                </div>
                                                <input type="text" class="form-control money to_clean"
                                                       placeholder="Informe o valor" maxlength="13">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-success"
                                                    style="float: right;color: #fff;">
                                                Pagar
                                            </button>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea class="form-control to_clean" placeholder="Digite uma mensagem"
                                                      rows="1"></textarea>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(".money").mask('#.##0,00', {
            reverse: true
        });

        $('input[type=radio][name=pay]').change(function () {
            $('.to_clean').val('');
            $('.div-info-pay').hide();

            id = this.value;

            $('#div-info-pay-' + id).show();
        });
    </script>
@endsection
