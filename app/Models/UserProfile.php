<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $table = 'user_profile'; // Nama tabel di database

    protected $fillable = [
        'user_id',
        'no_hp',
        'tgl_lahir',
        'alamat',
        'profile_image'
    ];

    public $timestamps = false; // Tambahkan ini untuk menonaktifkan timestamps

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
