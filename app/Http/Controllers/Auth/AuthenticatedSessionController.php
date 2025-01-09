<?php

namespace App\Http\Controllers\Auth;

use Validator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\AccountRole;
use App\Models\AccountSession;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\SystemInfo;
use App\Models\UrlDirectory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Session;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
    //   $result = [
    //     'system_info' => SystemInfo::where('statuscode', 1000)->get(),
    //     // 'cfreport_url' => UrlDirectory::where([ 'statuscode' => 1000, 'directory_type_id' => 4 ])->get()
    //   ];


    //   return view('auth.login', compact('result'));
      return view('livewire.pages.auth.login');
    }


    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();


        $request->session()->regenerate();


    //   if(auth()->check() && auth()->user()->hasRole(15))
    //     {
    //       return redirect('/admin_dashboard_index');
    //     }
       
        return redirect()->intended(RouteServiceProvider::HOME);
    }


    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
    //   $auth_param = [ auth::id(), 0 ];
    //   $sp_session_query = "EXEC pr_bedsislvl_account_session_by_id_upd :account_id, :result_id;";
    //   $tx_session = DB::select($sp_session_query, $auth_param);


    //   Session::forget('account_session_id');
    //   Session::forget('session_key');


      Auth::guard('web')->logout();


      $request->session()->invalidate();


      $request->session()->regenerateToken();


      return redirect('/');
    }

}
