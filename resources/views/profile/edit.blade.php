@extends('layouts.app')

@section('title', 'Meu Perfil')

@section('content')
<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-8">
            @include('includes.alerts')

            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h4 class="my-0 font-weight-normal"><i class='fa fa-user-edit'></i> Profile</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" value="{{ auth()->user()->name }}" name="name" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="name">CPF/CNPJ</label>
                            <input type="text" value="{{ auth()->user()->cpf_cnpj }}" name="cpf_cnpj" class="form-control cpf-cnpj">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" value="{{ auth()->user()->email }}" name="email" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-lg btn-block btn-success"><i class="fas fa-save"></i> Save</button>

                            <a href="{{ route('home') }}" class="btn btn-lg btn-block btn-secondary"><i class="fas fa-undo"></i> Return</a>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
