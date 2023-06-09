<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->get();
        if (count($user) === 0){
            return view('top.login', ['login_error' => '1']);
        }

        // 一致
        if (Hash::check($request->password, $user[0]->password)) {

            // セッション
            session(['name'  => $user[0]->name]);
            session(['email' => $user[0]->email]);

            // フラッシュ
            session()->flash('flash_flg', 1);
            session()->flash('flash_msg', 'ログインしました。');

            return redirect(url('cmstop'));
        // 不一致
        }else{
            return view('top.login', ['login_error' => '1']);
        }
    }

    public function logout(Request $request)
    {
        session()->forget('name');
        session()->forget('email');
        return redirect(url('/'));
    }
}
