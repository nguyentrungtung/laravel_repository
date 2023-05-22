<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Http\Requests\Admin\Auth\LoginRequest;
use Carbon\Carbon;
use App\Models\LogActivity;
use Redirect;


class LoginController extends Controller
{
    use AuthenticatesUsers;
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin/home/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * show login form
     */
    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    public function authenticate(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            // Authentication passed...
            return redirect()->intended('/admin/home')->with('success', 'Đăng Nhập Tài Khoản Thành Công!');
        }else {
            return Redirect::back()->withInput();
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('admin/login');
    }

}
