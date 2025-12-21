<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Database\Eloquent\Builder;
use App\Models\File;
use Illuminate\Support\Facades\Auth;


class ParentIdBaseRequest extends FormRequest
{
    public ?File $parent = null;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $this->parent = File::query()
            ->where('id', $this->input('parent_id'))
            ->first();
        if ($this->parent && !$this->parent->isOwnedBy(Auth::id())) {
            return false;
        }
        return true;
    }
    // public function authorize(): bool
    // {
    //     // Only allow authenticated users
    //     return Auth::check();
    // }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    // public function rules(): array
    // {
    //     return [
    //         'parent_id' => [
    //             Rule::exists(File::class, 'id')
    //             ->where(function (Builder $query) {
    //                 return $query
    //                 ->where('is_folder', '=', 1)
    //                 ->where('created_by', '=', Auth::id());
    //             }),
    //         ],
    //     ];
    // }
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                Rule::exists(File::class, 'id')
                    ->where(function ($query) {
                        $query->where('is_folder', 1)
                              ->where('created_by', Auth::id());
                    }),
            ],
        ];
    }
    // public function parent(): ?File
    // {
    //     $parentId = $this->validated('parent_id');
    //     return $parentId ? File::find($parentId) : null;
    // }
}
