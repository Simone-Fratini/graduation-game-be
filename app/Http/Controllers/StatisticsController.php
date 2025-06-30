<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    public function index()
    {
        // Statistiche degli ospiti
        $totalGuests = Guest::count();
        $guestsWithTask = Guest::whereNotNull('task_id')->count();
        $guestsWithoutTask = Guest::whereNull('task_id')->count();
        $guestsWithChangedTask = Guest::where('changed_task', true)->count();
        $guestsWithoutChangedTask = Guest::where('changed_task', false)->count();

        // Lista degli ospiti con dettagli
        $guests = Guest::with('task')
            ->orderBy('created_at', 'desc')
            ->get();

        // Statistiche delle task
        $tasks = Task::withCount('guests')->get();
        $totalTasks = $tasks->count();

        // Task più popolari
        $popularTasks = Task::withCount('guests')
            ->orderBy('guests_count', 'desc')
            ->limit(5)
            ->get();

        return view('statistics.index', compact(
            'totalGuests',
            'guestsWithTask',
            'guestsWithoutTask',
            'guestsWithChangedTask',
            'guestsWithoutChangedTask',
            'guests',
            'tasks',
            'totalTasks',
            'popularTasks'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'max_assignments' => 'required|integer|min:1|max:100',
        ]);

        Task::create($request->all());

        return redirect()->route('statistics.index')
            ->with('success', 'Task creata con successo!');
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'max_assignments' => 'required|integer|min:1|max:100',
        ]);

        $task->update($request->all());

        return redirect()->route('statistics.index')
            ->with('success', 'Task aggiornata con successo!');
    }

    public function destroy(Task $task)
    {
        // Verifica se ci sono ospiti assegnati a questa task
        if ($task->guests()->count() > 0) {
            return redirect()->route('statistics.index')
                ->with('error', 'Non è possibile eliminare una task che ha ospiti assegnati.');
        }

        $task->delete();

        return redirect()->route('statistics.index')
            ->with('success', 'Task eliminata con successo!');
    }
}
