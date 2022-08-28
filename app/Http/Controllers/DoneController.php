<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SelfController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Goal;
use App\Models\Subgoal;
use App\Models\Sublist;
use Illuminate\Support\Str;

class DoneController extends Controller
{
    /**
     * リスト達成機能 
     * dbのcompleteを１に変更する
     * @param
     * @return
     */
    public function doneList (Request $request)
    {
        // dd($request);
        $subgoalid = $request->only('subgoalid');
        // checkされた項目を取得
        $data = $request->only('complete1', 'complete2', 'complete3', 'complete4', 'complete5');
        // リストをdbから取得
        // $lists = Sublist::select('complete1', 'complete2', 'complete3', 'complete4', 'complete5','goalid')->where('subgoalid', $subgoalid)->get();
        $lists = Sublist::where('subgoalid', $subgoalid)->get();
        $list_a = $lists[0]; //内包された配列を取得

        //　ループでcheckされた項目の値を変換して$listに代入
        $list = $list_a->only('complete1', 'complete2', 'complete3', 'complete4', 'complete5'); //必要なカラムのみ配列に変換
        for ($f = 1; $f < 6;$f++) {
            if (isset($data["complete$f"])) {
                if ($list["complete$f"] == 0) {
                    $list["complete$f"] = 1;
                } else {
                    $list["complete$f"] = 0;
                }
            }
        }

        \DB::beginTransaction();
        try 
        {
            
            // db更新
            $changedList = Sublist::where('subgoalid', $subgoalid)->update([
                'complete1' => $list['complete1'],
                'complete2' => $list['complete2'],
                'complete3' => $list['complete3'],
                'complete4' => $list['complete4'],
                'complete5' => $list['complete5'],
            ]);
            
            //全てのlistが達成された時にsubgoalを達成済みにし、そうでない場合には未達成とする処理
                // リストのコンテンツを取得
            for ($i = 1; $i < 6; $i++) {
                $exist_lists["list$i"] = $list_a["list$i"];
            }
                // リストの存在するコンテンツのコンプリートを取得
            for ($i = 1; $i < 6; $i++) {
                if (isset($exist_lists["list$i"])) {
                    $exist_completes["complete$i"] = $list["complete$i"];
                }
            }
                // 存在するコンテンツのみのコンプリートが全て達成済みの場合サブゴールのcolorを変化。そうでない場合には戻す
            if (!array_search(0,$exist_completes)) {
                //全て達成済みの場合
                $changedsub = Subgoal::where('id', $subgoalid)->update([
                    'complete' => 1,
                ]);
            } else {
                $changedsub = Subgoal::where('id', $subgoalid)->update([
                    'complete' => 0,
                ]);
            }
            \DB::commit();
        } catch(Throwable $e) 
        {
            \DB::rollback();
            abort(500);
        }
        

        $request->session()->regenerateToken();

        return redirect()->route('detail', $goalid = $list_a['goalid'])->with('alert_success', 'listを更新しました');
    }


    /**
     * ゴール達成記録機能
     * @param request
     * @return route
     */
    public function doneGoal (Request $request)
    {
        $data = $request['goalid'];
        $goal_done = Goal::find($data);
        if ($goal_done->complete === 0) {
            $goal_done->complete = 1;
            $goal_done->save();
            return redirect()->route('home')->with('alert_success', '目標達成おめでとう！！新たな目標に向けて頑張ろう！');
        } else {
            $goal_done->complete = 0;
        }
        $goal_done->save();

        $request->session()->regenerateToken();
        
        return redirect()->route('home');
    }
}
