<?php

namespace App\Http\Requests;

use App\Models\Type;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class EvenementRequest extends FormRequest
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
        return [
            'titre' => 'required|'.Rule::in(Type::TYPES),
            'description' => 'required|string|max:255',
            'date_event' => 'required|date',
            'lieu_id' => 'required|exists:lieux,id',
            'artistes.*' => 'exists:artistes,id',
            'prix.*.categorie' => 'sometimes|required|string',
            'prix.*.nombre' => 'sometimes|required|numeric',
            'prix.*.valeur' => 'sometimes|required|numeric',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
