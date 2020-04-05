@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card-header">Forum Threads</div>
            
            @include('threads.partials._list')

            {{ $threads->render() }}
        </div>
         <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Trending Threads
                </div>

                <div class="card-body">
                    <ul class="list-group">
                        @forelse($trending as $thread)
                            <li class="list-group-item">
                                <a href="{{ $thread->path }}">
                                    {{ $thread->title }}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item">There is not any in trending yet!</li>
                        @endforelse
                    </ul>
                </div>
            </div>
         </div>
    </div>
</div>
@endsection
