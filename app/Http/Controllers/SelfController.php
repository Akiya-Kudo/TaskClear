<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SelfController extends Controller
{
    // 配列を整える 
    // list配列にnullが途中で紛れていた場合に飛ばして順番を整理する

    public static function adjustList ($data) {

        $a = ['list1' => null, 'list2' => null, 'list3' => null, 'list4' => null, 'list5' => null];
        $x = 1;
        for ($i = 1; $i < 6; $i++) {
            if (isset($data["list$i"])){
                $a["list$x"] = $data["list$i"];
                $x++;
            }
        }
        return $a;
    }
}
