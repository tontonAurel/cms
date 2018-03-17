@extends('layouts.base')

@section('app', 'post-create')

@section('content')
    <div class="container">
        <b-form @submit="loading=true" enctype="multipart/form-data" method="post" action="{{ route('posts.store') }}" class="mt-2">
            @csrf
            <b-form-group id="titleGroup"
                          label="Titre :"
                          label-for="title"
            >
                <b-form-input id="title"
                              type="text"
                              name="title"
                              v-model="post.title"
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
                                 :max-rows="6">
                </b-form-textarea>
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
                <b-form-file v-model="post.files"  placeholder="Photos" multiple name="photos"></b-form-file>
            </b-form-group>
            <b-button variant="primary" type="submit">
                Ajouter <i class="fas fa-x fa-spinner fa-spin" v-show="loading"></i>
            </b-button>
        </b-form>
    </div>
@endsection

@push('scripts')
    <script src="{{mix('js/post-create.js')}}"></script>
@endpush
