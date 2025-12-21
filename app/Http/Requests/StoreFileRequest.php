<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFileRequest extends ParentIdBaseRequest
{
    protected function prepareForValidation(): void
    {
        $paths = array_filter($this->relative_paths ?? [], fn($path) => !empty($path));
        $this->merge([
            'file_paths' => $paths,
            'folder_name' => $this->detectFolderName($paths),
        ]);
    }
    protected function passedValidation(): void
    {
        $data = $this->validated();
        $this->replace([
            'file_tree' => $this->buildFileTree($this->file_paths, $data['files']),
        ]);
    }
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return array_merge( parent::rules(), [
            'files.*' =>[
                'required',
                'file',
                function ($attribute, $value, $fail) {
                    if(!$this->folder_name)
                    {
                        $parent = $this->parent_id;
                        $fileName = $value->getClientOriginalName();

                        $exists = \App\Models\File::query()
                            ->where('name', $fileName)
                            ->where('parent_id', $parent ? $parent : null)
                            ->where('created_by', \Illuminate\Support\Facades\Auth::id())
                            ->whereNull('deleted_at')
                            ->exists();

                        if ($exists) {
                            $fail("A file with the name '{$fileName}' already exists in the selected location.");
                        }
                    }
                }
            ],
            'folder_name' => [
                'nullable',
                'string',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        $parent = $this->parent_id;
                        $exists = \App\Models\File::query()
                            ->where('name', $value)
                            ->where('is_folder', 1)
                            ->where('parent_id', $parent ? $parent : null)
                            ->where('created_by', \Illuminate\Support\Facades\Auth::id())
                            ->whereNull('deleted_at')
                            ->exists();

                        if ($exists) {
                            $fail("A folder with the name '{$value}' already exists in the selected location.");
                        }
                    }
                }
            ],
        ]);
    }
    public function detectFolderName(array $paths): ?string
    {
        $firstPath = reset($paths);
        if ($firstPath) {
            $parts = explode('/', $firstPath);
            if (count($parts) > 1) {
                return $parts[0];
            }
        }
        return null;
    }
    public function buildFileTree(array $paths, array $files): array
    {
        dd( $paths, $files);
        // $tree = [];
        // foreach ($paths as $index => $path) {
        //     $parts = explode('/', $path);
        //     $current = &$tree;
        //     foreach ($parts as $part) {
        //         if (!isset($current[$part])) {
        //             $current[$part] = [];
        //         }
        //         $current = &$current[$part];
        //     }
        //     $current['_file'] = $files[$index];
        // }
        // return $tree;
    }
}
