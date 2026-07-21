<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    protected $fillable = ['category_id', 'seller', 'brand', 'name', 'slug', 'hsn_code', 'repurchase_distribution', 'mrp', 'retail_price', 'refund_days', 'image', 'gallery_images', 'product_section', 'has_variants', 'short_description', 'refund_description', 'full_description', 'is_active'];

    protected function casts(): array
    {
        return ['gallery_images' => 'array', 'has_variants' => 'boolean', 'is_active' => 'boolean', 'mrp' => 'decimal:2', 'retail_price' => 'decimal:2', 'repurchase_distribution' => 'decimal:2'];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
