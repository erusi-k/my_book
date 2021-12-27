<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ILluminate\Support\Facades\Auth;
use App\Models\Book;

class BookController extends Controller
{
    public function index(){
        $data =  Book::all();
        return response()->json([
            'data'=>$data
        ]);
    }

    public function store(Request $request){
        $id = Auth::id();
        return Book::create([
            'user_id' =>$request->user_id,
            'rating'=>$request->rating,
            'title' => $request->title,
            'author' => $request->author,
            'report' => $request->report
            
        ]);
    }

    public function show($id) {
    $data = Book::find($id);
        return response()->json([
            'data'=>$data
        ]);
    }

    public function update(Request $request, Book $book) {
        $item = Book::find($request->id);
        $item->update([
            'title' =>$request->title,
            'rating'=>$request->rating,
            'author'=>$request->author,
        ]);
        return $book;
    }

    
}
