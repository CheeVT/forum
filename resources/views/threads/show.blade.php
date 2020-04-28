@extends('layouts.app')

@section('content')
<thread-view :thread="{{ $thread }}" :initial-replies-count="{{ $thread->replies_count }}" inline-template>
  <div class="container">
    <div class="row justify-content-center thread">
        <div class="col-md-8">
          @include('threads._question')            

          <replies repliesStore="/threads/{{$thread->board->slug}}/{{$thread->slug}}/replies" @removed="repliesCount--" @added="repliesCount++"></replies>
           

            {{-- <div class="pt-3">
              {{ $replies->links() }}
            </div> --}}              
        </div>
        <div class="col-md-4">
          <div class="card card-default">
            <div class="card-body">
              <p>
                This thread was published {{ $thread->created_at->diffForHumans() }} by
                <a href="#">{{ $thread->owner->name }}</a>, and currently has <span v-text="repliesCount"></span> {{ str_plural('reply', $thread->replies_count) }}.
              </p>
              <p>
                <subscribe :is-subscribed-to="{{ json_encode($thread->isSubscribedTo) }}" v-if="loggedIn"></subscribe>

                <button class="btn btn-secondary"
                        v-if="authorize('isAdmin')"
                        @click="toggleLock"
                        v-text="locked ? 'Unlock' : 'Lock'">
                </button>
              </p>
            </div>
          </div>
        </div>
    </div>   
  </div>
</thread-view>
@endsection
