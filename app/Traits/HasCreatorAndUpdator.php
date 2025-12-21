<?php
namespace App\Traits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;




trait HasCreatorAndUpdator
{
    public static function bootHasCreatorAndUpdator()
    {
        static::creating(function ($model) {
            if (auth()->check()) {
                $model->created_by = Auth::id();
                $model->uploaded_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (auth()->check()) {
                $model->uploaded_by = Auth::id();
            }
        });
    }
}