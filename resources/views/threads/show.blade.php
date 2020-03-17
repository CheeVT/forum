@extends('layouts.app')

@section('content')
<thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
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

            <replies :thread-id="{{ $thread->id }}" @removed="repliesCount--" @added="repliesCount++"></replies>
           

            {{-- <div class="pt-3">
              {{ $replies->links() }}
            </div> --}}              
        </div>
        <div class="col-md-4">
          <div class="card card-default">
            <div class="card-body">
              <p>
                This thread was published {{ $thread->created_at->diffForHumans() }} by
                <a href="#">{{ $thread->owner->name }}</a>, and currently has <span v-text="repliesCount"></span> {{ str_plural('reply', $thread->replies_count) }}.
              </p>
              <p>
                <subscribe :isSubscribedTo="{{ json_encode($thread->isSubscribedTo) }}"></subscribe>
              </p>
            </div>
          </div>
        </div>
    </div>   
  </div>
</thread-view>
@endsection
