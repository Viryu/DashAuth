@extends('layouts.dashboardHeader')
@section('content')
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDGBw7-00Bj8nI8368nfnhyiHPcAgUN5dk&callback=initMap"
            type="text/javascript">
    </script>
    <div style="width: 1200px; height: 700px;">
        {!! Mapper::render() !!}
    </div>
@endsection