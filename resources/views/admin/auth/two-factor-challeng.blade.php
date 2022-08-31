@extends('admin.auth-layout')

@section('title', 'Two Step Verification')

@section('intro', 'Welcome Back')

@section('form-wrapper')
	<div class="form-wrapper" data-form="code" style="@if ($errors->get('recovery_code')) display:none @endif">
		<div class="form-header">
			<h2>Two Step Verification</h2>
			<p>Please confirm access to your account by entering the authentication code provided by your authenticator application.</p>
		</div>
		@error('code')
			<span class="alert danger" role="alert">{{ $message }}</span>
		@enderror
		<div class="form-body">
			<form method="POST" action="{{ url('/admin/two-factor-challenge') }}">
				@csrf
				<div class="input-wrapper">
					<label for="code">Code</label>
					<input id="code" type="text" name="code" autocomplete="off">
				</div>
				<button type="submit">Sign In</button>
			</form>
		</div>
		<div class="form-footer">
			<p><a class="form-link" href="javascript:void(0)" data-btn="recovery">Use a recovery code</a></p>
		</div>
	</div>

	<div class="form-wrapper" data-form="recovery" style="@if ($errors->get('code')) display:none @elseif(!$errors->all()) display:none @endif">
		<div class="form-header">
			<h2>Two Step Verification</h2>
			<p>Please confirm access to your account by entering one of your emergency recovery codes.</p>
		</div>
		@error('recovery_code')
			<span class="alert danger" role="alert">{{ $message }}</span>
		@enderror
		<div class="form-body">
			<form method="POST" action="{{ url('/admin/two-factor-challenge') }}">
				@csrf
				<div class="input-wrapper">
					<label for="code">Recovery Code</label>
					<input id="code" type="text" name="recovery_code" autocomplete="off">
				</div>
				<button type="submit">Sign In</button>
			</form>
		</div>
		<div class="form-footer">
			<p><a class="form-link" href="javascript:void(0)" data-btn="code">Use an authentication code</a></p>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
		// Toggle Form;
		$('.form-link').on('click', function() {
            var formType = $(this).data('btn');
			$('.form-wrapper').data('form', formType).toggle();
        });
    </script>
@endpush
