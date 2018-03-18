@extends('layouts.base')

@section('app', 'post-edit')

@section('content')
    <div class="container">
        <b-breadcrumb :items="bread" class="mt-2">
        </b-breadcrumb>
        @if($errors->any())
            <b-alert variant="danger" show class="mt-2">
                @foreach($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </b-alert>
        @endif
        <b-form @submit="onSubmit" enctype="multipart/form-data" method="post"
                action="{{ route('posts.update', ['id' => $post->id]) }}"
                class="mt-2">
            <div class="row">
                <div class="col-lg-8">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    <input type="hidden" name="template_id" value="{{ $post->template_id }}">
                    <b-form-group id="titleGroup"
                                  label="Titre :"
                                  label-for="title"
                    >
                        <b-form-input id="title"
                                      type="text"
                                      name="title"
                                      v-model="post.title"
                                      required
                                      :state="@json($errors->has('title') ? false : null)"
                                      placeholder="Titre">
                        </b-form-input>
                        @if($errors->has('title'))
                            <b-form-invalid-feedback id="inputLiveFeedback">
                                {{ $errors->first('title') }}
                            </b-form-invalid-feedback>
                        @endif
                    </b-form-group>
                    <b-form-group id="descriptionGroup"
                                  label="Description :"
                                  label-for="description"
                    >
                        <b-form-textarea id="description"
                                         v-model="post.description"
                                         placeholder="Description"
                                         :rows="3"
                                         name="description"
                                         class="d-none"
                                         :max-rows="6">
                        </b-form-textarea>
                        <quill-editor ref="myTextEditor"
                                      v-model="post.description"
                                      :options="editorOption">
                        </quill-editor>
                    </b-form-group>
                    <b-form-group id="dateGroup"
                                  label="Date :"
                                  label-for="date"
                    >
                        <b-input-group>
                            <b-form-input id="date"
                                          type="date"
                                          v-model="post.date"
                                          class="datepicker"
                                          name="date"
                                          required
                                          :state="@json($errors->has('date') ? false : null)"
                                          placeholder=YYYY-MM-DD>
                            </b-form-input>
                            <b-input-group-append>
                                <div class="input-group-text"><i class="far fa-calendar-alt"></i></div>
                            </b-input-group-append>
                            @if($errors->has('date'))
                                <b-form-invalid-feedback id="inputLiveFeedback">
                                    {{ $errors->first('date') }}
                                </b-form-invalid-feedback>
                            @endif
                        </b-input-group>

                    </b-form-group>

                    <b-form-group id="photosGroup"
                                  label="Photos:"
                                  label-for="photos"
                    >
                        <b-form-file v-model="post.files" placeholder="Photos" multiple name="photos[]"></b-form-file>
                    </b-form-group>
                    <div class="row">
                        @foreach($post->medias as $idx => $media)
                            <div class="col-md-4 col-sm-6 col-xs-12">
                                <b-card
                                        class="p-0 mb-2"
                                        img-src="{{ asset($media->getMedia()->first()->getUrl('thumb')) }}"
                                        img-top
                                >
                                    <input type="hidden" value="{{$media->id}}" name="medias[{{ $idx }}][id]">
                                    <b-form-group
                                            label="Titre"
                                    >
                                        <b-form-input
                                                :state="@json($errors->has('medias.' . $idx . '.title') ? false : null)"
                                                v-model="post.medias[{{ $idx }}].title"
                                                name="medias[{{ $idx }}][title]"
                                        ></b-form-input>
                                    </b-form-group>
                                    <b-form-group
                                                  label="Description :"
                                    >
                                        <b-form-textarea
                                                         v-model="post.medias[{{ $idx }}].description"
                                                         :rows="3"
                                                         name="medias[{{ $idx }}][description]"
                                                         :max-rows="6">
                                        </b-form-textarea>
                                    </b-form-group>
                                    <b-form-checkbox
                                         v-model="post.medias[{{ $idx }}].destroy"
                                         value="1"
                                         name="medias[{{ $idx }}][destroy]"
                                         unchecked-value="0">
                                        Supprimer
                                    </b-form-checkbox>
                                </b-card>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card mt-3" no-header no-footer>
                        <b-button variant="success" type="submit" variant="" :disabled="loading">
                            Enregistrer
                            <i class="fas fa-x fa-spinner fa-spin" v-if="loading"></i>
                        </b-button>
                    </div>
                </div>
            </div>
        </b-form>
    </div>
@endsection

@push('scripts')
    <script>
        window.bread = {!! json_encode([
            ['text' => 'Tous mes posts', 'href'=> route('posts.index')],
            ['text' => $post->title, 'active' => true],
        ]);
        !!}
            window.old = @json(collect(old())
        ->
        merge($post)
        )
    </script>
    <script src="{{mix('js/post-edit.js')}}"></script>


@endpush
