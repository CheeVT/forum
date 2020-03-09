<div id="reply-{{ $reply->id }}" class="card">
  <div class="card-header article-header">
    <div class="article-header--title">
      <a href="{{ route('profiles.show', $reply->user) }}">{{ $reply->user->name }}</a> - 
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
    @can ('delete', $reply)
      <div class="panel-footer">
          <form method="POST" action="{{ route('replies.destroy', $reply) }}" style="text-align: right;">
              {{ csrf_field() }}
              {{ method_field('DELETE') }}

              <button type="submit" class="btn btn-danger btn-xs align-right">Delete</button>
          </form>
      </div>
    @endcan
</div>