@component('profiles.activities.activity')
    @slot('heading')
        {{ $user->name }} favorited a reply on
        <a href="{{ $activity->subject->favorited->show_url() }}">{{ $activity->subject->favorited->thread->title }}</a> thread.
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }} 
    @endslot
@endcomponent