@extends('layouts.base')


@section('app', 'welcome')

@section('content')
    <posts :data='{!! json_encode($posts) !!}'></posts>
@endsection


@section('aside')
    <div class="aside w-25">
        <b-nav vertical class="aside">
            @foreach($dates->get()->groupBy(function($post) {
                return $post->date->format('Y');
            })->all() as $key => $posts)
                @php
                    $date = \Carbon\Carbon::createFromFormat('Y',$key);
                @endphp
                <li class="nav-item">
                    <a class="nav-link pt-1 pb-1 d-inline-block"
                       href="{{ route('welcome', ['year' => $date->format('Y')]) }}">{{ $key }} ({{ $posts->count() }})</a>
                    <b-btn class="pt-0 pb-0 2" variant="link"
                           @click="showCollapse['{{$key}}'] = !showCollapse['{{$key}}']" variant="primary">
                    <span v-show="!showCollapse['{{$key}}']">
                        <i class="fas fa-caret-right"></i>
                    </span>
                        <span v-show="showCollapse['{{$key}}']">
                        <i class="fas fa-caret-down"></i>
                    </span>
                    </b-btn>
                </li>
                <b-collapse id="item-{{ $key }}" v-model="showCollapse['{{$key}}']">
                    @foreach($posts->groupBy(function($post) {
                        return $post->date->format('F Y');
                    })->all() as $key => $posts)
                        @php
                            $id = str_slug($key);
                            $date = \Carbon\Carbon::createFromFormat('F Y',$key);
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link pt-1 pb-1 d-inline-block"
                               href="{{ route('welcome', ['year' => $date->format('Y'), 'month' => $date->format('m')]) }}">{{ $date->format('m/Y') }}
                                ({{ $posts->count() }})</a>
                            <b-btn class="pt-0 pb-0" variant="link" @click="showCollapse['{{$id}}'] = !showCollapse['{{$id}}']">
                                <span v-show="!showCollapse['{{$id}}']">
                                    <i class="fas fa-caret-right"></i>
                                </span>
                                <span v-show="showCollapse['{{$id}}']">
                                    <i class="fas fa-caret-down"></i>
                                </span>
                            </b-btn>
                        </li>
                        <b-collapse id="item-{{ $id }}" v-model="showCollapse['{{$id}}']">
                            @foreach($posts->groupBy(function($post) {
                                return $post->date->format('d/m/Y');
                            })->all() as $key => $posts)
                                @php
                                    $date = \Carbon\Carbon::createFromFormat('d/m/Y',$key);
                                @endphp
                                <b-nav-item class="pt-1 pb-1" href="{{route('welcome', ['year' => $date->format('Y'), 'month' => $date->format('m'), 'day' => $date->format('d')])}}">{{ $key }} ({{ $posts->count() }})</b-nav-item>
                            @endforeach
                        </b-collapse>
                    @endforeach
                </b-collapse>
            @endforeach

        </b-nav>
    </div>
@endsection

@push('scripts')
    <script src="{{mix('js/welcome.js')}}"></script>
@endpush

