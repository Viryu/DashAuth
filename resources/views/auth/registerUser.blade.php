@extends('layouts.dashboardHeader')

@section('content')
    <div class="page-header"> <h1>{{ __('Register User') }}</h1></div>

    <div class="panel panel-default col-md-6">
        <div class=" panel-body">
            <form method="POST" action="{{route('register')}}" aria-label="{{ __('Register') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="">{{ __('Name')}}</label>

                    <div class="">
                        <input id="name" type="text" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="name" value="{{ old('name')  }}" required>

                        @if ($errors->has('name'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="email" class="">{{ __('E-Mail Address') }}</label>

                    <div class="">
                        <input id="email" type="email" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="">{{ __('Password') }}</label>

                    <div class="">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>

                    <div class="">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="mid" class="">{{ __('mid') }}</label>

                    <div class="">
                        <input id="mid" type="text" class="form-control{{ $errors->has('mid') ? ' is-invalid' : '' }}" name="mid" required>

                        @if ($errors->has('mid'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('mid') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>
                <div class="form-group row">
                    {{--@if ($errors->any())--}}
                        {{--<div class="alert alert-danger">--}}
                            {{--<ul>--}}
                                {{--@foreach ($errors->all() as $error)--}}
                                    {{--<li>{{ $error }}</li>--}}
                                {{--@endforeach--}}
                            {{--</ul>--}}
                        {{--</div>--}}
                    {{--@endif--}}

                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>

                <div class="form-group row">
                    <button type="submit" class=" form-control btn btn-warning">
                        {{ __('Register') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @endsection