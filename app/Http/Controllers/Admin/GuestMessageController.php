<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GuestMessage;
use Illuminate\Http\Request;

class GuestMessageController extends Controller
{
    /**
     * Display a listing of guest messages.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = GuestMessage::query();

        if ($status) {
            $query->where('status', $status);
        }

        // Ordenar por pendientes primero, luego más recientes
        $messages = $query->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.messages', compact('messages', 'status'));
    }

    /**
     * Approve the specified guest message.
     */
    public function approve($id)
    {
        $message = GuestMessage::findOrFail($id);
        $message->update(['status' => 'approved']);

        return redirect()->route('admin.messages')->with('success', 'Mensaje de invitado aprobado e incorporado al muro.');
    }

    /**
     * Reject/Hide the specified guest message.
     */
    public function reject($id)
    {
        $message = GuestMessage::findOrFail($id);
        $message->update(['status' => 'rejected']);

        return redirect()->route('admin.messages')->with('success', 'Mensaje de invitado ocultado.');
    }

    /**
     * Remove the specified guest message.
     */
    public function destroy($id)
    {
        $message = GuestMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.messages')->with('success', 'Mensaje de invitado eliminado con éxito.');
    }
}
