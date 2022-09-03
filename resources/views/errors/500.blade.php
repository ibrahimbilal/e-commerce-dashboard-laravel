@extends('errors.layout')

@section('title', '500')

@section('content')
	<div class="error-code">
		<b>500</b>
	</div>
	<div class="error-content">
		<p>Internal server error</p>
        <p>Oops, looks like something went wrong!</p>
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
