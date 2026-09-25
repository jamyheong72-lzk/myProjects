<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Task Manager</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-50 to-indigo-50 min-h-screen text-slate-800 antialiased">
    
    <!-- Top Header Banner -->
    <header class="bg-indigo-700 text-white shadow-md">
        <div class="max-w-5xl mx-auto px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-2">
            <div class="flex items-center gap-3">
                <span class="bg-indigo-900 text-indigo-200 text-xs font-mono font-bold px-3 py-1 rounded-full border border-indigo-600">
                    WST21-PM-2026-SF
                </span>
                <h1 class="text-xl font-bold tracking-tight">Personal Task Manager</h1>
            </div>
            <div class="text-sm text-indigo-200 font-medium">
                Laravel Portfolio Project
            </div>
        </div>
    </header>

    <main class="max-w-5xl mx-auto px-6 py-8">
        
        <!-- Action Bar & Alerts -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <div>
                <h2 class="text-2xl font-extrabold text-slate-900">Task Dashboard</h2>
                <p class="text-sm text-slate-500">Manage your daily tasks, priorities, and deadlines efficiently.</p>
            </div>
            <a href="{{ route('tasks.create') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-5 py-2.5 rounded-xl font-semibold shadow-lg shadow-indigo-200 hover:bg-indigo-700 transition-all transform hover:-translate-y-0.5">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add New Task
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl shadow-sm flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-emerald-500 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Tasks Container Card -->
        <div class="bg-white rounded-2xl shadow-xl shadow-slate-100 border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/75 border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-500">
                            <th class="p-4 pl-6">Task Name</th>
                            <th class="p-4">Description</th>
                            <th class="p-4">Due Date</th>
                            <th class="p-4">Status</th>
                            <th class="p-4 pr-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-4 pl-6 font-semibold text-slate-900">{{ $task->task_name }}</td>
                                <td class="p-4 text-slate-600 max-w-xs truncate">{{ $task->description ?? 'No description provided' }}</td>
                                <td class="p-4 text-slate-600 font-medium">
                                    @if($task->due_date)
                                        <span class="inline-flex items-center gap-1.5 bg-slate-100 text-slate-700 px-2.5 py-1 rounded-lg text-xs font-medium">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                        </span>
                                    @else
                                        <span class="text-slate-400 italic text-xs">No deadline</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="px-3 py-1 text-xs font-bold rounded-full transition-all shadow-sm {{ $task->status === 'Completed' ? 'bg-emerald-100 text-emerald-800 hover:bg-emerald-200 border border-emerald-300' : 'bg-amber-100 text-amber-800 hover:bg-amber-200 border border-amber-300' }}">
                                            ● {{ $task->status }}
                                        </button>
                                    </form>
                                </td>
                                <td class="p-4 pr-6 text-right space-x-2">
<a href="{{ route('tasks.edit', $task->id) }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-900 font-medium text-xs bg-indigo-50 px-3 py-1.5 rounded-lg border border-indigo-100 transition-colors">Edit</a>                                    <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center text-rose-600 hover:text-rose-900 font-medium text-xs bg-rose-50 px-3 py-1.5 rounded-lg border border-rose-100 transition-colors">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center text-slate-400">
                                    <div class="flex flex-col items-center justify-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                                        </svg>
                                        <p class="font-medium text-slate-600">No tasks created yet.</p>
                                        <p class="text-xs text-slate-400">Get started by clicking the "Add New Task" button above.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>