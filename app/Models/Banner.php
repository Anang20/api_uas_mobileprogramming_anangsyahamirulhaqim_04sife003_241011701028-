<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Storage;

class Banner extends Model
{
    use HasFactory;

    protected $attributes = [
        'is_active' => true,
        'sort_order' => 0,
        'image' => null,
    ];

    protected $fillable = [
        'title',
        'image',
        'description',
        'is_active',
        'sort_order',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getImageUrlAttribute() {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    //Scope untuk banner yang sedang aktif tayang
    public function scopeActive($query) {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')->orWhereDate('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')->orWhereDate('end_date', '>=', now());
            });
    }

    public function hasImage() {
        return !is_null($this->image) && (Storage::disk('public')->exists($this->image));
    }

    public function deleteImage() {
        if($this->hasImage()) {
            Storage::disk('public')->delete($this->image);
            $this->image = null;
            $this->save();
            return true;
        }

        return false;
    }
}
