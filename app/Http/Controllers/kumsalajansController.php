<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class kumsalajansController extends Controller
{
    public function index() {
        return view('show');
    }

    public function getTasks() {
        $tasks = Task::all();
        return view('getTasks')->with('tasks', $tasks);
    }

    public function addTask(Request $request) {
        $task = new Task();

        $task->name = $request->taskName;
        $task->password = $request->taskPassword;
        $task->point = $request->taskPoint;

        $task->save();

        if($task){
            return 1;
        }else{
            return 0;
        }
    }

    public function deleteTask(Request $request) {
        $task=Task::find($request->taskId);
        $task->delete();

        return $task;
    }

    public function editTask(Request $request) {
        $task = Task::find($request->currentId);
        $task->name = $request->name;
        $task->password = $request->password;
        $task->point = $request->point;
        $task->save(); 
    }

    public function searchTask(Request $request) {
        $keyWord = $request->searchWord;
        $tasks = Task::where('name', 'LIKE', '%' . $keyWord . '%' )->get(); 
        if($tasks){
            return view('getTasks')->with('tasks', $tasks);
        }
        return 'Something went wrong';
    }
}
