@extends('layouts.app')

@section('content')
<div class="container">
    <div class="page-header">
      <h1>
        {{ $user->name }}
        <small>Since {{ $user->created_at->diffForHumans() }}</small>
      </h1>

      @can('update', $user)
        <form action="{{ route('api.users-avatar.store', $user) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <input type="file" name="avatar" id="">

          <button type="submit" class="btn btn-primary">Upload avatar</button>
        </form>
      @endcan

      <img src="/{{ $user->avatar() }}" width="100" height="100" />
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
