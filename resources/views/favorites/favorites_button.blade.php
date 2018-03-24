@if (Auth::user()->id != $micropost->user_id) 
    @if (Auth::user()->is_favorite($micropost->id))
        {!! Form::open(['route' => ['favorite.destroy', $micropost->id], 'method' => 'delete']) !!}
            {!! Form::submit('Unfavorite', ['class' => "btn btn-success btn-xs"]) !!}
        {!! Form::close() !!}
    @else
        {!! Form::open(['route' => ['favorite.store', $micropost->id]]) !!}
            {!! Form::submit('Favorite', ['class' => "btn btn-info btn-xs"]) !!}
        {!! Form::close() !!}
    @endif
@endif