@forelse ($threads as $thread)
  <div class="card mb-3">
    <div class="card-header">
      <div class="article-header">
        <div>
          <h4 class="article-header--title">
            <a href="{{ $thread->show_url() }}">
              @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                <strong>{{ $thread->title }}</strong>
              @else
                {{ $thread->title }}
              @endif
            </a>
          </h4>

          <h6>
            Posted by: <a href="{{ route('profiles.show', $thread->owner) }}">{{ $thread->owner->name }}</a>
          </h6>
        </div>

        <a href="{{ $thread->show_url() }}">
          {{ $thread->replies_count }} {{ str_plural('reply', $thread->replies_count) }}
        </a>
      </div>
    </div>

    <div class="card-body">
      <div class="body">{!! $thread->body !!}</div>
    </div>

    <div class="card-footer">
      {{ $thread->visits() }} Visits
    </div>
  </div>
@empty
  <p>There is not any threads</p>
@endforelse