<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PrestataireController;
use App\Http\Controllers\LocataireController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\LocatairePaymentController;
use App\Http\Controllers\CautionController;
use App\Http\Controllers\ConsommationEauController;
use App\Http\Controllers\PaiementEauController;
use App\Http\Controllers\TravailController;
use App\Http\Controllers\DepenseTravailController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


// Route::get('/test-mail', function () {
//     Mail::raw('Test d\'envoi de mail', function ($message) {
//         $message
//             ->to('nailousekaro@gmail.com') // Remplace par ton e-mail
//             ->subject('Test Laravel Mail');
//     });

//     return 'E-mail envoyé avec succès !';
// });



// Route::get('/', function () {
//     return view('welcome');
// });

// routes/web.php

// Route::post('/login', [AuthController::class, 'login'])->name('login');;
// Route::get('/language/{locale}', [LanguageController::class, 'switch'])->name('language');
// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Auth::routes(['verify' => true]);

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login');;
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/verify-payment/{token}', [PaymentController::class, 'verify'])->name('payments.verify');
Route::get('/paiements/fedapay/callback', [LocatairePaymentController::class, 'fedapayCallback'])->name('paiements.fedapay.callback');




Route::middleware(['auth'])->group(function () {
    Route::get('/password/reset', [DashboardController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/password/reset', [DashboardController::class, 'reset'])->name('password.reset');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');


    Route::get('/paiements', [LocatairePaymentController::class, 'index'])->name('paiements.index');
    Route::get('/paiements/fedapay', [LocatairePaymentController::class, 'fedapayPage'])->name('paiements.fedapay.page');
    Route::post('/paiements/fedapay', [LocatairePaymentController::class, 'initiateFedaPayForPeriod'])->name('paiements.fedapay.initiate');
    Route::get('/paiements/{payment}', [LocatairePaymentController::class, 'show'])->name('paiements.show');
    Route::get('/paiements/{payment}/recu', [LocatairePaymentController::class, 'downloadReceipt'])->name('paiements.receipt');
    Route::post('/paiements/{payment}/fedapay', [LocatairePaymentController::class, 'initiateFedaPay'])->name('locataire.payments.fedapay');


    Route::resource('consommations-eau', ConsommationEauController::class)
    ->parameters([
        'consommations-eau' => 'consommationEau'
    ])
    ->only(['index', 'create', 'store', 'show']);

    Route::get(
        'consommations-eau/{consommationEau}/facture',
        [ConsommationEauController::class, 'facture']
    )->name('consommations-eau.facture');

    Route::post(
        'consommations-eau/{consommationEau}/payer',
        [PaiementEauController::class, 'store']
    )->name('paiements-eau.store');


    Route::resource('travaux', TravailController::class)
    ->parameters([
        'travaux' => 'travail'
    ]);
Route::post(
    'travaux/{travail}/depenses',
    [DepenseTravailController::class, 'store']
)->name('travaux.depenses.store');



    Route::prefix('properties')->group(function () {
        // Properties
        Route::resource('properties', PropertyController::class);
        Route::post('/properties/{property}/assign-locataire', [PropertyController::class, 'assignLocataire'])
            ->name('properties.assign-locataire');
        Route::post('/properties/{property}/liberer', [PropertyController::class, 'liberer'])
            ->name('properties.liberer');
        });



            Route::resource('cautions', CautionController::class);
                Route::get('/cautions/{caution}/receipt', [CautionController::class, 'downloadReceipt'])
                    ->name('cautions.receipt');
                Route::get('/verify-caution/{token}', [CautionController::class, 'verify'])
                    ->name('cautions.verify');




});


Route::middleware(['auth'])->group(function () {
    Route::prefix('payments')->name('payments.')->group(function () {

    // Routes FedaPay (AVANT le resource pour éviter les conflits)
    Route::get('fedapay/initiate', [PaymentController::class, 'initiateFedapay'])
        ->name('fedapay.initiate');
    Route::get('fedapay/callback', [PaymentController::class, 'fedapayCallback'])
        ->name('fedapay.callback');

    // Routes resource (APRÈS les routes spécifiques)
    Route::resource('/', PaymentController::class)->parameters(['' => 'payment']);

    // Autres routes
    Route::get('{payment}/receipt', [PaymentController::class, 'downloadReceipt'])
        ->name('receipt');
    Route::get('api/statistiques', [PaymentController::class, 'statistiques'])
        ->name('statistiques');
});
});



    Route::prefix('dashboard')->group(function(){

        // Dashboard Admin
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        Route::get('/api/admin/dashboard/chart-data', [AdminDashboardController::class, 'getChartData'])->name('admin.dashboard.chart-data');
        Route::get('/api/admin/dashboard/quick-stats', [AdminDashboardController::class, 'getQuickStats'])->name('admin.dashboard.quick-stats');

    });

    Route::prefix('calendrier')->group(function(){
        // Calendrier des échéances
        Route::get('/calendar', [CalendarController::class, 'index'])->name('calendar.index');
        Route::get('/api/calendar/events', [CalendarController::class, 'getCalendarEvents'])->name('calendar.events');
        Route::post('/payments/{payment}/mark-paid', [CalendarController::class, 'markAsPaid'])->name('payments.mark-paid');
        Route::post('/payments/{payment}/send-reminder', [CalendarController::class, 'sendReminder'])->name('payments.send-reminder');

    });

    Route::prefix('contrat')->group(function(){

        // Contrats de location
        Route::resource('contracts', ContractController::class);
        Route::get('/contracts/{contract}/download', [ContractController::class, 'download'])->name('contracts.download');
        Route::get('/contracts/{contract}/preview', [ContractController::class, 'preview'])->name('contracts.preview');
        Route::post('/contracts/{contract}/generate-pdf', [ContractController::class, 'generatePdf'])->name('contracts.generate-pdf');
        Route::post('/contracts/{contract}/sign', [ContractController::class, 'sign'])->name('contracts.sign');
        Route::post('/contracts/{contract}/terminate', [ContractController::class, 'terminate'])->name('contracts.terminate');
    });




Route::prefix('admin')->middleware(['auth'])->group(function () {
    // Gestion des utilisateurs
    Route::resource('users', UserController::class);
    Route::post('users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UserController::class, 'forceDelete'])->name('users.force-delete');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status');


    // Mot de passe oublié
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    // Route::get('/reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});


// Messagerie
Route::prefix('messages')->middleware('auth')->group(function () {
    // Boîte de réception
    Route::get('/', [MessageController::class, 'index'])->name('messages.index');

    // Envoyer un message
    Route::get('/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/', [MessageController::class, 'store'])->name('messages.store');

    // ✅ Mettre les routes "fixes" avant la route dynamique
    Route::get('/sent', [MessageController::class, 'sent'])->name('messages.sent');


    // Lecture des messages (doit venir après les autres GET)
    Route::get('/{message}', [MessageController::class, 'show'])->name('messages.show') ->middleware('can:view,message');

    // Répondre à un message
    Route::get('/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');

    // Marquer comme lu/non lu
    Route::post('/{message}/read', [MessageController::class, 'markAsRead'])->name('messages.read');


    // Supprimer
    Route::delete('/{message}', [MessageController::class, 'destroy'])->name('messages.destroy');

    // Liste des non lus
    Route::get('/unread', [MessageController::class, 'unread'])->name('messages.unread.list');

    // Marquer un message comme non lu
    Route::post('/{message}/unread', [MessageController::class, 'markAsUnread'])->name('messages.unread');

    Route::get('/messages/export', [MessageController::class, 'export'])->name('messages.export');





});



// API pour les notifications
Route::prefix('api')->middleware('auth')->group(function () {
    Route::get('/unread-messages-count', [MessageController::class, 'unreadCount']);
    Route::get('/latest-messages', [MessageController::class, 'latestMessages']);
});

Route::prefix('chat')->middleware('auth')->name('chat.')->group(function () {
    // Liste des conversations
    Route::get('/', [ChatController::class, 'index'])->name('index');

    // Récupérer les nouveaux messages (polling)
    Route::get('/{conversationId}/messages/{lastMessageId?}', [ChatController::class, 'getNewMessages'])->name('messages');


    // Afficher une conversation
    Route::get('/{conversationId}', [ChatController::class, 'show'])->name('show');

    // Démarrer une nouvelle conversation
    Route::get('/new/{userId}', [ChatController::class, 'newConversation'])->name('new');

    // API pour envoyer un message
    Route::post('/send', [ChatController::class, 'sendMessage'])->name('send');


    // Marquer comme lu
    Route::post('/mark-read/{messageId}', [ChatController::class, 'markAsRead'])->name('mark-read');

    // Recherche
    Route::get('/search', [ChatController::class, 'search'])->name('search');
});

Route::get('/acceuil', function () {
    return view('acceuil');
})->middleware('auth')->name('acceuil');

Route::middleware(['auth'])->group(function () {
    Route::get('/profil', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');
});
