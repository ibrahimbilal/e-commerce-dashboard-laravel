<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use Laravel\Fortify\Contracts\RegisterResponse;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance(RegisterResponse::class, new class implements RegisterResponse {
			public function toResponse($request)
			{
				return redirect('/admin/users');
			}
		});
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

		// Fortify::loginView(function(){
        //     return view('admin.auth.login');
        // });

		// Fortify::requestPasswordResetLinkView(function(){
        //     return view('admin.auth.forgot-password');
        // });

		// Fortify::resetPasswordView(function($request){
        //     return view('admin.auth.reset-password', ['request' => $request]);
        // });

		// Fortify::verifyEmailView(function(){
        //     return view('admin.auth.verify-email');
        // });

		// Fortify::confirmPasswordView(function(){
        //     return view('admin.auth.password-confirm');
        // });

		// Fortify::twoFactorChallengeView(function(){
        //     return view('admin.auth.two-factor-challeng');
        // });
    }
}
