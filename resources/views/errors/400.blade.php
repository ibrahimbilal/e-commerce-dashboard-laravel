@extends('errors.layout')

@section('title', '400')

@section('content')
	<div class="error-code">
		<b>400</b>
	</div>
	<div class="error-content">
		<p>You are not authorized!</p>
		<p>You don′t have permission to access this page.</p>
	</div>
	<div class="error-cta">
		<a href="{{ route('index') }}">back to home</a>
	</div>
@endsection
