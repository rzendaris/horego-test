<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Organization extends Model
{
    use HasFactory;

    protected $table = 'organizations';
    protected $fillable = ['name', 'phone', 'email', 'website', 'logo', 'account_manager_id', 'status'];

    public function account_manager(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'account_manager_id');
    }

    public function persons(): HasMany
    {
        return $this->hasMany(Person::class, 'organization_id');
    }
}
