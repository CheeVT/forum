@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">Forum Threads</div>
            
                @forelse ($threads as $thread)
                    <div class="card mb-3">
                        <div class="card-header">
                                <div class="article-header">
                                    <h4 class="article-header--title">
                                        <a href="{{ $thread->show_url() }}">
                                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                                <strong>{{ $thread->title }}</strong>
                                            @else
                                                {{ $thread->title }}
                                            @endif
                                        </a>
                                    </h4>

                                    <a href="{{ $thread->show_url() }}">
                                        {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                                    </a>
                                </div>
                        </div>
                        <div class="card-body">
                            <div class="body">{{ $thread->body }}</div>

                            <hr>
                        </div>
                    </div>
                @empty
                    <p>There is not any threads</p>
                @endforelse
        </div>
    </div>
</div>
@endsection
