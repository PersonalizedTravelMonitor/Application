@extends('layouts.app')

@section('content')
<form action="{{ route('trips.store') }}" method="POST">
  {{ csrf_field() }}
  From:<br>
  <input type="text" name="from" required><br>
  To:<br>
  <input type="text" name="to" required><br>
  Line:<br>
  <input type="text" name="line" required><br><br>
  <input type="submit" value="Add Trip" class="button">
</form>
@endsection
