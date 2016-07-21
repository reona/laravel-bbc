<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommentRequest extends Request
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
        	'commenter' => 'required',
			'comment' => 'required',
        ];
    }

    public function messages()
	{
		return [
			'commenter.required' => 'タイトルを正しく入力してください',
			'comment.required' => '本文を正しく入力してください',
		];
	}
}
