<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Book;
use Illuminate\Support\Facades\Log;

Route::get('/books/{isbn}', function ($isbn) {
    Log::info("API diakses dengan ISBN: $isbn"); // Tambah log ke laravel.log

    $book = \App\Models\Book::where('isbn', $isbn)->first();

    if (!$book) {
        return response()->json(['message' => 'Buku tidak ditemukan'], 404);
    }

    return response()->json($book);
});

Route::get('/test', function () {
    return 'API Test OK';
});