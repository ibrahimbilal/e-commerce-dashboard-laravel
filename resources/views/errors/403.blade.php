@extends('errors.layout')

@section('title', '403')

@section('content')
	<div class="error-code">
		<b>403</b>
	</div>
	<div class="error-content">
		<p>Forbidden Error!</p>
        <p>you don't have permission to view this resource.</p>
	</div>
	<div class="error-cta">
		<a href="{{ route('index') }}">back to home</a>
	</div>
@endsection
