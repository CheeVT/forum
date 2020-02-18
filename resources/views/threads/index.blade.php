@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Forum Threads</div>

                <div class="card-body">
                    @foreach ($threads as $thread)
                        <article class="pt-2 py-2">
                            <div class="article-header">
                                <h4 class="article-header--title">
                                    <a href="{{ $thread->show_url() }}">{{ $thread->title }}</a>
                                </h4>

                                <a href="{{ $thread->show_url() }}">
                                    {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
                                </a>
                            </div>
                          
                          <div class="body">{{ $thread->body }}</div>
                        </article>

                        <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
