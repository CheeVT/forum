@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center thread">
      <div class="col-md-8">
          <div class="card">
            <div class="article-header">
              <div class="card-header article-header--title">
                <h2>{{ $thread->title }}</h2>
                <span class="thread__author">Created by: <a href="{{ route('profiles.show', $thread->owner) }}"><span>{{ $thread->owner->name }}</span></a></span>
                <span class="thread__created-at">{{ date( 'd.m.Y. h:i', strtotime( $thread->created_at ) ) }}</span>
              </div>

              @can('delete', $thread)
              <form action="{{ $thread->show_url() }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger mr-3">Delete thread</button>
              </form>
              @endcan
            </div>

            <div class="card-body">
                {{ $thread->body }}
            </div>
          </div>

          @foreach ($replies as $reply)
            @include('threads.reply')
          @endforeach

          <div class="pt-3">
            {{ $replies->links() }}
          </div>
            
          <div class="reply-store">
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
      <div class="col-md-4">
        <div class="card card-default">
          <div class="card-body">
            <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
              <a href="#">{{ $thread->owner->name }}</a>, and currently has {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}.
          </div>
        </div>
      </div>
  </div>   
</div>
@endsection
