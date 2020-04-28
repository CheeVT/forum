{{-- Edit --}}
<div class="card" v-if="editing">
  <div class="article-header">
    <div class="card-header article-header--title">
      <input type="text" class="form-control" v-model="form.title" />
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
      <textarea class="form-control" rows="10" v-model="form.body"></textarea>
  </div>

  <div class="card-footer">
    <button class="btn btn-primary-xs" @click="update">Update</button>
    <button class="btn btn-xs" @click="resetForm">Cancel</button>
  </div>
</div>

{{-- Show --}}
<div class="card" v-else>
  <div class="article-header">
    <img src="{{ $thread->owner->avatar_path }}" width="40" height="40" style="margin: 10px;" />
    <div class="card-header article-header--title">
      <h2 v-text="title"></h2>
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

  <div class="card-body" v-text="body"></div>

  <div class="card-footer" v-if="authorize('owns', thread)">
    <button class="btn btn-xs" @click="editing = true" v-show="! editing">Edit</button>
  </div>
</div>