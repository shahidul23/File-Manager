<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\ParentIdBaseRequest;
use Illuminate\Validation\Rule;
use App\Models\File;
use Illuminate\Support\Facades\Auth;



class StoreFolderRequest extends ParentIdBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'name' => [
                'required', 
                Rule::unique(File::class, 'name')
                    ->where('created_by', Auth::id())
                    ->where('parent_id', $this->parent_id)
                    ->whereNull('deleted_at')
            ]
        ]);
    }
    public function messages(): array
    {
        return [
            'name.unique' => 'A folder with this name already exists in the selected location.',
        ];
    }
    // public function rules(): array
    // {
    //     $parentId = $this->input('parent_id'); // safe to use input() here

    //     return array_merge(parent::rules(), [
    //         'name' => [
    //             'required',
    //             Rule::unique(File::class, 'name')
    //                 ->where('created_by', Auth::id())
    //                 ->where('parent_id', $this->parent_id)
    //                 ->whereNull('deleted_at')
    //         ],
    //     ]);
    // }

    // public function messages(): array
    // {
    //     return [
    //         'name.unique' => 'A folder with this name already exists in the selected location.',
    //     ];
    // }
}
