<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::all();
        return view('tasks.index', compact('tasks'));
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    // Add other CRUD methods inside this SAME class block...
}