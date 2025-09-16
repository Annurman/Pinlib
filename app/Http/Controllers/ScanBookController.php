<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use thiagoalessio\TesseractOCR\TesseractOCR;

class ScanBookController extends Controller
{
    public function scan(Request $request)
    {
        // Decode Base64 ke file gambar
        $imageData = $request->input('image');
        $imageData = str_replace('data:image/png;base64,', '', $imageData);
        $imageData = base64_decode($imageData);
        
        // Simpan gambar sementara
        $filePath = storage_path('app/public/scanned.png');
        file_put_contents($filePath, $imageData);

        // Jalankan OCR
        $text = (new TesseractOCR($filePath))
            ->digits() // Hanya ambil angka
            ->run();

        // Bersihkan hasil OCR dan hanya ambil angka
        preg_match('/\d{13}/', $text, $matches);
        $bookId = $matches[0] ?? null;

        if (!$bookId) {
            return response()->json(['error' => 'Kode buku tidak valid!'], 422);
        }

        return response()->json([
            'book_id' => $bookId
        ]);
    }
}
