<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Session;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = 'admin/index';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('admin-logout');
    }

    public function loginForm()
    {   
        try {
            return view('admin.index');
        } catch (Exception $e) {
           return $e->getMessage();
        }   
    }

    public function redirectPath()
    {
        try {
            if (method_exists($this, 'redirectTo')) {
                return $this->redirectTo();
            }

            return property_exists($this, 'redirectTo') ? $this->redirectTo : '/admin/index';

        } catch (Exception $e) {
           return $e->getMessage();             
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->guard('admin')->logout();

            $request->session()->invalidate();

            return redirect()->route('admin-home');//else use route(\URL::previous());

        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }
}
