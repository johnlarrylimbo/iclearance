<?php

namespace App\Http\Requests\Auth;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate()
    {
			// $client_ip_address = request()->ip();

			$this->ensureIsNotRateLimited();

			$login_type = filter_var($this->input('username'), FILTER_VALIDATE_EMAIL ) 
			? 'email_address' 
			: 'username'; 
	
			$this->merge([ 
					$login_type => $this->input('username') 
			]); 
 
			if (! Auth::attempt($this->only($login_type, 'password') + ['statuscode' => 1500], $this->boolean('remember'))) { 

				Log::channel('audit_trail')->info('Login Request Failed :', [
					'username' => $this->input('username'),
					'ip_address' => request()->ip()
				]);

					// if (! Auth::attempt($this->only('username', 'password') + ['statuscode' => 1500], $this->boolean('remember'))) {
							RateLimiter::hit($this->throttleKey(), 420); /* 7 minutes interval */

							throw ValidationException::withMessages([
									'username' => trans('auth.failed'),
							]);
				}

				Log::channel('audit_trail')->info('Login Request Success :', [
					'username' => $this->input('username'),
					'ip_address' => request()->ip()
				]);

				RateLimiter::clear($this->throttleKey());
			}

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

				Log::channel('audit_trail')->info('Login Request Failed : Account Lock for 420 seconds.', [
					'username' => $this->input('username'),
					'ip_address' => request()->ip()
				]);

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'login_error' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::transliterate(Str::lower($this->input('username')).'|'.$this->ip());
    }
}
