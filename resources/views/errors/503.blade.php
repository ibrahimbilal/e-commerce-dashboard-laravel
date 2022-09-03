@extends('errors.layout')

@section('title', '503')

@section('content')
	<div class="error-code">
		<b>503</b>
	</div>
	<div class="error-content">
		<p>Service Unavailable</p>
        <p>Oops, the server is temporarily unable to service your request!</p>
	</div>
	<div class="error-cta">
		<a id="reload" href="#">reload </a>
	</div>

	<script>
		let btn = document.getElementById('reload');
		btn.onclick = (e) => {
			e.preventDefault();
			window.location.reload();
		}
	</script>
@endsection
