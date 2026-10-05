<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Admin extends Model
{
    use HasFactory;

    protected $table = 'admins';

    protected $fillable = [
        'user_id',
        'admin_code',
        'first_name',
        'last_name',
        'phone',
        'department',
        'position',
        'status',
    ];

    /**
     * Keeps the pre-existing API response key `admin_id` (the admin code).
     * The database column itself is `admin_code`.
     */
    protected $appends = ['admin_id'];

    protected function adminId(): Attribute
    {
        return Attribute::get(fn () => $this->admin_code);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}