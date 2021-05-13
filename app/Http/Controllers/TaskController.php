<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;

use App\Exports\TasksExport;
use Maatwebsite\Excel\Facades\Excel;

use Carbon\Carbon;
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

    public function show($id, Request $request)
    {
        $task = Task::find($id);
        $user = $request->user();
        
        if ($this->canAccessTask($task, $user)) {
            return Inertia::render('Tasks/Task', [
                "task" => $task
            ]);;
        } else {
            return Redirect::route('tasks');
        }
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

    public function update($id, Request $request) {
        $task = Task::find($id);
        $user = $request->user();

        $request->validate([
            'name' => 'required|max:255',
            'status' => 'required',
        ]);

        if ($this->canAccessTask($task, $user)) {
            $update = $task->update([
                "name" => $request->name,
                "status" => $request->status,
                "description" => $request->description,
            ]);

            if ($update) {
                return back();
            }
        } else {
            return back();
        }
    }

    public function delete(Request $request)
    {
        $task = Task::find($request->id);
        $user = $request->user();

        if ($task->user_id === $user->id) {
            if (Task::deleteTask($task->id)) {
                Inertia::share('flash', "Successfully Delete Task");
            } else {
                Inertia::share('flash', "Failed to delete task");
            }
        } else {
            Inertia::share('flash', "Invalid Request");
        }

        return back();
    }

    public function trashed(Request $request)
    {
        $user = $request->user();

        $tasks = Task::onlyTrashed()
                ->where("user_id", $user->id)    
                ->get();

        Task::onlyTrashed()
            ->where("user_id", $user->id)
            ->where('deleted_at', '<', Carbon::now()->subDays(30))
            ->forceDelete();

        return Inertia::render('Tasks/TrashedTask', [
            "tasks" => $tasks
        ]);
    }
    

    public function restore(Request $request)
    {
        $task = Task::withTrashed()->find($request->id);
        $user = $request->user();

        if ($task->user_id === $user->id) {
            if ($task->restore()) {
                Inertia::share('flash', "Successfully restore task.");
            } else {
                Inertia::share('flash', "Failed to restore task.");
            }
        } else {
            Inertia::share('flash', "Invalid Request");
        }

        return back();
    }

    public function export(Request $request)
    {
        return Excel::download(new TasksExport, 'tasks.xls');
    }

    private function canAccessTask($task, $user)
    {
        if ($task->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
