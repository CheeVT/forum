@extends('layouts.app')

@section('head')
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create a New Thread</div>

                <div class="card-body">
                    <form action="{{ route('threads.store') }}" method="POST">
                      @csrf
                      <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control">
                      </div>
                      <div class="form-group">
                        <label for="body">Body</label>
                        {{--  <textarea name="body" id="body" cols="30" rows="10" class="form-control">{{ old('body') }}</textarea>  --}}
                        <wysiwyg name="body"></wysiwyg>
                      </div>

                      <div class="form-group">
                        <label for="board_id">Board</label>
                        <select name="board_id" id="board_id" class="form-control">
                          <option value="">Choose a board</option>
                          @foreach($boards as $board)
                            <option value="{{ $board->id }}" {{ ( old('board_id') == $board->id ) ? 'selected' : '' }}>{{ $board->name }}</option>
                          @endforeach
                        </select>
                      </div>

                      <div class="form-group">
                        <div class="g-recaptcha" data-sitekey="6LcACu4UAAAAABrEtVRLe2Wj3_B0HNXG2ZMiHo1z"></div>
                      </div>

                      <div class="form-group">
                        <button type="submit">Publish</button>
                      </div>

                      @if(count($errors))
                        @foreach($errors->all() as $error)
                          <div class="alert alert-danger" role="alert">
                            {{ $error }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                        @endforeach
                      @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection