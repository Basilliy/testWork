<?php

namespace App\Http\Requests\Game;

use Illuminate\Foundation\Http\FormRequest;

class CreateGameRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_team_id'         => 'required|exists:teams,id',
            'first_team_result'     => 'required|min:0',
            'second_team_id'        => 'required|exists:teams,id',
            'second_team_result'    => 'required|min:0',
        ];
    }
}
