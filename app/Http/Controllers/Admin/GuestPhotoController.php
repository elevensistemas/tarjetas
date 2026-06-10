<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UploadedPhoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuestPhotoController extends Controller
{
    /**
     * Display a listing of guest uploaded photos.
     */
    public function index(Request $request)
    {
        $status = $request->input('status');

        $query = UploadedPhoto::query();

        if ($status) {
            $query->where('status', $status);
        }

        // Ordenar por pendientes primero, luego más recientes
        $photos = $query->orderByRaw("CASE WHEN status = 'pending' THEN 0 ELSE 1 END")
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.uploaded-photos', compact('photos', 'status'));
    }

    /**
     * Approve the specified guest photo.
     */
    public function approve($id)
    {
        $photo = UploadedPhoto::findOrFail($id);
        $photo->update(['status' => 'approved']);

        return redirect()->route('admin.uploaded-photos')->with('success', 'Foto de invitado aprobada y visible públicamente.');
    }

    /**
     * Reject the specified guest photo.
     */
    public function reject($id)
    {
        $photo = UploadedPhoto::findOrFail($id);
        $photo->update(['status' => 'rejected']);

        return redirect()->route('admin.uploaded-photos')->with('success', 'Foto de invitado rechazada.');
    }

    /**
     * Remove the specified guest photo from storage and DB.
     */
    public function destroy($id)
    {
        $photo = UploadedPhoto::findOrFail($id);

        if ($photo->file_path) {
            Storage::disk('public')->delete($photo->file_path);
        }

        $photo->delete();

        return redirect()->route('admin.uploaded-photos')->with('success', 'Foto de invitado eliminada permanentemente.');
    }
}
