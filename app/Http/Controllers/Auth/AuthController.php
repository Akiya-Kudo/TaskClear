<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\LoginFormRequest;
use App\Http\Requests\RegisterFormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Goal;
use App\Models\Subgoal;
use App\Models\Sublist;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @return view
     */
    public function showLogin () 
    {
        \Session::flash('sample_user', "サンプルユーザとしてログインする場合   email : sample@sample.com       パスワード : sample00  でログインをお願いします");
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

            return redirect()->route('home')->with('alert_success', 'ログインしました');
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
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        if (Auth::attempt($data)) 
        {
            $request->session()->regenerate();

            return redirect()->route('home')->with('alert_success', '新規登録が完了しました');
        }

        return back()->withErrors([
            'register_error' => '登録が失敗しました。もう一度やり直して下さい'
        ]);
    }

    /**
     * アカウント削除機能
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function deleteAccount (Request $request) {

        $userid = Auth::user()->only('id');

        $data = Goal::select('id')->where('userid', $userid['id'])->get();

        $goalid = [];
        foreach ($data as $d) { $goalid[] = $d['id']; }

        // トランザクション　全てのtableからレコードを削除
        \DB::beginTransaction();
        try 
        {
            // userを削除
            $user = User::destroy($userid);
            if (!empty($goalid)) {
                foreach ($goalid as $id) {
                    // ゴールを削除する
                    $goal = Goal::destroy($id);
                    // 付随するサブゴールとリストをgoalidによって削除する
                    if (Subgoal::where('goalid', $id)->exists()) {
                        $subgoal = Subgoal::where('goalid', $id)->delete();
                    }
                    if (Sublist::where('goalid', $id)->exists()) {
                        $list = Sublist::where('goalid', $id)->delete();
                    }
                }
            }
            \DB::commit();
            
        } catch(Throwable $e) 
        {
            \DB::rollback();
            abort(500);
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login.show')->with('logout_success', 'アカウントを削除しました');
    }
}

