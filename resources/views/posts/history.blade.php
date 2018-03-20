@extends('layouts.base')

@section('app', 'post-history')

@section('content')
    <div class="container">
        <b-breadcrumb :items="bread" class="mt-2">
        </b-breadcrumb>
        <div class="row">
            <div class="col-lg-8">
                <h2>Evolution</h2>
                <p>Créé le {{ $post->created_at }}</p>
                @forelse($post->audits as $audit)
                    <h3>Mise à jour du {{ $audit->created_at }}</h3>
                    <div class="row">
                        <div class="col-md-2">Ancien Titre</div>
                        <div class="col-md-8">{{$audit->old_values['title']}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Nouveau Titre</div>
                        <div class="col-md-8">{{$audit->new_values['title']}}</div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-2">Ancienne Description</div>
                        <div class="col-md-8">{{$audit->old_values['description']}}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Nouvel Description</div>
                        <div class="col-md-8">{!! $audit->new_values['description']  !!}</div>
                    </div>
                @empty
                    <div class="row">
                        <div class="col-md-2">Titre</div>
                        <div class="col-md-8">{{ $post->title }}</div>
                    </div>
                    <div class="row">
                        <div class="col-md-2">Description</div>
                        <div class="col-md-8">{!! $post->description!!}</div>
                    </div>
                @endforelse
                <h2 class="mt-3">Collections </h2>
                @php
                    $collections = $post->collectionsWithTrashed;
                    $groups = $collections->groupBy(function($c) {
                        return $c->pivot->collection_id;
                    });
                @endphp
                <b-tabs class="mt-1">
                    @foreach ($groups as $id => $collections)
                        <b-tab title="{{ $collections->first()->name }}" active>
                            <h2 class="mt-2">Collection : {{ $collections->first()->name }}</h2>
                            @php
                                $collections = $collections->map(function($c) {
                                    $c->date = $c->pivot->created_at;
                                    $c->source = 'created';
                                    return $c;
                                });
                                $deleted = $collections->filter(function($c) {
                                    return $c->pivot->deleted_at != null;
                                })->map(function($c) {
                                    $t = clone $c;
                                    $t->date = $t->pivot->deleted_at;
                                    $t->source = 'deleted';
                                    return $t;
                                });

                                $all = $collections->concat($deleted);
                                $all = $all->sortBy(function($c) {
                                    return $c->date;
                                });
                            @endphp
                            <div class="row">
                                @foreach ($all as $collection)
                                    <div class="col-md-4">
                                        <div class="card mt-2 @if($collection->source == 'deleted') text-white bg-danger @else text-white bg-success @endif">
                                            <img class="card-img-top"
                                                 src="{{ asset($collection->pivot->postWithTrashed->thumb) }}"/>
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    #{{ $collection->pivot->postWithTrashed->id }}</h5>
                                                @if($collection->source == 'created')
                                                    <p>Ajouté le {{ $collection->pivot->created_at }}</p>
                                                @else
                                                    <p>Supprimé le {{ $collection->pivot->deleted_at }}</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </b-tab>
                    @endforeach
                </b-tabs>
            </div>
            <div class="col-lg-4">
                <div class="card mt-3" no-header no-footer>
                    <b-button variant="info" href="{{route('posts.edit', ['id' => $post->id])}}">
                        Retour
                    </b-button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        window.bread = {!! json_encode([
            ['text' => 'Tous mes posts', 'href'=> route('posts.index')],
            ['text' => $post->title, 'href'=> route('posts.edit', ['id' => $post->id])],
            ['text' => 'History', 'active' => true],
        ]);
        !!}
    </script>
    <script src="{{mix('js/post-history.js')}}"></script>


@endpush