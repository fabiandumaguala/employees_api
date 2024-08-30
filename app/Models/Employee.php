<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'position',
        'salary',
    ];

    public function scopeSearch($query, $search){
		return $query->where('name', 'LIKE', "%$search%")
			->orWhere('email', 'LIKE', "%$search%")
			->orWhere('position', 'LIKE', "%$search%")
			->orWhere('salary', 'LIKE', "%$search%");
	}
}
