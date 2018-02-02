@extends('layouts.app')

@section('content')
  <h2 class="is-size-3">{{ \App\User::count() }} users registered on the system</h2>
  <div class="content">
    <ul>
      @foreach(\App\User::all() as $user)
        <li>{{ $user->name }} (<a href="mailto:{{$user->email}}">{{ $user->email }}</a>)</b>. Registered Trips: {{ $user->trips->count() }}
        </li>
      @endforeach
    </ul>
  </div>
@endsection
