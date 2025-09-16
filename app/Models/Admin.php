<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\user as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
       
    ];

    


    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
   
     public function adminProfile()
     {
         return $this->hasOne(AdminProfile::class, 'admin_id'); // Pastikan nama model dan kolomnya sesuai
     }
  
     public function profile()
     {
         return $this->hasOne(\App\Models\AdminProfile::class);
     }
     





}
