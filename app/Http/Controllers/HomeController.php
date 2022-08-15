<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;
use App\Models\Subgoal;
use App\Models\Sublist;

class HomeController extends Controller
{
    /**
     * @return view
     */
    public function home (Request $request)
    {
        $user = Auth::user()->only('username','id');
        $username = $user['username'];
        $userid = $user['id'];

        $goals = Goal::where('userid', $userid)->get();
        
        return view('home', compact('goals'));
    }

    /**
     * goalの詳細画面を表示させる
     * @return view
     */
    public function detail ($goalid)
    {
        // メニューバーに表示するユーザーのゴール一覧を取得
         // ゴール一覧表示のためのユーザーIDの取得
        $userid = Auth::user()->only('id');
        $goals = Goal::where('userid', $userid)->get();

        // detail画面に表示するゴールを取得
        $cer_goals = Goal::where('id', $goalid)->get();
        $cer_goal = $cer_goals['0']; //内包されている配列を取得

        // detail画面に表示するゴールのサブゴールを取得
        $subs = Subgoal::where('goalid', $goalid)->get();

        // subgoalsのリストを取得
        $uls_all = Sublist::where('goalid', $goalid)->get();

        // listsをsubgoalidごとに取得
        $lists = [];
        $keys = ['list1', 'list2', 'list3', 'list4', 'list5'];
        foreach($uls_all as $ul_all) {
            foreach($keys as $key) { $cer_list[$key] = $ul_all[$key]; }
            $lists[$ul_all['subgoalid']] = $cer_list;
        }

        // completeカラムをsubgoalsごとに取得
        $completes = [];
        $keys_complete = ['complete1', 'complete2', 'complete3', 'complete4', 'complete5'];
        foreach($uls_all as $ul_all) {
            foreach($keys_complete as $key) { $cer_complete[$key] = $ul_all[$key]; }
            $completes[$ul_all['subgoalid']] = $cer_complete;
        }

        // dd($lists, $completes);

        return view('detail', compact('goals', 'cer_goal', 'subs', 'lists', 'completes'));
    }
}
