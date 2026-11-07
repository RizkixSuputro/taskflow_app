<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;


#[Fillable([
    'category_id',
    'title',
    'description',
    'due_date',
    'priority',
    'status',
])]

class Task extends Model
{
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    protected function casts(): array
    {
        return [
            'due_date' => 'date',
        ];
    }

    protected function isOverdue(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->due_date->lt(today())
                && $this->status !== 'done',
        );
    }

    #[Scope]
    protected function overdue(Builder $query): void
    {
        $query->where('due_date', '<', today())
            ->where('status', '!=', 'done');
    }
}
