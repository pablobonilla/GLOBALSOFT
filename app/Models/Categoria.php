<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
	use HasFactory;
	
    static $rules = [
        'description' => 'required|string'
    ];

    public $timestamps = true;

    protected $table = 'category';

    protected $fillable = ['description','is_activated','created_by','updated_by'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products()
    {
        return $this->hasMany('App\Models\Product', 'category_id', 'id');
    }
    
}