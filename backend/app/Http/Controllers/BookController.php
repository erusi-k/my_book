<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ILluminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\User;
use App\Http\Requests\Api\PostRequest;

class BookController extends Controller
{
    public function myData(Request $request){
        $data =  Book::where('user_id',$request->user_id)->latest()->get();
        return response()->json([
            'data'=>$data
        ]);
    }

    public function newMyData(Request $request) {
        $data = Book::where('user_id',$request->user_id)->latest()->take(5)->get();
        return response()->json([
            'data'=>$data
        ]);

    }

    public function otherRandom(Request $request) {
        $datas = Book::where('user_id','<>',$request->user_id)->inRandomOrder()->take(9)->get();
        $i =0;
        foreach($datas as $data){
            $user_name = User::find($data->user_id);
            $datas[$i]['user_name'] = $user_name->name;  
            $i++;
            }
        return response()->json([
            'data'=>$datas
        ]);
    }

    public function other(Request $request){
        $datas = Book::where('user_id','<>',$request->user_id)->latest()->get();
        $i =0;
        foreach($datas as $data){
            $user_name = User::find($data->user_id);
            $datas[$i]['user_name'] = $user_name->name;  
            $i++;
            }
        return response()->json([
            'data'=>$datas
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
        $user_name = User::find($data->user_id);
        $data['user_name'] = $user_name->name;  
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
            'report'=>$request->report,
        ]);

    }

    public function delete($id) {
        
        $item = Book::find($id);
        $item->delete();

    }
}
