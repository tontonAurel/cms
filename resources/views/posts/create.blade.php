@extends('layouts.base')

@section('content')
    <div class="container">
        <form method="post" action="{{route('posts.store')}}" class="mt-2" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Titre</label>
                <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp"
                       placeholder="Titre"
                       value="{{ old('title') }}"
                >
                </small>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" class="form-control" placeholder="Description"
                >{{ old('description') }}</textarea>
            </div>
            <div class="form-group">
                <label for="date">Date</label>
                <div class="input-group date">
                    <input type="text" class="form-control datepicker" placeholder="Date" name="date"
                           value="{{ old('date') }}"
                    >

                    <div class="input-group-append">
                        <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="photos">Photos</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="photos[]" multiple/>
                    <label class="custom-file-label" for="validatedCustomFile">Photos</label>
                </div>
            </div>
            <input type="hidden" name="template_id" value="1">
            <button type="submit" class="btn btn-primary">Ajouter</button>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        window.$('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    </script>
@endpush
