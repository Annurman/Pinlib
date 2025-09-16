<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    use HasFactory;

    protected $table = 'admin_profile'; // Pastikan sesuai dengan database

    protected $fillable = [
        'admin_id',
        'library_name',
        'library_address',
        'phone_number',
        'profile_image',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    
}
