<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRecordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'string|max:255',
            'content' => 'string|max:255',
            'status' =>  'in:Allowed,Prohibited',
        ];
    }
}
