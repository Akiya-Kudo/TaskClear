<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Controllers\SelfController;
use Illuminate\Http\Request;
use App\Http\Requests\GoalMakeFormRequest;
use App\Http\Requests\SubMakeFormRequest;
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
    public function makeGoal (GoalMakeFormRequest $request)
    {
        //DB保存
        $data = $request->only('goal', 'memo', 'complete_date', 'tag', 'color');
        $goal = Goal::create([
            'userid' => Auth::user()->id,
            'title' => $data['goal'],
            'memo' => $data['memo'],
            'complete_date' => $data['complete_date'],
            'tag' => $data['tag'],
            'color' => $data['color'],
        ]);
        $goalid = $goal->id;

        $request->session()->regenerateToken();

        return redirect()->route('detail',$goalid)->with('alert_success', 'Goalを新たに作成しました');
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
    public function makeSubgoal (SubmakeFormRequest $request)
    {
        // dd($request);
        //DB取得
        $data = $request->only('subgoal', 'memo', 'complete_date', 'list1', 'list2', 'list3', 'list4', 'list5','goalid');

        \DB::beginTransaction();
        try 
        {
            //subgoal DB保存
            $subgoal = Subgoal::create([
                'userid' => Auth::user()->id,
                'goalid' => $data['goalid'],
                // 'subnumber' => $subnumber,
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
            \DB::commit();
        } catch(Throwable $e) 
        {
            \DB::rollback();
            abort(500);
        }
        
        $goalid = $data['goalid'];

        $request->session()->regenerateToken();

        return redirect()->route('detail',$goalid)->with('alert_success', 'Sub Goalを新たに作成しました');
    }

    /**
     * サブゴールとそのリストを削除する
     * @param  request
     * @return route
     */
    public function deleteSubgoal (Request $request) 
    {
        // データの取得
        $data = $request->only('subgoalid', 'title','goalid');
        // リダイレクト時に必要なgoalidを代入
        $goalid = $data['goalid'];

        \DB::beginTransaction();
        try 
        {
            // サブゴールを削除
            $subgoal = Subgoal::destroy($data['subgoalid']);

            // リストが存在していた場合のみリストを削除
            if (Sublist::where('subgoalid', $data['subgoalid'])->exists()) {
                $deletelist = Sublist::where('subgoalid', $data['subgoalid'])->delete();
            }
            \DB::commit();
        } catch(Throwable $e) 
        {
            \DB::rollback();
            abort(500);
        }
        
        return redirect()->route('detail',$goalid)->with('alert_success', "title : {$data['title']} を完全に削除しました");
    }

    /**
     * ゴールの削除機能
     * @param request
     * @return route
     */
    public function deleteGoal (Request $request) 
    {
        // データ取得
        $data = $request->only('goalid','title');
        // dd($data);

        \DB::beginTransaction();
        try 
        {
            // ゴールを削除する
            $goal = Goal::destroy($data['goalid']);
            // 付随するサブゴールとリストをgoalidによって削除する
            if (Subgoal::where('goalid', $data['goalid'])->exists()) {
                $subgoal = Subgoal::where('goalid', $data['goalid'])->delete();
            }
            if (Sublist::where('goalid', $data['goalid'])->exists()) {
                $list = Sublist::where('goalid', $data['goalid'])->delete();
            }
            \DB::commit();
        } catch(Throwable $e) 
        {
            \DB::rollback();
            abort(500);
        }

        return redirect()->route('home')->with('alert_success', "title : {$data['title']} を完全に削除しました");
    }

    /**
     * サブゴール編集画面表示
     * @param request
     * @return view
     */
    public function editSubgoal (Request $request)
    {
        // データ取得
        $data = $request['subgoalid'];  
        // サブゴール情報取得 
        $subs = Subgoal::where('id', $data)->get();
        $sub = $subs['0']; //内包されている配列を取得
        // リスト情報取得
        $lists = Sublist::where('subgoalid', $data)->get();
        // Listが存在しない場合にlistにnullを入れて表示させる
        if (isset($lists['0'])) {
            $list = $lists['0'];  //内包されている配列を取得
        } else {
            for ($i = 1; $i < 6; $i++) {$list["list$i"] = null;}
        }

        // メニューバーに表示するユーザーのゴール一覧を取得
        // ゴール一覧表示のためのユーザーIDの取得
        $userid = Auth::user()->only('id');
        $goals = Goal::where('userid', $userid)->get();

        // タイトル表示ゴール情報の取得
        $cer_goals = Goal::where('id', $sub['goalid'])->get();
        $cer_goal = $cer_goals['0']->only('id', 'title', 'complete_date'); //内包されている配列を取得

        return view("Edit.edit_sub", compact('goals','cer_goal', 'sub', 'list'));
    }

    /**
     * サブゴール編集機能
     * @param request
     * @return route
     */
    public function editSubgoalSubmit (Request $request) 
    {
        //DB取得
        $data = $request->only('subgoal', 'memo', 'complete_date', 'list1', 'list2', 'list3', 'list4', 'list5','goalid','subgoalid');

        \DB::beginTransaction();
        try 
        {
            //subgoal DB保存
            $subgoal = Subgoal::where('id', $data['subgoalid'])->update([
                'userid' => Auth::user()->id,
                'goalid' => $data['goalid'],
                // 'subnumber' => $subnumber,
                'title' => $data['subgoal'],
                'memo' => $data['memo'],
                'complete_date' => $data['complete_date'],
            ]);
            
            // リスト抜けの場合のリスト整列
            $lists = SelfController::adjustList($data);
            $completes = Sublist::select('complete1', 'complete2', 'complete3', 'complete4', 'complete5',)->where('subgoalid', $data['subgoalid'])->get();
            
            //　リストがnullの場合completeを０に設定する
            // リストがdbに存在していたら
            if (isset($completes['0'])) {
                
                $complete = $completes['0'];
                for ($i = 1; $i < 6; $i++) {
                    if (isset($lists["list$i"])) {
                        $comps["comp$i"] = $complete["complete$i"];
                    } else {
                        $comps["comp$i"] = 0;
                    }
                }
                // sublist DB保存 ・・リストがある場合の
                if (isset($lists['list1'])) {
                    $sublist = Sublist::where('subgoalid', $data['subgoalid'])->update([
                        'list1' => $lists['list1'],
                        'list2' => $lists['list2'],
                        'list3' => $lists['list3'],
                        'list4' => $lists['list4'],
                        'list5' => $lists['list5'],
                        'complete1' => $comps['comp1'],
                        'complete2' => $comps['comp2'],
                        'complete3' => $comps['comp3'],
                        'complete4' => $comps['comp4'],
                        'complete5' => $comps['comp5'],
                    ]);
                    
                        //全てのlistが達成された時にsubgoalを達成済みにし、そうでない場合には未達成とする処理
                        // リストのコンテンツを取得
                        // リストの存在するコンテンツのコンプリートを取得
                    for ($i = 1; $i < 6; $i++) {
                        if (isset($lists["list$i"])) {
                            $exist_completes["complete$i"] = $comps["comp$i"];
                        }
                    }
                        // 存在するコンテンツのみのコンプリートが全て達成済みの場合サブゴールのcolorを変化。そうでない場合には戻す
                    if (!array_search(0,$exist_completes)) {
                        //全て達成済みの場合
                        $changedsub = Subgoal::where('id', $data['subgoalid'])->update([
                            'complete' => 1,
                        ]);
                    } else {
                        $changedsub = Subgoal::where('id', $data['subgoalid'])->update([
                            'complete' => 0,
                        ]);
                    }
                } else {
                    $delete_list = Sublist::where('subgoalid', $data['subgoalid'])->delete();
                    $changedsub = Subgoal::where('id', $data['subgoalid'])->update([
                        'complete' => 0,
                    ]);
                }
            } else {
                // sublist DB保存 ・・リストフォームに入力がある場合
                if (isset($lists['list1'])) {
                    $sublist = Sublist::create([
                        'subgoalid' => $data['subgoalid'],
                        'goalid' => $data['goalid'],
                        'list1' => $lists['list1'],
                        'list2' => $lists['list2'],
                        'list3' => $lists['list3'],
                        'list4' => $lists['list4'],
                        'list5' => $lists['list5'],
                    ]);
                }
            }
            \DB::commit();
        } catch(Throwable $e) 
        {
            \DB::rollback();
            abort(500);
        }

        $request->session()->regenerateToken();
        
        return redirect()->route('detail', $goalid = $data['goalid'])->with('alert_success', "title : {$data['subgoal']} の編集を完了しました");
    }

    /**
     * ゴール編集画面を表示する
     * @param request
     * @return view
     */
    public function editGoal (Request $request) 
    {
        $goalid = $request->only('goalid');
        $goal_s = Goal::where('id', $goalid)->get();
        $goal = $goal_s['0'];

        // メニュー表示
        $userid = $goal['userid'];
        $goals = Goal::where('userid', $userid)->get();
        // dd($goal);
         return view('Edit.edit_goal',compact('goal','goals'));
    }

    /**
     * ゴール編集機能
     * @param request
     * @return route
     */
    public function editGoalSubmit (Request $request)
    {
        $data = $request->only('tag', 'goal', 'memo', 'complete_date', 'goalid', 'color');
        // dd($data);

        \DB::beginTransaction();
        try 
        {
            $goal = Goal::where('id', $data['goalid'])->update([
                'title' => $data['goal'],
                'memo' => $data['memo'],
                'complete_date' => $data['complete_date'],
                'tag' => $data['tag'],
                'color' => $data['color'],
            ]);
            \DB::commit();
        } catch(Throwable $e) 
        {
            \DB::rollback();
            abort(500);
        }

        $request->session()->regenerateToken();

        return redirect()->route('home')->with('alert_success', "title : {$data['goal']} を編集しました");
    }
}
