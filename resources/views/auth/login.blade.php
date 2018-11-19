<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('css/login_style.css') }}">
	 <script>
	src="https://code.jquery.com/jquery-3.3.1.js"
	integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
	crossorigin="anonymous"></script>

	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

</head>
<body class="Bg">
	<div class="container-fluid">
		<div class="row">
			<div class="placeholder col-sm-6 col-md-6 col-lg-4">

                <form class="content" method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                    <div class="logo">
                        <img src="/image/VisionetLogo.png">
                    </div>
                    <hr>

                    @csrf

                    <div class="form-group">
                        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                        <div>
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @elseif ($errors->has('active'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('active') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group ">
                        <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>

                        <div>
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6 offset-md-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                <label class="form-check-label" for="remember">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <div class=" offset-md-4">
                            <button type="submit" class="form-control btn btn-warning">
                                {{ __('Login') }}
                            </button>

                            <a class="btn" id="rememberMe" href="{{ route('password.request') }}">
                                {{ __('Forgot Your Password?') }}
                            </a>
                        </div>
                    </div>
                </form>
            </div>

		</div>
	</div>
</body>
</html>