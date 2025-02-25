<reply-component :attributes="{{ $reply }}" inline-template v-cloak :key="{{ $reply->id }}">
  <div id="reply-{{ $reply->id }}" class="card">
    <div class="card-header article-header">
      <div class="article-header--title">
        <a href="{{ route('profiles.show', $reply->user) }}">{{ $reply->user->name }}</a> - 
        {{ $reply->created_at->diffForHumans() }}
      </div>
      @if(Auth::check())
      <div>
        <favorite :reply="{{ $reply }}"></favorite>
        {{--  <form action="{{ route('favorites.store', ['reply' => $reply]) }}" method="POST">
          @csrf
          <button type="submit" {{ !$reply->isFavorited() ? 'disabled' : '' }}>{{ $reply->favorites_count }} {{ str_plural('Like', $reply->favorites_count) }}</button>
        </form>  --}}
      </div>
      @endif
    </div>
    <div class="card-body">
      <div v-if="editing">
        <div class="form-group">
          <textarea v-model="body" class="form-control" v-model="body"></textarea>
        </div>
        <button class="btn btn-xs btn-primary" @click="update">Update</button>
        <button class="btn btn-xs btn-link" @click="editing = false">Cancel</button>
      </div>
      <div v-else v-text="body"></div>
    </div>
    @can ('delete', $reply)
      <div class="panel-footer panel-footer--reply">
          <button class="btn btn-sm mr-1" @click="editing = true">Edit</button>
          <button class="btn btn-sm btn-danger mr-1" @click="destroy">Delete</button>
      </div>
    @endcan
  </div>
</reply-component>