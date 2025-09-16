<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrowing;
use App\Models\Book;
use App\Models\User;

class BookController extends Controller
{
  

public function index(Request $request)
{
    $books = Book::query();

    // Filter pencarian dinamis
    if ($request->has('search') && $request->filled('search')) {
        $filterBy = $request->get('filter_by', 'title');
        $search = $request->get('search');

        if (in_array($filterBy, ['title', 'author', 'isbn', 'publisher', 'year'])) {
            $books->where($filterBy, 'like', '%' . $search . '%');
        }
    }

    // Pagination hasil
    $books = $books->paginate(10);

    // Data pengembalian yang diminta user
    $borrowings = Borrowing::with(['book', 'user'])
        ->where('status', 'return_requested')
        ->latest()
        ->get();

    return view('books.index', compact('books', 'borrowings'));
}


    public function create()
    {
        return view('books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'publisher' => 'required',
            'year' => 'required|integer',
            'isbn' => 'required|unique:books',
            'stock' => 'required|integer',
        ]);

        Book::create($request->all());

        return redirect()->route('books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function edit(Book $book)
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'required|string|max:255',
            'year' => 'required|integer',
            'isbn' => 'required|string|max:20',
            'stock' => 'required|integer',
        ]);
    
        $book->update([
            'title' => $request->title,
            'author' => $request->author,
            'publisher' => $request->publisher,
            'year' => $request->year,
            'isbn' => $request->isbn,
            'stock' => $request->stock,
        ]);
    
        return response()->json(['success' => 'Buku berhasil diperbarui']);
        
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('books.index')->with('success', 'Buku berhasil dihapus!');
    }

    
}
