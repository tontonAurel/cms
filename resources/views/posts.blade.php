@foreach ($posts as $post)
    <div class="jumbotron m-2">
        <h1 class="display-4">{{ $post->title }}</h1>
        <p class="lead">{{ $post->description }}</p>
        <hr class="my-4">
        @php
            $collectionId = $post->collections->first()->id
        @endphp
        <div class="card-columns">
            @foreach ($post->collections->first()->postsForOwner($post->id) as $media)
                <div class="card">
                    <img class="card-img-top" src="{{ asset($media->getMedia()->first()->getUrl('thumb')) }}"
                         alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">{{ $media->title }}</h5>
                        <p class="card-text">{{ $media->description}}</p>
                    </div>
                </div>

            @endforeach
        </div>
    </div>
@endforeach