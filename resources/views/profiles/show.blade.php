@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
      <h1>
        {{ $user->name }}
        <small>Since {{ $user->created_at->diffForHumans() }}</small>
      </h1>
    </div>

    @forelse($activities as $date => $records)
      <h3 class="page-header">{{ $date }}</h3>
      @foreach($records as $activity)
        @if(view()->exists("profiles.activities.{$activity->type}"))
          @include("profiles.activities.{$activity->type}")
        @endif
      @endforeach
    @empty
      <p>There is no activity for this user yet!</p>
    @endforelse
</div>
@endsection
