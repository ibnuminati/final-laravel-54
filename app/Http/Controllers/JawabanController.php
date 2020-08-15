<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Question;

class JawabanController extends Controller
{
    public function create($id)
    {
        $question = Pertanyaan::find($id);
        return view('jawaban.create',compact('question'));
    }

    public function store(Request $request, $id)
    {
        $answer = Jawaban::create([
            'answer' => $request->answer,
            'user_id' => Auth::id(),
            'pertanyaan_id' => $id
        ]); 
        return redirect("/pertanyaan/$id")->with('berhasil','Jawaban Berhasil Ditambahkan!');
    }

    public function edit($id)
    {
        $answer = Jawaban::find($id);
        return view('jawaban.edit', compact('answer'));
    }

    public function update(Request $request,$id)
    {
        $answer = Jawaban::where('id',$id)
        -> update([
            'answer' => $request -> answer,
        ]);

        $answer = Jawaban::find($id);
        return redirect("/pertanyaan/$answer->pertanyaan_id") -> with('Success','Jawaban telah di edit');
    }

    public function destroy($id)
    {
        $answer = Jawaban::find($id);
        $answer = Jawaban::destroy($id);
        return redirect("/pertanyaan/$answer->pertanyaan_id")->with('berhasil','Jawaban Anda Berhasil Dihapus!');
    }
}
