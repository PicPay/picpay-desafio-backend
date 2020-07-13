@extends('layouts.app')

@section('content')
<div class="container">    
    <div class="row justify-content-center">
        <div class="col-md-12">

            @include('includes.alerts')

            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal">Transações</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-12">
                            <form action="{{ route('transaction.search') }}" method="post" class="form form-inline">
                                @csrf

                                <input type="text"  name="id" class="form-control" placeholder="ID">
                                <input type="date"  name="date" class="form-control">
                                <select name="type" id="type" class="form-control">
                                    <option value="">Selecione</option>
                                    @foreach ($types as $key => $type)
                                        <option value="{{ $key }}">{{ $type }}</option>
                                    @endforeach
                                </select>

                                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Pesquisar</button>
                            </form>
                        </div>
                    </div>

                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                                <th>Data</th>
                                <th>Remetente</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->id }}</td>
                                <td>{{ number_format($transaction->amount, 2, ',', '.') }}</td>
                                <td>{{ $transaction->type($transaction->type) }}</td>
                                <td>{{ $transaction->date }}</td>
                                <td>
                                    @if ($transaction->user_id_transaction)
                                        {{ $transaction->userSender->name }}
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5">Nenhum registro encontrado.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @if(isset($dataForm))
                        {{ $transactions->appends($dataForm)->links() }}
                    @else
                        {{ $transactions->links() }}
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
