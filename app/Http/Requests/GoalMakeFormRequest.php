<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalMakeFormRequest extends FormRequest
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
            'goal' => 'required|max:250|',
            'tag' => 'required|max:50',
            'memo' => 'required|max:200',
            'complete_date' => 'required|date',

        ];
    }
}
