<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRecordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:255',
            'status' =>  'in:Allowed,Prohibited',
        ];
    }
}
