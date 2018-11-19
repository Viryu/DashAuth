@extends('layouts.dashboardHeader')

@section('content')
    <div class="page-header"> <h1>{{ __('Register MID TID') }}</h1></div>

    <div class="panel panel-default col-md-6">
        <div class=" panel-body">
            <form method="POST" action="{{route('registerMidTid')}}" aria-label="{{ __('Register MID TID') }}">
                @csrf

                <div class="form-group row">
                    <label for="email" class="">{{ __('E-Mail Address') }}</label>

                    <div class="">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="merchantId" class="">{{ __('Merchant ID') }}</label>

                    <div class="">
                        <input id="merchantId" type="text" class="form-control{{ $errors->has('merchantId') ? ' is-invalid' : '' }}" name="MID" required>

                        @if ($errors->has('merchantId'))
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('merchantId') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    <label for="terminalId" class="">{{ __('Terminal ID') }}</label>

                    <div class="">
                        <input id="terminalId" type="text" class="form-control {{ $errors->has('terminalId') ? ' is-invalid' : '' }}" name="TID" required>

                        @if ($errors->has('terminalId'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('terminalId') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group row">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session()->has('message'))
                        <div class="alert alert-success">
                            {{ session()->get('message') }}
                        </div>
                    @endif
                </div>

                <div class="form-group row">
                    <button type="submit" class=" form-control btn btn-warning">
                        {{ __('Register MID TID') }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @endsection

@section('script')
    <script src={{URL::asset('js/registerMidTid.js')}}></script>
    <script>
        var me = <?php echo json_encode( $totalUser ) ?>;
        console.log(me);
    </script>
@endsection
