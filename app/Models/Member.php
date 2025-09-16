<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'library_id',
        'name',
        'no_hp',
        'profile_image',
        'member_number',
        'membership_status',
        'registered_at',
    ];
    

    public function borrowings()
    {
        return $this->hasMany(Borrowing::class);
    }

    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function library()
{
    return $this->belongsTo(Admin::class, 'library_id');
}

// app/Models/Member.php
protected $casts = [
    'registered_at' => 'datetime',
];

}
