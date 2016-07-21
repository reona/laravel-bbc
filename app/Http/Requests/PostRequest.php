<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PostRequest extends Request
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
        	'title' => 'required',
			'content' => 'required',
			'cat_id' => 'required',
        ];
    }

    public function messages()
	{
		return [
			'title.required' => 'タイトルを正しく入力してください',
			'content.required' => '本文を正しく入力してください',
			'cat_id.required' => 'カテゴリーを選択してください',
		];
	}
}
