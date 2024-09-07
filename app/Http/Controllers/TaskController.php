<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    //

    public function index(Request $request)
    {// dd($request->all());
        $tasks = Task::all();
        if($request->ajax()){
           
            return response()->json($tasks);
        }else{
           // dd("Sdfd");
            return view('welcome',compact('tasks'));
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'task' => 'required|string|max:255|unique:tasks,task'
            ]);

            Task::create([
                'task' => $request->task
            ]);
            return response()->json(['success' => true]);
        }catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, Task $task)
    {
      
        try {
            Task::where('id', $request->taskId)
            ->update(['completed' => 1]);
            return response()->json(['success' => true,'msg'=>"Task mark completed Successfully"]);
        }catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);
        }
    }

    public function destroy(Task $task)
    {
        try {
            $task->delete();
            return response()->json(['success' => true,'msg'=>"Task Deleted Successfully"]);
        }catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage()]);
        }
    }
}
