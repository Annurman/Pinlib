<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'book_id', 'member_id', 'library_id','borrowed_at', 'due_date', 'returned_at', 'status'];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_date' => 'datetime',
        'returned_at' => 'datetime',
    ];
    
    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function member()
{
    return $this->belongsTo(Member::class, 'member_id');
}

public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}

public function library()
{
    return $this->belongsTo(AdminProfile::class);
}




}
