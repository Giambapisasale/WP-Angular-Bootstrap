@extends('master')

@section('container')

<div class="wrapper">

    {{ Form::open(array('url' => '/', 'method' => 'post')) }}
        {{ Form::text('url') }}
        {{ Form::text('valid') }}
        {{ Form::submit('shorten') }}
    {{ Form::close() }}

</div><!-- /wrapper -->

@stop 