@component('profiles.activities.activity')
    @slot('heading')
        {{ $user->name }} published
        <a href="{{ $activity->subject->show_url() }}">{{ $activity->subject->title }}</a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent