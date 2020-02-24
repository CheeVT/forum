<div class="card">
  <div class="card-header article-header">
    <div class="article-header--title">
      <a href="#">{{ $reply->user->name }}</a> - 
      {{ $reply->created_at->diffForHumans() }}
    </div>
    <div>
      <form action="{{ route('favorites.store', ['reply' => $reply]) }}" method="POST">
        @csrf
        <button type="submit" {{ !$reply->isFavorited() ?: 'disabled' }}>{{ $reply->favorites_count }} {{ str_plural('Like', $reply->favorites_count) }}</button>
      </form>
    </div>
  </div>
  <div class="card-body">
      {{ $reply->body }}
  </div>
</div>