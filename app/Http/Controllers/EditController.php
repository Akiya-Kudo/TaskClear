<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\selfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;
use App\Models\Subgoal;
use App\Models\Sublist;

class EditController extends Controller
{
    /**
     * goal追加画面の表示
     * @param
     * @return view
     */
    public function goal () 
    {
        // メニューバーに表示するユーザーのゴール一覧を取得
         // ゴール一覧表示のためのユーザーIDの取得
         $userid = Auth::user()->only('id');
         $goals = Goal::where('userid', $userid)->get();

        return view('Make.goal', compact('goals'));
    }

    /**
     * goalを追加する
     * @param
     * @return route
     */
    public function makeGoal (Request $request)
    {
        ////////////////////////////バリデーション後で
        //DB保存
        $data = $request->only('goal', 'memo', 'complete_date', 'tag');
        $goal = Goal::create([
            'userid' => Auth::user()->id,
            'title' => $data['goal'],
            'memo' => $data['memo'],
            'complete_date' => $data['complete_date'],
            'tag' => $data['tag'],
        ]);
        $goalid = $goal->id;
        return redirect()->route('detail',$goalid)->with('goal_make_success', 'Goalを新たに作成しました');
    }

    /**
     * subGoal入力画面の表示
     */
    public function subgoal ($goalid) 
    {
        // メニューバーに表示するユーザーのゴール一覧を取得
         // ゴール一覧表示のためのユーザーIDの取得
        $userid = Auth::user()->only('id');
        $goals = Goal::where('userid', $userid)->get();

        $cer_goals = Goal::where('id', $goalid)->get();
        $cer_goal = $cer_goals['0']; //内包されている配列を取得

        return view('Make.subgoal', compact('goals', 'cer_goal'));
    }

    /**
     * subgoalを追加する
     * @param
     * @return route
     */
    public function makeSubgoal (Request $request)
    {
        ////////////////////////////バリデーション後で
        //DB取得
        $data = $request->only('subgoal', 'memo', 'complete_date', 'list1', 'list2', 'list3', 'list4', 'list5','goalid');

        //subgoalのsubnumber取得
        $exist_subs_count = Subgoal::where('goalid', $data['goalid'])->count();
        $subnumber = $exist_subs_count + 1;
        //subgoal DB保存
        $subgoal = Subgoal::create([
            'userid' => Auth::user()->id,
            'goalid' => $data['goalid'],
            'subnumber' => $subnumber,
            'title' => $data['subgoal'],
            'memo' => $data['memo'],
            'complete_date' => $data['complete_date'],
        ]);

        // リスト抜けの場合のリスト整列
        $lists = selfController::adjustList($data);
        // sublist DB保存 ・・リストがある場合の
        if (isset($lists['list1'])) {
            $sublist = Sublist::create([
                'subgoalid' => $subgoal['id'],
                'goalid' => $data['goalid'],
                'list1' => $lists['list1'],
                'list2' => $lists['list2'],
                'list3' => $lists['list3'],
                'list4' => $lists['list4'],
                'list5' => $lists['list5'],
            ]);
        }
        
        $goalid = $data['goalid'];

        return redirect()->route('detail',$goalid)->with('subgoal_make_success', 'Sub Goalを新たに作成しました');
    }

    /**
     * サブゴールとそのリストを削除する
     * @param 
     * @return 
     */
    public function deleteSubgoal (Request $request) 
    {
        // データの取得
        $data = $request->only('subgoalid', 'title','goalid');
        // リダイレクト時に必要なgoalidを代入
        $goalid = $data['goalid'];

        // サブゴールを削除
        $subgoal = Subgoal::destroy($data['subgoalid']);

        // リストが存在していた場合のみリストを削除
        if (Sublist::where('subgoalid', $data['subgoalid'])->exists()) {
            $deletelist = Sublist::where('subgoalid', $data['subgoalid'])->delete();
        }
        
        return redirect()->route('detail',$goalid)->with('success_delete_sub', "title : {$data['title']} を完全に削除しました");
    }

    public function deleteGoal (Request $request) 
    {
        // データ取得
        $data = $request->only('goalid','title');
        // dd($data);

        // ゴールを削除する
        $goal = Goal::destroy($data['goalid']);
        // 付随するサブゴールとリストをgoalidによって削除する
        if (Subgoal::where('goalid', $data['goalid'])->exists()) {
            $subgoal = Subgoal::where('goalid', $data['goalid'])->delete();
        }
        if (Sublist::where('goalid', $data['goalid'])->exists()) {
            $list = Sublist::where('goalid', $data['goalid'])->delete();
        }

        return redirect()->route('home')->with('success_delete_goal', "title : {$data['title']} を完全に削除しました");
    }
}
