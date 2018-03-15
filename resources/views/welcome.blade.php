@extends('layouts.base')

@section('content')
    <div class="container">
        @include('posts')
    </div>
    <div class="loader d-flex justify-content-center mt-5 mb-5 col-12 d-none" ><i class="fas fa-5x fa-spinner fa-spin"></i></div>
@endsection

@push('scripts')
    <script>
        var nextUrl = '{{$posts->nextPageUrl()}}';
        var loading = false;
        var listener = function (event) {
            console.log('scrol')
            var element = document.documentElement;
            document.querySelector('.loader').classList.remove('d-none');
            document.querySelector('.loader').classList.add('d-flex');
            if (element.scrollHeight - element.scrollTop === element.clientHeight) {
                if (!loading && nextUrl) {
                    loading = true;
                    window.axios.get(nextUrl).then(function (response) {
                        window.$('.container').append(response.data.html);
                        nextUrl = response.data.nextUrl;
                        document.querySelector('.loader').classList.add('d-none')
                        document.querySelector('.loader').classList.remove('d-flex')
                        loading = false;
                    })
                }
            }
            if (!nextUrl) {
                document.querySelector('.loader').classList.add('d-none')
                document.querySelector('.loader').classList.remove('d-flex')
                window.removeEventListener('scroll', listener);
            }
        }
        window.addEventListener('scroll', listener);
    </script>
@endpush