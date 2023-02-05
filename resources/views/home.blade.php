@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }} <br>
            
                    {{ 'id = '.auth()->user()->id}} <br>
                    {{ 'name = '.auth()->user()->name }} <br>
                    {{ 'email = '.auth()->user()->email }} <br>
                    <br>
                    @if (!empty(auth()->user()->oauth()->first()->avatar))
                        <img width="50" src="{{ auth()->user()->oauth()->first()->avatar }}"><br>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
