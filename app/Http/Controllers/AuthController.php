<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;


class AuthController extends Controller
{

    public function login(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('auth.login');
        }

        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if (!$user) {
            return redirect()
                ->route('home')
                ->with('error', 'User not found in the system');
        }

        if ($this->ldapAuth($credentials)) {
            Auth::login($user);
            return redirect()
                ->route('home')
                ->with('success', 'You have been logged in');
        } else {
            return redirect()
                ->route('home')
                ->with('error', 'Wrong username or password');
        }
    }

    private function ldapAuth($credentials)
    {
        $domain = 'dcrtd.org.kw';
        $ldapconfig['host'] = '172.16.6.220';
        $ldapconfig['port'] = 389;
        $ldapconfig['basedn'] = 'DC=dcrtd,DC=org,DC=kw';
        $ds = ldap_connect($ldapconfig['host'], $ldapconfig['port']);
        ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);
        ldap_set_option($ds, LDAP_OPT_REFERRALS, 0);
        $bind = @ldap_bind($ds, $credentials['username'] . '@' . $domain, $credentials['password']);
        if ($bind) {
            return true;
        }
        return false;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('home');
        //->with('success', 'You have been logged out');
    }
}
