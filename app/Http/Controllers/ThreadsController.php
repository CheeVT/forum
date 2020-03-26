<?php

namespace App\Http\Controllers;

use App\User;
use App\Board;
use App\Thread;
use App\Inspections\Spam;
use Illuminate\Http\Request;
use App\Filters\ThreadFilters;
use Illuminate\Support\Facades\Auth;

class ThreadsController extends Controller
{

    public function __construct() {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Board $board, ThreadFilters $filters)
    {
        $threads = $this->getThreads($board, $filters);

        if(request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Spam $spam)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'board_id' => 'required|exists:boards,id'
        ]);

        $spam->detect(request('body'));

        $thread = Thread::create([
            'title' => $request->title,
            'body' => $request->body,
            'user_id' => Auth::user()->id,
            'board_id' => $request->board_id
        ]);

        return redirect($thread->show_url())
            ->with('flash', 'Created a new thread.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($boardId, Thread $thread)
    {
        //return $thread;
        //return view('threads.show', compact('thread'));

        if(auth()->check()) {
            auth()->user()->read($thread);
        }
        
        return view('threads.show', [
            'thread' => $thread,
            //'replies' => $thread->replies()->paginate(20)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Board $board, Thread $thread)
    {
        $this->authorize('delete', $thread);
        //$thread->replies()->delete();
        $thread->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect(route('threads.index'));
    }

    protected function getThreads(Board $board, ThreadFilters $filters) {
        $threads = Thread::latest()->filter($filters);

        if($board->exists) {
            $threads->where('board_id', $board->id);
        }

        return $threads->get();
    }
}
