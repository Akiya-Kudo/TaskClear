<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @return view
     */
    public function showLogin () 
    {
        return view('Auth.login_form');
    }


    /**
     * @param App\Http\Requests\LoginFormRequest $request
     */
    public function login (LoginFormRequest $request) 
    {
        // $form = $request->all();
        // dd($form);
        $credentials = $request->only('email','password');

        if (Auth::attempt($credentials)) 
        {
            $request->session()->regenerate();

            return redirect()->route('home')->with('login_success', 'ログインしました');
        }

        return back()->withErrors([
            'login_error' => 'メールアドレスかパスワードが間違っています'
        ]);
    }


    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout (Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('logout_success', 'ログアウトしました');
    }

    /**
     * @return view
     */
    public function showRegister () 
    {
        return view('Auth.register_form');
    }

    /**
     * @param App\Http\Requests\RegisterFormRequest $request
     */
    public function register (RegisterFormRequest $request) 
    {
        $data = $request->only('username','email','password');
        // dd($request);
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (Auth::attempt($data)) 
        {
            $request->session()->regenerate();

            return redirect()->route('home')->with('register_success', '新規登録が完了しました');
        }

        return back()->withErrors([
            'register_error' => '登録が失敗しました。もう一度やり直して下さい'
        ]);
    }
}

