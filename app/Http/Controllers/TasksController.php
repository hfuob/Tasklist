<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;    // 追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $task = Task::all();
        if (\Auth::check()) {
            $user = \Auth::user();
            $task = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
//            return view('tasks.index', $task);
            return view('tasks.index', [
                'tasks' => $task,
            ]);
//            return view('tasks.index');
        }else {
            return view('welcome');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $task = new Task;
        if (\Auth::check()) {
            $user = \Auth::user();
            $task = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'tasks' => $task, // xxx.blade.php では、「'keyword'」が$keywordになる
            ];
                $data['tasks']; // $tasks の値を取得できる
            return view('tasks.create', [
            'task' => $task,
        ]);
            
//            return view('tasks.index');
        }else {
        
            return view('tasks.create', [
            'task' => $task,
        ]);
            return view('welcome');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:10',
            'status' => 'required|max:10',
        ]);
        
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);

        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
            
//            return view('tasks.index');
        }else {
            return redirect('/');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = Task::find($id);
        //dd($task);
        if (\Auth::id() === $task->user_id) {
            
            return view('tasks.edit', [
                'task' => $task,
            ]);
            
//            return view('tasks.index');
        } else {
            return redirect('/');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if (\Auth::id() === $task->user_id) {
            $this->validate($request, [
            'content' => 'required|max:10',
            'status' => 'required|max:10',
            ]);

            $user = \Auth::user();
            $task->content = $request->content;
            $task->status = $request->status;
            $task->save();
            
            return redirect('/');
        
        }else {
            return redirect('/');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = \App\Task::find($id);
        if (\Auth::id() === $task->user_id) {
            $task->delete();
            return redirect('/');
            
//            return view('tasks.index');
        }else {
            return redirect('/');
        }
            
    }
}
