@extends('layouts.base')

@section('content')
    <div class="container">
        @include('posts')
    </div>
@endsection

@push('scripts')
    <script>
        /*
        window.axios.get('{{$posts->nextPageUrl()}}').then(response => {
            window.$('.container').append(response.data)
        });
        */

    </script>
@endpush