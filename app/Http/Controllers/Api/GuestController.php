<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Models\Task;
use App\Mail\TaskAssigned;
use Illuminate\Support\Facades\Mail;

class GuestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|unique:guests,email',
        ]);

        // Trova una task disponibile (che ha ancora slot)
        $availableTasks = Task::withCount('guests')
            ->get()
            ->filter(function ($task) {
                return $task->guests_count < $task->max_assignments;
            });

        if ($availableTasks->isEmpty()) {
            return response()->json([
                'message' => 'No more tasks available for assignment.'
            ], 400);
        }

        $task = $availableTasks->random();


        // Crea il guest e assegna la missione
        $guest = Guest::create([
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'task_id'   => $task->id,
        ]);

        // ✅ Invio automatico dell’email
        Mail::to($guest->email)->send(new TaskAssigned($guest, $task));
        return response()->json([
            'message' => 'Guest registered successfully!',
            'task' => [
                'title' => $task->title,
                'description' => $task->description,
            ]
        ]);
    }
    public function review(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $guest = Guest::where('email', $request->email)->with('task')->first();

        if (!$guest) {
            return response()->json([
                'message' => 'No guest found with this email.'
            ], 404);
        }

        return response()->json([
            'full_name' => $guest->full_name,
            'email' => $guest->email,
            'task' => [
                'title' => $guest->task->title,
                'description' => $guest->task->description,
            ]
        ]);
    }
    public function changeTask(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $guest = Guest::where('email', $request->email)->with('task')->first();

        if (!$guest) {
            return response()->json([
                'message' => 'No guest found with this email.'
            ], 404);
        }

        if ($guest->changed_task) {
            return response()->json([
                'message' => 'You have already changed your task once.'
            ], 403);
        }

        // Prendi una nuova task diversa da quella già assegnata
        $availableTasks = Task::withCount('guests')
            ->get()
            ->filter(function ($task) use ($guest) {
                return $task->guests_count < $task->max_assignments && $task->id !== $guest->task_id;
            });

        if ($availableTasks->isEmpty()) {
            return response()->json([
                'message' => 'No alternative tasks available at the moment.'
            ], 400);
        }

        $newTask = $availableTasks->random();

        $guest->task_id = $newTask->id;
        $guest->changed_task = true;
        $guest->save();

        Mail::to($guest->email)->send(new TaskAssigned($guest, $newTask));

        return response()->json([
            'message' => 'Task reassigned successfully!',
            'task' => [
                'title' => $newTask->title,
                'description' => $newTask->description,
            ]
        ]);
    }
}
