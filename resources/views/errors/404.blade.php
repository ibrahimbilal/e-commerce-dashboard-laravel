@extends('errors.layout')

@section('title', '404')

@section('content')
	<div class="error-code">
		<b>404</b>
	</div>
	<div class="error-content">
		<p>Oops! we're sorry!</p>
        <p>the page you are looking for can't be found.</p>
	</div>
	<div class="error-cta">
		<a href="{{ route('index') }}">back to home</a>
	</div>
@endsection
