<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostRequest extends FormRequest
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
            'title' => [
                'required',
                'max:50'
            ],
            'author' => [
                'required',
                'max:30'
            ],
            'report' => [
                'required',
                'max:500'
            ],
            'file' => [
                'max:1024',
                'mimes:jpg,png'
            ]
        ];
    }

    public function messages()
    {
        return [
            'title.required' =>'タイトルを入力してください',
            'title.max'=>'タイトルは50文字以内で入力してください',
            'author.required'=>'著者を入力してください',
            'author.max'=>'著者は30文字以内で入力してください',
            'report.required'=>'感想を入力してください',
            'report.max'=>'感想は500文字以内で入力してください',
            'file.imgae'=>'指定されたファイルが画像ではありません',
            'file.mines'=>'指定された拡張子（PNG/JPG/)ではありません',
            'file.max'=>'1MB以下の画像を選択してください',

        ];
    }

    public function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status'=>400,
            'errors'=>$validator->errors(),
        ],400);

        throw new HttpResponseException($response);
        
    }
}
