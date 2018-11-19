@extends('layouts.dashboardHeader')
@section('content')
    <div>
        <div class="panel panel-default col-md-5">
            <div class=" panel-body">
                <div>
                    <h3>Hello {{$name}}</h3>
                </div>
                <div>
                    <h3 style="margin-top: 0px">Your MID : {{$mid}}</h3>
                    <h3>Join Since {{$date}}</h3>
                    <form method="POST" action="/settarget">
                        {{csrf_field()}}
                        <div class="form-group row">
                        </div>
                        <label for="settarget">Set Target </label>
                        <div class="form-group row">
                            <input name="settarget" id="settarget" type="number" class="form-control">
                            <button type="submit" class=" form-control btn btn-warning">
                                Set Target
                            </button>
                        </div>
                        <div class="form-group row">
                        </div>
                    </form>
                    @if (session()->has('messagetarget'))
                        <div class="alert alert-success">
                            {{ session()->get('messagetarget') }}
                        </div>
                    @endif
                    <hr>
                </div>
                <div>
                    <h3>Change Password</h3>
                </div>
                <hr>

                <form method="POST" action="/changepassword">
                    {{csrf_field()}}
                    <div class="form-group row">
                        <label for="password" class="">Password</label>

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
                        @if ($errors->has('password_confirmation'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif

                    </div>

                    <div class="form-group row">
                        <button type="submit" class=" form-control btn btn-warning">
                            Change Password
                        </button>
                    </div>
                </form>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div>
        <div class="panel panel-default col-md-7">
            <div class=" panel-body">

            </div>
        </div>
    </div>
@endsection