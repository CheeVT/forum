@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
      <h1>
        {{ $user->name }}
        <small>Since {{ $user->created_at->diffForHumans() }}</small>
      </h1>
    </div>

    @foreach($threads as $thread)
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
    @endforeach
</div>
@endsection
