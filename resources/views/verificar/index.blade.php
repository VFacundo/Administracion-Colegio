@extends('layouts.app')

@section('content')

<script type="application/javascript" src="{{ asset('js/ajaxData.js') }}"></script>

<div class="container-fluid w-100 fixed-top" style="background-color:white">
  <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm w-100">
      <div class="container-fluid w-100">
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <!-- Left Side Of Navbar -->
              <ul class="navbar-nav mr-auto"></ul>
              <!-- Right Side Of Navbar -->
              <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                        {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                         document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </li>
              </ul>
          </div>
      </div>
  </nav>
</div>


<div class="container-fluid" style="margin-top:10em">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-sm-6 align-self-center">
            <div class="card card-block">
                <div class="card-header">Verificar EMail</div>
                <p> Por favor introduce una dirección de Mail valida para que te enviemos el link de Verificación.
                <div class="card-body text-center">
                    <form class="form-inline justify-content-center" onSubmit="enviarMail();return false">
                        @csrf
                        <div class="form-group mb-2">
                          <label for="email" class="col-md-4 col-form-label text-md-right">Email:</label>
                        </div>
                        <div class="form-group mx-sm-3 mb-2">
                          <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">

                          @error('email')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror

                        </div>
                        <button id="btnSub" type="submit" class="btn btn-primary mb-2">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
