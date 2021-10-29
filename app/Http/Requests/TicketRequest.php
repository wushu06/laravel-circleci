<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TicketRequest extends FormRequest
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
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'address' => 'required|string',
            'uni_year' => 'required|string|max:5',
            'degree' => 'required|string',
            'os' => 'required|string',
            'issue' => 'required|string',
        ];
    }
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'first_name.required' => 'First Name is required',
            'last_name.required' => 'Last Name is required',
            'address.required' => 'Address is required',
            'uni_year.required' => 'University Year is required',
            'degree.required' => 'Degree is required',
            'os.required' => 'Operating System is required',
            'issue.required' => 'Issue System is required',
        ];
    }
}
