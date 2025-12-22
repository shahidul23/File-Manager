<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreFolderRequest;
use App\Http\Requests\StoreFileRequest;
use App\Models\File;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\FileResource;
use Inertia\Inertia;

class FileController extends Controller
{
    public function myFiles(string $folder = null)
    {
        if ($folder) {
            $folder = File::query()
                ->where('path', $folder)
                ->where('created_by', Auth::id())
                ->firstOrFail();
        }
        
        if (!isset($folder)) {
            $folder = $this->getRoot();
        }
        $files = File::query()
            ->where('parent_id', $folder->id)
            ->where('created_by', Auth::id())
            ->orderBy('is_folder', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

            $files = FileResource::collection($files);
            $ancestors = FileResource::collection([...$folder->ancestors, $folder]);
            $folder = new FileResource($folder);

        return Inertia::render('MyFiles', compact('files', 'folder', 'ancestors'));
    }

    public function createFolder(StoreFolderRequest $request)
    {
        $data = $request->validated();
        $parent = $request->parent;

        if(!$parent){
            $parent = $this->getRoot();
        }
        $folder = new File();
        $folder->name = $data['name'];
        $folder->is_folder = 1;
        $folder->created_by = Auth::id();

        if ($parent) {
            $parent->appendNode($folder);
        } else {
            $folder->saveAsRoot();
        }

    }

    public function uploadFiles(StoreFileRequest $request)
    {
        $data = $request->validated();
        $parent = $request->parent;
        $user = $request->user();
        $fileTree = $request->file_tree;

        if (!$parent) {
            $parent = $this->getRoot();
        }
        if (!empty($fileTree)) {
            $this->processFileTree($fileTree, $parent, $user);
        }else {
            foreach ($data['files'] as $uploadedFile) {
                $path = $uploadedFile->store('/files/' . $user->id);
                $file = new File();
                $file->storage_path = $path;
                $file->is_folder = false;
                $file->name = $uploadedFile->getClientOriginalName(); 
                $file->size = $uploadedFile->getSize();
                $file->mime = $uploadedFile->getMimeType();
                $parent->appendNode($file);
            }
        }

       
    }

    private function getRoot()
    {
        return File::query()
            ->whereIsRoot()
            ->where('created_by', Auth::id())
            ->firstOrFail();
    }
    private function processFileTree(array $fileTree, $parent, $user)
    {
        foreach ($fileTree as $name => $item) {
            if (is_array($item)) {
                $folder = new File();
                $folder->name = $name;
                $folder->is_folder = 1;
                $parent->appendNode($folder);
                $this->processFileTree($item, $folder, $user);
            } else {
                $uploadedFile = $item;
                $file = new File();
                $file->name = $uploadedFile->getClientOriginalName();
                $file->is_folder = 0;
                $file->size = $uploadedFile->getSize();
                $file->mime = $uploadedFile->getMimeType();
                $parent->appendNode($file);
                $path = $uploadedFile->store('/files/' . $user->id);
                $file->storage_path = $path;
            }  
        }  
    }
}
