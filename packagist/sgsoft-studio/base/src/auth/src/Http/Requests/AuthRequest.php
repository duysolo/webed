<?php namespace WebEd\Base\Auth\Http\Requests;

use WebEd\Base\Core\Http\Requests\Request;

class AuthRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected $rules = [
        'username' => 'required',
        'password' => 'required',
    ];
}
