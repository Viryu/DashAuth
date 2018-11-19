@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if( Auth::user()->role == "merchant")
                        You logs in as Merchant
                    @else
                        You logs in as Administrator
                    @endif
                    {{date("Y-m-d H:i:s")}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
