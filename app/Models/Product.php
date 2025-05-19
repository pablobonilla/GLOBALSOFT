<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    static $rules = [
        'category_id' => 'required|not_in:0',
        'description' => 'required|string',
        'price' => 'required|decimal:0,9',
        'tax_id' => 'required|int',
        'discount_id' => 'required|int',
        'is_activated' => 'required|not_in:0',
        'photo' => 'file|mimes:jpg,jpeg,png,bmp,gif,svg,webp|max:2048'
    ];

    public $timestamps = true;

    protected $table = 'product';

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['category_id','description','description_large','price','tax_id','discount_id','reference','configurable_product','photo','is_activated','created_by', 'updated_by'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }

    public function tax()
    {
        return $this->hasOne('App\Models\Tax', 'id', 'tax_id');
    }

    public function discount()
    {
        return $this->hasOne('App\Models\Discount', 'id', 'discount_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function garrisons()
    {
        return $this->hasMany('App\Models\Garrison', 'product_id', 'id');
    }

    protected $appends = ['product_id'];
    public function getProductIdAttribute()
    {
        return $this->id;
    }
}
