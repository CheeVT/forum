@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
      <h1>
        {{ $user->name }}
        <small>Since {{ $user->created_at->diffForHumans() }}</small>
      </h1>
    </div>

    @foreach($activities as $date => $records)
      <h3 class="page-header">{{ $date }}</h3>
      @foreach($records as $activity)
        @if(view()->exists("profiles.activities.{$activity->type}"))
          @include("profiles.activities.{$activity->type}")
        @endif
      @endforeach
    @endforeach
</div>
@endsection
