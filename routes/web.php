<?php

use Illuminate\Support\Facades\Route;

// Public Invitation Controllers
use App\Http\Controllers\PublicInvitationController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\GuestPhotoController;
use App\Http\Controllers\GuestMessageController;

// Admin Panel Controllers
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventSettingController;
use App\Http\Controllers\Admin\RsvpController as AdminRsvpController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\GuestPhotoController as AdminGuestPhotoController;
use App\Http\Controllers\Admin\GuestMessageController as AdminGuestMessageController;
use App\Http\Controllers\Admin\MusicController;

/*
|--------------------------------------------------------------------------
| Rutas Públicas (Invitación)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicInvitationController::class, 'index'])->name('invitation');
Route::post('/rsvp', [RsvpController::class, 'store'])->name('rsvp.store');
Route::post('/upload-photo', [GuestPhotoController::class, 'store'])->name('guest-photo.store');
Route::post('/send-message', [GuestMessageController::class, 'store'])->name('guest-message.store');

/*
|--------------------------------------------------------------------------
| Rutas de Autenticación de Administración
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// Redirección de seguridad para evitar errores cuando Laravel busca la ruta 'login' por defecto
Route::get('/login', function () {
    return redirect()->route('admin.login');
})->name('login');

/*
|--------------------------------------------------------------------------
| Rutas de Administración (Protegidas por admin middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->prefix('admin')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    // Configuración del Evento y Diseño
    Route::get('/settings', [EventSettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [EventSettingController::class, 'update'])->name('admin.settings.update');

    // RSVP - Invitados
    Route::get('/rsvp', [AdminRsvpController::class, 'index'])->name('admin.rsvp');
    Route::post('/rsvp/invite', [AdminRsvpController::class, 'storeInvite'])->name('admin.rsvp.store-invite');
    Route::put('/rsvp/{id}', [AdminRsvpController::class, 'update'])->name('admin.rsvp.update');
    Route::delete('/rsvp/{id}', [AdminRsvpController::class, 'destroy'])->name('admin.rsvp.destroy');
    Route::get('/rsvp-export', [AdminRsvpController::class, 'exportCsv'])->name('admin.rsvp.export');

    // Galería Oficial
    Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::post('/gallery/order', [GalleryController::class, 'updateOrder'])->name('admin.gallery.order');
    Route::post('/gallery/highlight/{id}', [GalleryController::class, 'highlight'])->name('admin.gallery.highlight');
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');

    // Fotos de Invitados (Moderación)
    Route::get('/uploaded-photos', [AdminGuestPhotoController::class, 'index'])->name('admin.uploaded-photos');
    Route::post('/uploaded-photos/approve/{id}', [AdminGuestPhotoController::class, 'approve'])->name('admin.uploaded-photos.approve');
    Route::post('/uploaded-photos/reject/{id}', [AdminGuestPhotoController::class, 'reject'])->name('admin.uploaded-photos.reject');
    Route::delete('/uploaded-photos/{id}', [AdminGuestPhotoController::class, 'destroy'])->name('admin.uploaded-photos.destroy');

    // Libro de Dedicatorias (Moderación)
    Route::get('/messages', [AdminGuestMessageController::class, 'index'])->name('admin.messages');
    Route::post('/messages/approve/{id}', [AdminGuestMessageController::class, 'approve'])->name('admin.messages.approve');
    Route::post('/messages/reject/{id}', [AdminGuestMessageController::class, 'reject'])->name('admin.messages.reject');
    Route::delete('/messages/{id}', [AdminGuestMessageController::class, 'destroy'])->name('admin.messages.destroy');

    // Música de Fondo
    Route::get('/music', [MusicController::class, 'index'])->name('admin.music');
    Route::post('/music', [MusicController::class, 'update'])->name('admin.music.update');
    Route::delete('/music', [MusicController::class, 'destroy'])->name('admin.music.destroy');
});
/*
|--------------------------------------------------------------------------
| Rutas de Migraciones y Seeders para Hosting Compartido
|--------------------------------------------------------------------------
*/
Route::get('/__migrate', function (\Illuminate\Http\Request $request) {
    $expectedKey = 'Trinitotolueno2015';
    $providedKey = $request->query('key');

    if ($providedKey !== $expectedKey) {
        return response()->json([
            'status' => 'error',
            'message' => 'Unauthorized.'
        ], 403);
    }

    try {
        $output = "";

        // Run migrations
        $output .= "--- Running Migrations ---\n";
        \Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output .= \Illuminate\Support\Facades\Artisan::output() . "\n";

        // Optionally run seeders
        if ($request->query('seed') === 'true' || $request->has('seed')) {
            $output .= "--- Running Seeders ---\n";
            \Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            $output .= \Illuminate\Support\Facades\Artisan::output() . "\n";
        }

        return response("<pre>{$output}</pre>");
    } catch (\Exception $e) {
        return response("Error running migrations: " . $e->getMessage(), 500);
    }
})->middleware('throttle:2,1');
