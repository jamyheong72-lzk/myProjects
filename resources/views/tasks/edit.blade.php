<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Task</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen py-10 px-4">

    <div class="max-w-xl mx-auto">
        <div class="bg-slate-800/80 backdrop-blur-xl border border-slate-700/60 rounded-2xl p-6 shadow-lg">
            <div class="flex items-center justify-between mb-6">
                <h1 class="text-xl font-bold text-white">Edit Task</h1>
                <a href="{{ route('tasks.index') }}" class="text-xs text-slate-400 hover:text-white transition">← Back to Tasks</a>
            </div>

            <form action="{{ route('tasks.update', $task) }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Task Title *</label>
                    <input type="text" name="task_name" value="{{ old('task_name', $task->task_name) }}" required 
                        class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Due Date</label>
                    <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}" 
                        class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition [color-scheme:dark]">
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1">Description</label>
                    <textarea name="description" rows="3" 
                        class="w-full bg-slate-900/90 border border-slate-700 rounded-xl px-4 py-2.5 text-slate-200 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition">{{ old('description', $task->description) }}</textarea>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <a href="{{ route('tasks.index') }}" class="px-5 py-2.5 rounded-xl text-slate-400 hover:bg-slate-700/50 text-sm font-semibold transition">Cancel</a>
                    <button type="submit" class="bg-gradient-to-r from-indigo-500 to-purple-600 hover:from-indigo-600 hover:to-purple-700 text-white font-semibold px-6 py-2.5 rounded-xl shadow-lg transition">
                        Update Task
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>