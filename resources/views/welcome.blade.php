@extends('layouts.base')

@section('content')
    <posts :data='{!! json_encode($posts) !!}'></posts>
@endsection

