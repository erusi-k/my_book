<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ILluminate\Support\Facades\Auth;
use App\Models\Book;
use App\Models\User;
use App\Http\Requests\Api\PostRequest;

class BookController extends Controller
{
//mylistのデータ取得    
    public function myData(Request $request){
        $data =  Book::where('user_id',$request->user_id)->paginate(3);
        return response()->json([
            'data'=>$data
        ]);
    }

//homeの自分のデータ取得
    public function newMyData(Request $request) {
        $data = Book::where('user_id',$request->user_id)->latest()->take(5)->get();
        return response()->json([
            'data'=>$data
        ]);
    }

//homeのみんなの投稿ランダム取得
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

//otherlistデータ取得
    public function other(Request $request){
        $datas = Book::where('user_id','<>',$request->user_id)->paginate(3);
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

//投稿新規作成
    public function store(PostRequest $request){
        $file_name  = null;
        if($request->file){
            $file_name = request()->file->getClientOriginalName();
            request()->file->storeAs('public/',$file_name);
        }
        if (!empty($file_name)){
            $request->imge ='/storage/'.$file_name;
        }
        return Book::create([
            'user_id'=>$request->user_id,
            'rating'=>$request->rating,
            'title' => $request->title,
            'imge'=> $request->imge,
            'author' => $request->author,
            'report' => $request->report,
        ]);
    }

//投稿詳細
    public function show($id) {
        $data = Book::find($id);
        $user_name = User::find($data->user_id);
        $data['user_name'] = $user_name->name;  
        return response()->json([
            'data'=>$data
        ]);
    }

//投稿update    
    public function update(Request $request, Book $book) {
        $item = Book::find($request->id);
        $item->update([
            'title' =>$request->title,
            'rating'=>$request->rating,
            'author'=>$request->author,
            'report'=>$request->report,
        ]);
    }

//投稿削除
    public function delete($id) {
        $item = Book::find($id);
        $item->delete();
    }
}
