<?php

namespace Tests\Fixtures\Models;

use Illuminate\Database\Eloquent\Model;
use Titantwentyone\FilamentContentComponents\Concerns\HasContent;

class Page extends Model
{
    use HasContent;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'text'
    ];

    public $casts = [
        'content' => 'array',
        'text' => 'array'
    ];
}