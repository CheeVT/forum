@component('profiles.activities.activity')
    @slot('heading')
        {{ $user->name }} replied to
        <a href="{{ $activity->subject->thread->show_url() }}">{{ $activity->subject->thread->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }} 
    @endslot
@endcomponent