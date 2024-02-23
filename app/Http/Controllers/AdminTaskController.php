<?php

// app/Http/Controllers/AdminTaskController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AdminTaskController extends Controller
{
    public function index()
    {
        $admintasks = auth()->user()->admintasks;
        return $admintasks;
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
    // public function gettotalTasksAssignedByAdmin(User $user)
    // {
    //     $user->admintasks()->count();
    //     $totalTasks = Task::where('admin_id', $user->id)->count();
    //     return response()->json(['total_tasks_assigned' => $totalTasks]);
    // }
    public function assignTaskTouser(Request $request, User $user)
    {
        $task = Validator::make($request->all(), [
            'title' => 'required|min:10',
            'description' => 'sometimes',
            'deadline' => 'required|date',
        ]);

        if ($task->fails()) {
            return response()->json(['errors' => $task->errors()], 400);
        }
        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->deadline = $request->deadline;
        $task->admin_id = auth()->user()->id;
        $task->user_id = $user->id;
        $task->save();
        return response()->json(['message' => 'Task assigned successfully']);
    }

    // public function deleteUser(User $user)
    // {
    //     $user->delete();
    //     return response()->json(['message' => 'User deleted successfully']);
    // }
}
