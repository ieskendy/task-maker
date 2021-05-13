<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Redirect;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $tasks = $request->user()->tasks;
        return Inertia::render('Task', [
            "tasks" => $tasks
        ]);
    }

    public function create()
    {
        return Inertia::render('Tasks/CreateTask');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'name' => 'required|max:255',
        ]);

        $task = $user->tasks()->create([
            "name" => $request->name,
            "description" => $request->description,
            "status" => "pending"
        ]);
        
        if ($task) {
            return Redirect::route('tasks');
        }

        Inertia::share('flash', "Failed to create task");
    }
}
