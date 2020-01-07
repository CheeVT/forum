<div class="card">
  <div class="card-header">
    <a href="#">{{ $reply->user->name }}</a> - 
    {{ $reply->created_at->diffForHumans() }}
  </div>
  <div class="card-body">
      {{ $reply->body }}
  </div>
</div>