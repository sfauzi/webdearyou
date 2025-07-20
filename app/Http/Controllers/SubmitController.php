<?php

namespace App\Http\Controllers;

use App\Models\Confession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubmitController extends Controller
{
    public function submit()
    {
        $currentDateTime = Carbon::now()->format('D d M Y, h:i A');

        return Inertia::render('Submit', [
            'currentDateTime' => $currentDateTime,
        ]);
    }

    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'sender_name' => 'required|string|max:255',
            'message' => 'required|string|max:1000',
            'recipient_name' => 'required|string|max:255',
        ], [
            'sender_name.required' => 'Sender required',
            'sender_name.max' => 'Sender maximum 255 characters',
            'message.required' => 'Message is required',
            'message.max' => 'Message maximum 1000 characters',
            'recipient_name.required' => 'Recipient is required',
            'recipient_name.max' => 'Recipient maximum 255 characters',
        ]);

        try {
            // Simpan data ke database
            Confession::create($validated);

            // Redirect dengan flash message sukses
            return redirect()->route('submit')->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            // Redirect dengan flash message error jika gagal
            return redirect()->route('submit')->with('error', 'Failed to send message. Please try again.');
        }
    }
}
