<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SelfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;
use App\Models\Subgoal;
use App\Models\Sublist;

class HomeController extends Controller
{
    /**
     * home画面を表示
     * @return view
     */
    public function home (Request $request)
    {
        $user = Auth::user()->only('username','id');
        $username = $user['username'];
        $userid = $user['id'];
        
        $goals = Goal::where('userid', $userid)->get();
        // ゴール達成済みの場合colorをsecondary表示
        $comps = [];
        foreach ($goals as $goal) {
            if ($goal['complete'] === 1) {
                $comps[$goal['id']] = 'secondary';
            } else {
                $comps[$goal['id']] = 'success';
            }
        }
        // dd($comps);
        
        return view('home', compact('goals', 'comps'));
    }

    /**
     * 詳細画面を表示させる
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
        // 元データからcompleteを区別してスタイル文を作成し収納
        foreach($uls_all as $ul_all) {
            foreach($keys_complete as $key) { $cer_complete[$key] = $ul_all[$key]; }
            $i = 1;
            foreach ($cer_complete as $c) {
                if ($c === 1) {
                    $array['color'] = 'secondary';
                    $array['style'] = 'text-decoration-line-through';
                } else {
                    $array['color'] = 'success';
                    $array['style'] = 'text-decoration-none';
                }
                // array_push($list_or, $array);
                $styles["complete$i"] = $array;
                // $styles[] = $array;
                $i++;
            }
            $completes[$ul_all['subgoalid']] = $styles;
        }

        //サブゴール達成済みの時のスタイル変換
        $check_subgoal_comp = [];
        if (isset($subs)) {
            foreach ($subs as $sub) {
                if ($sub['complete'] === 1) {
                    $check_subgoal_comp[$sub['id']] = 'secondary';
                } else {
                    $check_subgoal_comp[$sub['id']] = 'success';
                }
            }
        }
        $sub_colors = $check_subgoal_comp;

        return view('detail', compact('goals', 'cer_goal', 'subs', 'lists', 'completes', 'sub_colors'));
    }
}
