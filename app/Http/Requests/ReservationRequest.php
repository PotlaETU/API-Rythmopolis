<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'categorie' => 'required|string',
            'nb_billets' => 'required|integer',
        ];

        if ($this->user()->role == Role::GESTIONNAIRE || $this->user()->role == Role::ADMIN){
            $rules['client_id'] = 'integer|exists:clients,id';
        }

        return $rules;

    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
