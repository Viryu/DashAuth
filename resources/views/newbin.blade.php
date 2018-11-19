@extends('layouts.dashboardHeader')
@section('content')
    <div>
        <div class="panel panel-default col-md-5">
            <div class=" panel-body">
                <div>
                    <form method="POST" action="insertnewbin">
                        {{csrf_field()}}
                        <div class="form-group row">
                            <label for="setbin">Enter New BIN </label>
                            <input name="setbin" id="setbin" type="text" class="form-control" maxlength="6" required>
                        </div>
                        <div class="form-group row">
                            <label for="setbankname"> Bank Name</label>
                            <input name="setbankname" id="setbankname" type="text" class="form-control">
                        </div>
                        <div class="form-group row">
                            <label for="settype"> Card Type</label>
                            <select name="settype" id="settype">
                                <option value="Debit" selected="selected">Debit</option>
                                <option value="Credit">Credit</option>
                            </select>
                        </div>
                        <div class="form-group row">
                            <button type="submit" class=" form-control btn btn-warning">
                                Enter
                            </button>
                        </div>
                    </form>
                    @if($condition == 'here')
                        <div class="alert alert-warning">
                            {{$binmessage}}
                        </div>
                        @if($status == 'fail')
                            <div class="alert alert-danger">
                                @foreach($bankcode as $bankcode)
                                {{$bankcode->BIN}} {{$bankcode->merchant_bank}} {{$bankcode->Type}}
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-success">
                                {{$newbankcode->BIN}} {{$newbankcode->merchant_bank}} {{$newbankcode->Type}}
                            </div>
                        @endif
                    @endif
                    <hr>
                </div>
            </div>
        </div>
    </div>
@endsection