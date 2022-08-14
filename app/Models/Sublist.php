<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Sublist extends Model
{
    use HasFactory;

    protected $table = 'lists';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'subgoalid',
        'list1',
        'list2',
        'list3',
        'list4',
        'list5',
        'complete1',
        'complete2',
        'complete3',
        'complete4',
        'complete5',
        'goalid',
    ];
}
