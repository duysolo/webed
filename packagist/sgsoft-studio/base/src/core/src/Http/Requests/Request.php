<?php namespace WebEd\Base\Core\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    /**
     * Validation rules
     *
     * @var array
     */
    protected $rules = [];

    public function rules()
    {
        return $this->rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
