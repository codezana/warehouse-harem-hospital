<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\SystemExpiration;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use app\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Password;

class LoginController extends Controller
{


    use AuthenticatesUsers;


    protected function attemptLogin(Request $request)
    {
        // Check if the system has expired
        if ($this->isSystemExpired()) {
            return false; // System has expired, prevent login
        }

        // Proceed with user authentication attempt
        $field = filter_var($request->input($this->username()), FILTER_VALIDATE_EMAIL)
            ? 'email'
            : 'username';

        return $this->guard()->attempt(
            [
                $field => $request->input($this->username()),
                'password' => $request->input('password'),
                'is_enabled' => 1,
            ],
            $request->filled('remember')
        );
    }



    protected function isSystemExpired()
    {
        $expirationDate = SystemExpiration::first()->expiration_date;

        if ($expirationDate && Carbon::now()->greaterThan($expirationDate)) {
            return true; // System has expired
        }

        return false; // System is not expired
    }




    protected function validateLogin(Request $request)
    {
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);
    }


    protected function sendFailedLoginResponse(Request $request)
    {

        // Check if the system has expired
        if ($this->isSystemExpired()) {
            throw ValidationException::withMessages([
                $this->username() => ['Your system has expired. Please contact support for assistance.'],
            ]);
        }


        $user = \App\Models\User::where('email', $request->email)
            ->orWhere('username', $request->email)
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                $this->username() => ['The provided username or email is incorrect .'],
            ]);
        }

        if ($user->is_enabled === 0) {
            // Account is disabled
            throw ValidationException::withMessages([
                $this->username() => ['You can\'t login with this account. Please contact support for assistance.'],
            ]);
        }

        // Incorrect password
        if (!password_verify($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'password' => ['The provided password is incorrect.'],
            ]);
        }

        // Default error message if none of the above conditions match
        throw ValidationException::withMessages([
            $this->username() => ['The provided username or email is incorrect.'],
        ]);
    }





    protected function authenticated(Request $request, $user)
    {
        // Get the user's roles
        $roles = $user->roles;

        // Update the status of each role
        foreach ($roles as $role) {
            $roleId = $role->id;
            $this->updateRoleStatus($roleId);
        }
    }

    protected function updateRoleStatus($roleId)
    {
        $role = Role::find($roleId);

        if (Auth::check() && Auth::user()->hasRole($role->name)) {
            // User is logged in and has this role, set status to active
            $role->active = true;
        } else {
            // User is either not logged in or doesn't have this role, set status to inactive
            $role->active = false;
        }

        $role->save();
    }

    protected function logout(Request $request)
    {
        $user = $this->guard()->user(); // Get the authenticated user

        if ($user) {
            $role = $user->roles()->first(); // Assuming the user can have multiple roles

            if ($role) {
                $role->active = false; // Set the role's active status to false
                $role->save(); // Save the changes
            }
        }

        $this->guard()->logout(); // Log the user out

        $request->session()->invalidate(); // Invalidate the session

        $request->session()->regenerateToken(); // Regenerate the CSRF token

        return $this->loggedOut($request) ?: redirect('/');
    }



    // ...
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;




    /**
     * Create a new controller instance.
     * 
     * 
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
