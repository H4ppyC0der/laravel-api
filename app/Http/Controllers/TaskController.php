<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;

class TaskController extends Controller
{
    /**
     * Display all data.
     */
    public function index()
    {
        return Task::all();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|string|unique:tasks,email',
            'task_name' => 'required',
            'description' => 'required',
            'is_completed' => 'required'

        ]) ;
        return Task::create($request->all());
    }

    /**
     * Display specific Task.
     */
    public function show($id)
    {
        // $tasks = Task::all();

        // foreach($tasks as $task) {
        //     if($task['id'] == $id){
        //         return $task;
        //     }
        // }
        // return 'Not found';
        $task = Task::find($id);
        if(!$task) {
            return response()->json([
                'message' => "Task " .$id. " doesn't exists."
            ]);
        }
        return $task;


    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $task = Task::find($id);
        if(!$task) {
            return response()->json([
                'message' => "Task " .$id. " doesn't exists."
            ]);
        }
        $task->update($request->all());
        return response()->json([
            'message' => 'Task ' .$id. ' has been updated!'
        ]);
    }

    /**
     * Delete specific task from the database.
     */
    public function destroy(Task $task, $id)
    {
        $task = Task::find($id);
        if(!$task) {
            return response()->json([
                'message' => 'Task ' .$id. ' no longer exists.'
            ]);

        };
        
        Task::destroy($id);
        return response()->json([
            'message' => 'Task ' . $id . ' was deleted.'
        ]);
    }

    public function search($name){

        $task = Task::where('username', 'like', '%' . $name . '%')->get();
        if(count($task) === 0) {
            return response()->json([
                'message' => 'No result for ' .$name. '.'
            ]);

        };


        return $task;
    }
}
