<?php

namespace App\Http\Controllers;

use App\Diary;
use App\User;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
use App\Http\Requests\CreateDiary;

class DiaryController extends Controller
{
    public function index() {
        // $diaries = Diary::all();
        $diaries = Diary::orderBy('id', 'desc')->get();
        // $diary = Auth::user()->diaries->first()->title;
        // $aa = User::find(4)->diaries;
        // $a = Diary::find(1)->user->name;
        $a = Auth::user();
        // dd($a);
        // dd($diaries);
        // return view('diaries.index', ['diaries' => $diaries]);
        return view('diaries.index', compact('diaries'));
        // return view('diaries.index', 'diaries');
    }
    public function create() {
        return view('diaries.create');
    }
    public function store(CreateDiary $request) {
        $diary = new Diary();
        $diary->title = $request->title;
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->user_id = Auth::user()->id; //追加 ログインしてるユーザーのidを保存
        $diary->save(); //DBに保存

        return redirect()->route('diary.index');
    }
    public function destroy($id) {
        $diary = Diary::find($id);
        $diary->delete();

        return redirect()->route('diary.index');
    }
    public function edit($id)
    {
        //Diaryモデルを使用して、diariesテーブルから$idと一致するidをもつデータを取得
        $diary = Diary::find($id);

        return view('diaries.edit', [
            'diary' => $diary,
        ]);
    }
    public function update(int $id, CreateDiary $request)
    {
        $diary = Diary::find($id);

        $diary->title = $request->title; //画面で入力されたタイトルを代入
        $diary->body = $request->body; //画面で入力された本文を代入
        $diary->save(); //DBに保存

        return redirect()->route('diary.index'); //一覧ページにリダイレクト
    }
}
