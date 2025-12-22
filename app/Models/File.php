<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Kalnoy\Nestedset\NodeTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Str;
use App\Traits\HasCreatorAndUpdator;

class File extends Model
{
    use HasFactory, NodeTrait, SoftDeletes, HasCreatorAndUpdator;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }  
    public function parent(): BelongsTo
    {
        return $this->belongsTo(File::class, 'parent_id');
    } 
    public function owner(): Attribute
    {
        return Attribute::make(
            get: function (mixed $value, array $attributes) {
                return $attributes['created_by'] === Auth::id() ? 'You' : $this->user->name;

            }
        );
    }
    public function isOwnedBy($userId): bool
    {
        return $this->created_by == $userId;
    }
    public function is_root(): bool
    {
        return $this->parent_id === null;
    }

    public function get_file_size(): string
    {
        $size = $this->size;
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $power = $size > 0 ? floor(log($size, 1024)) : 0;
        return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power]; 
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->parent){
                return;
            }
            $model->path = (!$model->parent->is_root() ? $model->parent->path . '/' : '') . Str::slug($model->name);
        });
    }
    
}
