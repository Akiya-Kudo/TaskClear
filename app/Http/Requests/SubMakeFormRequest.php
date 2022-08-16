<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubMakeFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return True;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subgoal' => 'required|max:250|',
            'memo' => 'max:500',
            'complete_date' => 'required|date',
            'list1' => 'max:100',
            'list2' => 'max:100',
            'list3' => 'max:100',
            'list4' => 'max:100',
            'list5' => 'max:100',
            'goalid' => 'integer',
        ];
    }
}
