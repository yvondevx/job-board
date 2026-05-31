<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $table = 'job_listings';

    protected $fillable = [
        'external_id',
        'category_id',
        'subcategory_id',
        'author_id',
        'title',
        'slug',
        'description',
        'location',
        'suburb',
        'price_offer',
        'type',
        'status',
        'photos',
        'meta',
    ];

    protected $casts = [
        'photos'      => 'array',
        'meta'        => 'array',
        'price_offer' => 'decimal:2',
    ];
}
