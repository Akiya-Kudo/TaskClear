<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Subgoal;
use Illuminate\Support\Facades\Auth;

class ContentAuthValidFromSubid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // コンテンツからuseridを取得
        $subgoalid = $request['subgoalid'];
        $ori_Uid = Subgoal::select('userid')->find($subgoalid);
        // リクエストコンテンツidが存在しない場合４０４を返す
        if (is_null($ori_Uid)) { abort(404);}
        $Uid_content['id'] = $ori_Uid['userid'];
        
        // ログインユーザーのidを取得
        $Uid = Auth::user()->only('id');
        
        // ログインユーザーとコンテンツのuseridが一致しない場合404を返す
        if (!($Uid_content['id'] === $Uid['id'])) {
            abort(404);
        }


        return $next($request);
    }
}
