@extends('layouts.base')

@section('content')
    <div class="container">
        <div class="jumbotron m-2">
            <h1 class="display-4">{{ $post->title }}</h1>
            <form method="post" action="{{route('posts.update', ['id' => $post->id])}}" class="mt-2"
                  enctype="multipart/form-data">
                <input name="_method" type="hidden" value="PUT">
                @csrf
                <div class="form-group">
                    <label for="title">Titre</label>
                    <input type="text" class="form-control" name="title" id="title" aria-describedby="emailHelp"
                           placeholder="Titre"
                           value="{{ old('title', $post->title) }}"
                    >
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" class="form-control"
                              placeholder="Description">{{ old('description', $post->description) }}</textarea>
                </div>
                <div class="form-group">
                    <label for="date">Date</label>
                    <div class="input-group date">
                        <input type="text" class="form-control datepicker" placeholder="Date" name="date"
                               value="{{ old('date', $post->date->format('Y-m-d')) }}"
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
                <div class="row">
                    @foreach($post->medias as $media)
                        <div class="col-md-3">
                            <div class="card p-0 mb-2">
                                <img class="card-img-top"
                                     src="{{ asset($media->getMedia()->first()->getUrl('thumb')) }}"
                                     alt="Card image cap">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $media->title }}</h5>
                                    <div class="card-text">
                                        <div class="form-group">
                                            <label for="title">Titre</label>
                                            <input name="medias[{{$media->id}}][title]"
                                                   value="{{ old('media.'.$media->id.'title', $media->title) }}"
                                                   class="form-control"
                                            >
                                        </div>
                                        <div class="form-group">
                                            <label for="title">Description</label>
                                            <textarea
                                                    name="medias[{{$media->id}}][description]"
                                                    class="form-control">{{ old('media.'.$media->id.'.description', $media->description) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="submit" class="btn btn-primary">Modifier</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.$('.datepicker').datepicker({
            format: 'yyyy-mm-dd'
        });
    </script>
@endpush
