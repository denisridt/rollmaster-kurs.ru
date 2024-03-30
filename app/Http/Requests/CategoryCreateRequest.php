<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryCreateRequest extends ApiRequest
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
            'name'=>'required|string|min:1|max:255|unique:categories',
            'photo'=> 'nullable|file|mimes:jpeg,jpg,png,webp|max:4096'

        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Поле "Name" не может быть пустым.',
            'name.max' => 'Поле "Name" не может содержать более :max символов.',
            'name.min' => 'Поле "Name" должно содержать не менее :min символов.',
            'name.unique' => 'Такой "name" уже существует.',

            'photo.file'          => 'Поле "Photo" должно быть файлом.',
            'photo.mimes'         => 'Поле "Photo" должно быть файлом типа: jpeg, jpg, png, webp.',
            'photo.max'           => 'Файл в поле "Photo" должен быть не больше :max килобайт.',
        ];
    }
}
