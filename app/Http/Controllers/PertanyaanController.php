<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Answer;
use App\Question;

class PertanyaanController extends Controller
{
    public function index()
    {
        $question = Question::orderBy('created_at','desc')->get();
        $question1 = question::get();
        $answer1 = answer::get();
        $user1 = User:: get();

        $user = [];
        foreach($user1 as $use){
            $tampungan = 0;
            foreach($use->question as $quest){
                $up = $quest->votePertanyaan->where('vote','up')->count();
                $down = $quest->votePertanyaan->where('vote','down')->count();
                $tampungan += ($up * 10)-$down;
            }

            foreach($use->answer as $reply){
            
                $up = $reply->voteJawaban->where('vote','up')->count();
                $down = $reply->voteJawaban->where('vote','down')->count();
                $tampungan += ($up * 10) - $down;
            }
            //dd($tampungan);
            $user[$use->id] = $tampungan;
            //dd($rep);
        }

        $question = [];
        foreach($question1 as $question){
            
            $up = $answer->voteJawaban->where('vote','up')->count();
            $down = $answer->voteJawaban->where('vote','down')->count();
            $rep = ($up) - ($down);
            $answe[$reply->id] = $rep;
        }

        $question = [];
        foreach($question1 as $quest){
            
            $up = $quest->votePertanyaan->where('vote','up')->count();
            $down = $quest->votePertanyaan->where('vote','down')->count();
            $rep = ($up) - ($down);
            $question[$quest->id] = $rep;
        }
        
        $vote[] = $question;
        $vote[] = $answer;
        $vote[] = $user;

        //dd($vote);

        return view('pertanyaan.index',compact('pertanyaan','vote'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:160',
            'isi' => 'required|max:255',
        ]);
        
        $tag = $request->tags;
        $tags = explode(",", $tag);
        $tag_ids = [];

        foreach($tags as $t){
            $ta = tag::firstOrCreate(['tag_name' => $t]);
            if($t != "")$tag_ids[] = $ta->id;
        }

        $question = question::create([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'user_id' => Auth::id()
        ]);

        $question->tag()->sync($tag_ids);
        
        $user = User::find(Auth::id());
        $user->pertanyaan()->save($question);

        return redirect('/pertanyaan')->with('berhasil','Data Berhasil Ditambahkan!');
    }

    public function show($id)
    { 
        $question = question::find($id);
        $answer1 = answer::get();
        $user1 = User:: get();

        $user = [];
        foreach($user1 as $use){
            $tampungan = 0;
            foreach($use->question as $quest){
                $up = $quest->votePertanyaan->where('vote','up')->count();
                $down = $quest->votePertanyaan->where('vote','down')->count();
                $tampungan += ($up * 10)-$down;
            }

            foreach($use->answer as $reply){
            
                $up = $reply->voteJawaban->where('vote','up')->count();
                $down = $reply->voteJawaban->where('vote','down')->count();
                $tampungan += ($up * 10) - $down;
            }
            //dd($tampungan);
            $user[$use->id] = $tampungan;
            //dd($rep);
        }

        $answer = [];
        foreach($answer1 as $reply){
            
            $up = $reply->voteJawaban->where('vote','up')->count();
            $down = $reply->voteJawaban->where('vote','down')->count();
            $rep = ($up) - ($down);
            $answer[$reply->id] = $rep;
        }

        $up = $question->votePertanyaan->where('vote','up')->count();
        $down = $question->votePertanyaan->where('vote','down')->count();
        $rep = ($up) - ($down);
        $question = $rep;
 
        
        $vote['question'] = $question;
        $vote['answer'] = $answer;
        $vote['user'] = $user;
        return view('pertanyaan.show',compact('questions','vote'));
    }

    public function edit($id)
    {
        $question = question::where('id', $id)->first();
        return view('pertanyaan.edit', compact('question'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'judul' => 'required|max:160',
            'isi' => 'required|max:255',
        ]);
        
        $tag = $request->tags;
        $tags = explode(",", $tag);
        $tag_ids = [];

        foreach($tags as $t){
            $ta = tag::firstOrCreate(['tag_name' => $t]);
            if($t != "")$tag_ids[] = $ta->id;
        }

        $quest = question::where('id',$id)
            ->update([
            'judul' => $request->judul,
            'isi' => $request->isi,
            'user_id' => Auth::id()
        ]);
        
        $question = question::find($id);
        
        $question->tag()->sync($tag_ids);
        $user = User::find(Auth::id());
        $user->pertanyaan()->save($question);

        return redirect('/pertanyaan')->with('berhasil','Data Berhasil Diubah!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $del= pertanyaan::destroy($id);
        
        return redirect('/pertanyaan')->with('berhasil','Data Berhasil Dihapus!');
    }
}
