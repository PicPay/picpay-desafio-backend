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
                                                <input type="text" id="user-pay-value-{{ $user->id }}"
                                                       class="form-control money to_clean"
                                                       placeholder="Informe o valor" maxlength="13">
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-success"
                                                    onclick="saveTransaction('{{ $user->id }}')"
                                                    style="float: right;color: #fff;">
                                                Pagar
                                            </button>
                                        </div>
                                        <div class="col-md-12">
                                            <textarea id="user-pay-message-{{ $user->id }}" rows="1"
                                                      class="form-control to_clean" placeholder="Digite uma mensagem"
                                            ></textarea>
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

        function saveTransaction(payee_id) {
            startLoading();
            value = $('#user-pay-value-' + payee_id).val();

            if (!value) {
                sendMessage('info', 'Informe o valor para transferência');

                return false;
            }

            $.ajax({
                type: 'POST',
                url: '/transaction/store',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'payee_id': payee_id,
                    'message': $('#user-pay-message-' + payee_id).val(),
                    'value': value,
                }
            }).done(function (res) {
                sendMessage('success', res.message);

                setTimeout(function () {
                    startLoading();
                    window.location.href = "/home";
                }, 2000);
            }).fail(function (res) {
                message = res.message;

                if (!message) {
                    message = res.responseJSON.message;
                }
                sendMessage('warning', message);
            });
        }

        function sendMessage(icon, title) {
            stopLoading();

            Swal.fire({
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 2000
            });
        }
    </script>
@endsection
