@extends('admin.auth-layout')

@section('title', 'Confirm Password')

@section('intro', 'Secure Account')

@section('form-wrapper')
	<div class="form-wrapper">
		<div class="form-header">
			<h2>Confirm Password</h2>
			<p>Please confirm your password to activate two factor authentication.</p>
		</div>
		<div class="form-body">
			<form method="POST" action="{{ route('password.confirm') }}">
				@csrf
				<div class="input-wrapper">
					<label for="password">Confirm Password</label>
					<input id="password" type="password" name="password" placeholder="**********"><span
						class="icon show-pass"><i class="fi-rr-eye"> </i></span>
					@error('password')
						<span class="error" role="alert">{{ $message }}</span>
					@enderror
				</div>
				<button type="submit">Confirm</button>
			</form>
		</div>
	</div>
@endsection

@push('scripts')
	<script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        // Show Password
        $('.show-pass').on('click', function() {
            var type = $(this).prev('input').attr('type');
            if (type == 'password') {
                $(this).prev('input').attr('type', 'text');
                $(this).find('i').removeClass('fi-rr-eye').addClass('fi-rr-eye-crossed');
            } else {
                $(this).prev('input').attr('type', 'password');
                $(this).find('i').removeClass('fi-rr-eye-crossed').addClass('fi-rr-eye');
            }
        });
    </script>
@endpush
