<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Http\Requests\MakeRequest;
use App\Http\Requests\UpdateRequest;
use App\Models\question_answer;
use App\Models\title;
use Illuminate\Http\Request;

class HomeController extends Controller
{
  public function home()
  {
    // titleを取得
    $titles = title::select('titles.*')
      ->where('user_id', '=', \Auth::id())
      ->whereNull('deleted_at')
      ->orderBy('updated_at', 'DESC')
      ->get();

    return view('home', compact('titles'));
  }

  public function insert(CreateRequest $request)
  {
    $posts = $request->all();
    unset($posts['_token']);
    title::insert(['title' => $posts['title'], 'user_id' => \Auth::id()]);

    return redirect(route('home'));
  }

  public function create()
  {
    return view('create');
  }

  public function add($id)
  {
    $add_title = title::find($id);
    return view('add', compact('add_title'));
  }

  public function make(MakeRequest $request)
  {
    $QA = $request->all();
    unset($QA['_token']);
    // dd($QA);
    question_answer::insert(['question' => $QA['question'], 'answer' => $QA['answer'], 'title_id' => $QA['titleID'], 'user_id' => \Auth::id()]);

    return back();
  }

  public function questionlists(Request $request, $id)
  {
    $title = title::find($id);
    if (isset($title)) {
      $question_answers = question_answer::select('question_answers.*')
        ->where('user_id', '=', \Auth::id())
        ->where('title_id', '=', $title['id'])
        ->whereNull('deleted_at')
        ->orderBy('updated_at', 'DESC')
        ->get();
    } else {
      $id = $request->id;
      $question_answers = question_answer::select('question_answers.*')
        ->where('user_id', '=', \Auth::id())
        ->where('title_id', '=', $id)
        ->whereNull('deleted_at')
        ->orderBy('updated_at', 'DESC')
        ->get();
    }

    return view('questionlists', compact('title', 'question_answers'));
  }

  public function edit($id)
  {
    $question_answer = question_answer::find($id);
    return view('edit', compact('question_answer'));
  }

  public function update(UpdateRequest $request)
  {
    $QAID = question_answer::find($request->QAID);
    $titleID = $request->titleID;
    $QAID->fill($request->all())->save();
    // dd($QAID);
    return redirect()->action([HomeController::class, 'questionlists'], ['id' => $titleID]);
  }

  public function delete(Request $request)
  {
    title::find($request->titleID)->delete();
    return back();
  }

  public function questions($id)
  {
    $edit_title = title::find($id);
    $question_answers = question_answer::select('question_answers.*')
      ->where('user_id', '=', \Auth::id())
      ->whereNull('deleted_at')
      ->orderBy('updated_at', 'DESC')
      ->get();

    return view('questions', compact('question_answers', 'edit_title'));
  }
}
