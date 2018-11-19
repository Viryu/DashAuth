@extends('layouts.dashboardHeader')

{{--<script>--}}
    {{--function password(){--}}
        {{--var newpassword = prompt("Please enter new password :","");--}}
        {{--if(newpassword == "" || newpassword == null){--}}
            {{--window.alert("canceled");--}}
        {{--}--}}
        {{--else{--}}
            {{--$.ajaxSetup({--}}
                {{--headers: {--}}
                    {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                {{--}--}}
            {{--});--}}
            {{--$.ajax({--}}
                {{--url:"/changepasswordeveryone",--}}
                {{--type:"POST",--}}
                {{--beforeSend: function (xhr) {--}}
                    {{--var token = $('meta[name="csrf_token"]').attr('content');--}}

                    {{--if (token) {--}}
                        {{--return xhr.setRequestHeader('X-CSRF-TOKEN', token);--}}
                    {{--}--}}
                {{--},--}}
                {{--data:{--}}
                    {{--newpassword:newpassword--}}
                {{--},--}}
                {{--success:function(){--}}
                    {{--window.alert("succeed");--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}
    {{--}--}}
{{--</script>--}}
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                @endif
                {{--Headings--}}
                <div class="panel-heading">
                    Administration Control
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Last Login</th>
                        <th>mid</th>
                        <th>Status</th>
                        <th>Action</th>
                        <th>Change Password</th>
                        </thead>
                        <tbody>
                        @CSRF
                        @foreach($user as $user)
                            <tr>
                                <td>
                                    {{$user->name}}
                                </td>
                                <td>
                                    {{$user->email}}
                                </td>
                                <td>
                                    {{$user->role}}
                                </td>
                                <td>
                                    {{$user->lastLogin}}
                                </td>
                                <td>
                                    {{$user->mid}}
                                </td>
                                <form action="/activate" method="post">
                                <td>
                                        @if($user->active == 1)
                                            Active
                                        @else
                                            Deactive
                                        @endif
                                </td>
                                    <td>
                                        <input type="hidden"name="id" value="{{$user->id}}">
                                        <input type="hidden" name="active" value="{{$user->active}}">
                                        {{csrf_field()}}
                                        @if($user->role == "admin")
                                        @else
                                        @if($user->active == 0)
                                            <button class="btn">Active</button>
                                        @else
                                            <button class="btn">Deactive</button>
                                        @endif
                                        @endif
                                    </td>
                                </form>
                                <td>
                                    <form action="/changepasswordeveryone" method="post">
                                        {{csrf_field()}}
                                        <input type="hidden" name="id" value="{{$user->id}}">
                                        <input type="hidden" name="active" value="{{$user->active}}">
                                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                        @if ($errors->has('password'))
                                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                                        @endif
                                        <button type="submit" class=" form-control btn btn-warning">
                                            Change Password
                                        </button>
                                    </form>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
    </div>
@endsection