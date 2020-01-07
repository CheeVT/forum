@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center thread">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                  <h2>{{ $thread->title }}</h2>
                  <span class="thread__author">Created by: <span>{{ $thread->owner->name }}</span></span>
                  <span class="thread__created-at">{{ date( 'd.m.Y. h:i', strtotime( $thread->created_at ) ) }}</span>
                </div>

                <div class="card-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
          @foreach ($thread->replies as $reply)
            @include('threads.reply')
          @endforeach            
        </div>
    </div>

    <div class="row justify-content-center reply-store">
      <div class="col-md-8">
        @if( auth()->check() )
          <form action="{{ route( 'replies.store', [ 'thread' => $thread ] ) }}" method="POST">
            @csrf
            <div class="form-group">
              <label for="body">Add reply</label>
              <textarea name="body" id="body" rows="10" class="form-control" placeholder="If you have something to say, fill in and submit :-)"></textarea>
            </div>
            <div class="form-group">
              <button type="submit" class="btn btn-primary">Add</button>
            </div>
          </form>
        @else
          <p>Please sign in if you want to reply to this topic!</p>
        @endif
      </div>
    </div>
</div>
@endsection
