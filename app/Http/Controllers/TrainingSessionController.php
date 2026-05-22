<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingSessionController extends Controller
{
   public function index()
{
    $user = Auth::user();
    
    if ($user->role === 'admin') {
        // ADMIN: Load everything, even if no trainer is assigned yet
        $sessions = \App\Models\TrainingSession::with(['user', 'trainer'])->latest()->get();
    } elseif ($user->role === 'trainer') {
        // TRAINER: Only show sessions where they are the trainer
        $sessions = \App\Models\TrainingSession::where('trainer_id', $user->id)->with(['user', 'trainer'])->latest()->get();
    } else {
        // CLIENT: Only show their own sessions
        $sessions = \App\Models\TrainingSession::where('user_id', $user->id)->with(['user', 'trainer'])->latest()->get();
    }
    
    return view('sessions.index', compact('sessions'));
}
    public function create()
    {
        return view('sessions.create');
    }

public function store(Request $request)
{
    $request->validate(['title' => 'required', 'date' => 'required', 'time' => 'required', 'payment_method' => 'required']);
    $scheduledAt = date('Y-m-d H:i:s', strtotime($request->date . ' ' . $request->time));

    // 1. QUEUE LOGIC:
    $assignedTrainer = \App\Models\User::where('role', 'trainer')
        ->where('specialization', $request->title) // Direct match (e.g. "Strength" == "Strength")
        ->withCount(['activeTrainees' => function($q) {
            $q->where('scheduled_at', '>=', now());
        }])
        ->having('active_trainees_count', '<', 5)
        // SORT 1: People who have NEVER had a client go first (NULLS)
        ->orderByRaw('last_assigned_at IS NULL DESC')
        // SORT 2: People who haven't had a client for the longest time go next
        ->orderBy('last_assigned_at', 'asc')
        ->first();

    try {
        $session = \App\Models\TrainingSession::create([
            'user_id' => (Auth::user()->role === 'admin' && $request->user_id) ? $request->user_id : Auth::id(),
            'trainer_id' => $assignedTrainer ? $assignedTrainer->id : null,
            'title' => $request->title,
            'description' => $request->description ?? 'No specific goals',
            'scheduled_at' => $scheduledAt,
            'amount' => 500.00,
            'payment_status' => ($request->payment_method === 'cash') ? 'unpaid' : 'paid',
        ]);

        // 2. MOVE TO BACK OF QUEUE (The Rotation Trigger)
        if ($assignedTrainer) {
            // We update the timestamp to NOW so they become the "Newest" assignment
            // and the "orderBy last_assigned_at asc" will put them at the bottom.
            $assignedTrainer->last_assigned_at = now();
            $assignedTrainer->save();
        }

        return redirect()->route('sessions.index')->with('success', 'Assigned to ' . ($assignedTrainer->name ?? 'TBA'));

    } catch (\Exception $e) {
        return dd("Error: " . $e->getMessage());
    }
}
    public function edit(TrainingSession $session)
    {
        // RBAC: Only owner or admin can edit
        if (Auth::user()->role !== 'admin' && $session->user_id !== Auth::id()) {
            abort(403);
        }
        return view('sessions.edit', compact('session'));
    }

    public function update(Request $request, TrainingSession $session)
    {
        $session->update($request->all());
        return redirect()->route('sessions.index');
    }

    public function destroy(TrainingSession $session)
    {
        // RBAC: Only Admin can delete
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Unauthorized');
        }
        $session->delete();
        return redirect()->route('sessions.index');
    }
    public function trainerClients()
{
    // RBAC: Only trainers can access this
    if (Auth::user()->role !== 'trainer') {
        abort(403);
    }

    // Get all sessions assigned to this trainer, including the client (user) data
    $sessions = \App\Models\TrainingSession::where('trainer_id', Auth::id())
                ->with('user')
                ->latest()
                ->get();

    return view('trainer.clients', compact('sessions'));
}
}