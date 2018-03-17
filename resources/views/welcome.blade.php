@extends('layouts.base')


@section('app', 'welcome')

@section('content')
    <posts :data='{!! json_encode($posts) !!}'></posts>
@endsection
@push('scripts')
    <script src="{{mix('js/welcome.js')}}"></script>
@endpush

