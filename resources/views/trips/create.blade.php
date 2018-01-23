@extends('layouts.app')

@section('content')
<form action="{{ route('trips.store') }}" method="POST">
  {{ csrf_field() }}
  From:<br>
  <input type="text" name="from" class="autocompleteStation" required><br>
  To:<br>
  <input type="text" name="to" class="autocompleteStation" required><br>
  Line:<br>
  <input type="text" name="line" required><br><br>
  <input type="submit" value="Add Trip" class="button">
</form>
<script>
  $(document).ready(function () {
    $(".autocompleteStation").autocomplete({
      source: "{{ route('search.autocompleteFrom', ['trenitalia', '']) }}",
      minLength: 2
    });
  })
</script>
@endsection
