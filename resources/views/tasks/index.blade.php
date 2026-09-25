<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-100 min-h-screen font-sans antialiased">
    <!-- Navbar / Header -->
    <nav class="bg-indigo-600 shadow-lg text-white py-4 px-8 mb-8 flex justify-between items-center">
        <div class="flex items-center space-x-2">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            <h1 class="text-xl font-bold tracking-wide">Personal Task Manager</h1>
        </div>
        <span class="text-indigo-200 text-sm font-medium">WST21-PM-2026-SF</span>
    </nav>

    <div class="max-w-4xl mx-auto px-4 pb-12">
        <!-- Success Alert -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 rounded-r shadow-sm flex items-center justify-between">
                <span class="font-medium">{{ session('success') }}</span>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 font-bold">&times;</button>
            </div>
        @endif

        <!-- Create Task Card -->
        <div class="bg-white rounded-xl shadow-md border border-slate-200/80 p-6 mb-8">
            <h2 class="text-lg font-bold text-slate-800 mb-4 flex items-center gap-2">
                <span class="w-2.5 h-2.5 bg-indigo-600 rounded-full"></span> Add New Task
            </h2>
            <form action="{{ route('tasks.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="md:col-span-2">
                        <input type="text" name="task_name" placeholder="Task Name *" required 
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none">
                    </div>
                    <div>
                        <input type="date" name="due_date" 
                            class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all text-slate-600 outline-none">
                    </div>
                </div>
                <div>
                    <textarea name="description" placeholder="Task details or notes (optional)..." rows="2"
                        class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all outline-none"></textarea>
                </div>
                <div class="text-right">
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 active:bg-indigo-800 text-white font-semibold px-6 py-2.5 rounded-lg shadow-md hover:shadow-indigo-200 transition-all duration-200">
                        + Save Task
                    </button>
                </div>
            </form>
        </div>

        <!-- Task List -->
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-slate-800">Your Tasks</h2>
            <span class="bg-indigo-100 text-indigo-700 text-xs font-semibold px-3 py-1 rounded-full">Total: {{ $tasks->count() }}</span>
        </div>

        <div class="space-y-3">
            @forelse($tasks as $task)
                <div class="bg-white rounded-xl p-5 border border-slate-200/80 shadow-sm hover:shadow-md transition-all flex flex-col md:flex-row md:items-center justify-between gap-4 {{ $task->status === 'Completed' ? 'bg-slate-50 opacity-80' : '' }}">
                    <div class="flex-1 space-y-1">
                        <div class="flex items-center gap-3">
                            <h3 class="font-bold text-slate-800 text-lg {{ $task->status === 'Completed' ? 'line-through text-slate-400' : '' }}">
                                {{ $task->task_name }}
                            </h3>
                            <span class="px-2.5 py-0.5 text-xs font-semibold rounded-full border {{ $task->status === 'Completed' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 'bg-amber-100 text-amber-800 border-amber-200' }}">
                                {{ $task->status }}
                            </span>
                        </div>
                        @if($task->description)
                            <p class="text-slate-600 text-sm {{ $task->status === 'Completed' ? 'line-through text-slate-400' : '' }}">{{ $task->description }}</p>
                        @endif
                        <div class="flex items-center gap-2 text-xs text-slate-400 pt-1">
                            <span>📅 Due: {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No deadline' }}</span>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center gap-2 border-t md:border-t-0 pt-3 md:pt-0 border-slate-100">
                        <!-- Toggle Status -->
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-lg border transition-all {{ $task->status === 'Completed' ? 'border-amber-300 text-amber-700 hover:bg-amber-50' : 'border-emerald-300 text-emerald-700 hover:bg-emerald-50' }}">
                                {{ $task->status === 'Completed' ? '↺ Mark Pending' : '✓ Complete' }}
                            </button>
                        </form>

                        <!-- Edit -->
                        <a href="{{ route('tasks.edit', $task) }}" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-slate-300 text-slate-700 hover:bg-slate-100 transition-all">
                            Edit
                        </a>

                        <!-- Delete -->
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" onsubmit="return confirm('Delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold rounded-lg border border-rose-200 text-rose-600 hover:bg-rose-50 transition-all">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-8 text-center border border-dashed border-slate-300">
                    <p class="text-slate-500 font-medium">No tasks found. Add your first task above!</p>
                </div>
            @endforelse
        </div>
    </div>
</body>
</html>