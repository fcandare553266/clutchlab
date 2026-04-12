<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingSessionController extends Controller
{
    public function index()
    {
        // RBAC: Admin sees everything, Client only sees their own sessions
        if (Auth::user()->role === 'admin') {
            $sessions = TrainingSession::with('user')->get();
        } else {
            $sessions = TrainingSession::where('user_id', Auth::id())->get();
        }
        return view('sessions.index', compact('sessions'));
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'scheduled_at' => 'required|date',
        ]);

        TrainingSession::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'scheduled_at' => $request->scheduled_at,
            'amount' => 500.00,
            'payment_status' => 'paid', 
        ]);

        return redirect()->route('sessions.index')->with('success', 'Session Booked!');
    }

    public function edit(TrainingSession $session)
    {
        // Safety: Only owner or admin can edit
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
        // RBAC: Only Admin can delete sessions
        if (Auth::user()->role !== 'admin') {
            return back()->with('error', 'Only admins can delete records.');
        }
        $session->delete();
        return redirect()->route('sessions.index');
    }
}