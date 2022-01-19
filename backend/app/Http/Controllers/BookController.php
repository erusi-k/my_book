<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ILluminate\Support\Facades\Auth;
use App\Models\Book;
use App\Http\Requests\Api\PostRequest;

class BookController extends Controller
{
    public function myData(Request $request){
        $data =  Book::where('user_id',$request->user_id)->get();
        return response()->json([
            'data'=>$data
        ]);
    }

    public function otherRandom(Request $request) {
        $data = Book::where('user_id','<>',$request->user_id)->inRandomOrder()->take(9)->get();
        return response()->json([
            'data'=>$data
        ]);
    }

    public function other(Request $request){
        $data = Book::where('user_id','<>',$request->user_id)->get();
        return response()->json([
            'data'=>$data
        ]);
    }

    public function store(PostRequest $request){
        $id = Auth::id();
        return Book::create([
            'user_id' =>$request->user_id,
            'rating'=>$request->rating,
            'title' => $request->title,
            'imge'=> $request->imge,
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

    }

    public function delete($id) {
        
        $item = Book::find($id);
        $item->delete();

    }
}
