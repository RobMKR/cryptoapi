<?php

namespace App\Http\Requests\V1\Exchange\Coins;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ListRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Anyway we have handled JWT token in middleware, so
     * we dont need to check user has logged in or not again
     * so we will just set authorize = true
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
            'sort' => 'in:ASC,DESC'
        ];
    }
}
