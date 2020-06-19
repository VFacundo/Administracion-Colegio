@extends('layouts.app')

@section('content')

<div class="container-fluid" style="margin-top:10em">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-sm-6 align-self-center">
            <div class="card card-block">
                <div class="card-header">Verificar EMail</div>

                <div class="card-body text-center">
                    <h1>Gracias por Verificar tu Email</h1>
                    <img src="{{ asset('/img/ok.png') }}" class="rounded mx-auto d-block mt-5 mb-5" alt="Verificado Correctamente" style="max-width:25%">
                    <a class="btn btn-primary mb-2" href="{{route('login')}}">Login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
