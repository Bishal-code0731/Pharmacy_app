@extends('layouts.pharmacy')

@section('content')
<div class="search-results">
    <h2>Search Results for "{{ request('query') }}"</h2>
    
    @if($results->count() > 0)
        <ul>
            @foreach($results as $result)
                <li>{{ $result->name }}</li>
            @endforeach
        </ul>
    @else
        <p>No results found.</p>
    @endif
</div>
@endsection