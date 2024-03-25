<?php

use App\Http\Controllers\AccountTypeController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UtilityController;
use App\Http\Controllers\WidgetsController;
use App\Http\Controllers\SetLocaleController;
use App\Http\Controllers\ComponentsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\DatabaseBackupController;
use App\Http\Controllers\GeneralSettingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\TermsAndConditionController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\WaiverController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CampController;

require __DIR__ . '/auth.php';



Route::get('/', [CustomerController::class, 'website']);
Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('category-tickets/{id}', [TicketController::class, 'category_tickets'])->name('tickets.category-tickets');
Route::get('parties', [TicketController::class, 'parties'])->name('parties.index');
Route::get('groups', [TicketController::class, 'groups'])->name('groups.index');
Route::get('memberships', [TicketController::class, 'memberships'])->name('memberships.index');
Route::get('events', [TicketController::class, 'events'])->name('events.index');


Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');

Route::group(['middleware' => ['auth', 'verified']], function () {
    // Dashboards
    Route::get('dashboard', [HomeController::class, 'index'])->name('dashboard.index');
    // Locale
    Route::get('setlocale/{locale}', SetLocaleController::class)->name('setlocale');

    // User
    Route::resource('users', UserController::class)->except(['show']);
    //Customers
    Route::resource('customers', CustomerController::class)->except(['store']);
    Route::post('customer-store', [CustomerController::class, 'store']);
    Route::get('family-member-edit/{customer}', [CustomerController::class, 'editCustomerFamilyMember'])->name('customers.family-member.edit');
    Route::post('customer-family-member-update/{customer}', [CustomerController::class, 'updateCustomerFM']);
    // Permission
    Route::resource('permissions', PermissionController::class)->except(['show']);
    // Roles
    Route::resource('roles', RoleController::class)->except(['show']);
    // Location
    Route::resource('locations', LocationController::class)->except(['show']);
    // Account Type
    Route::resource('account-types', AccountTypeController::class);

    // Terms and Condition
    Route::resource('terms-condition', TermsAndConditionController::class)->except(['show']);

    // category
    Route::resource('categories', CategoryController::class);

    // Ticket
    // Route::resource('tickets', TicketController::class);

    // Profiles
    Route::resource('my-profile', ProfileController::class)->only(['index', 'update'])->parameter('my-profile', 'user');

    Route::get('my-waivers', [WaiverController::class, 'myWaivers'])->name('my-waivers');


    // Env
    Route::singleton('general-settings', GeneralSettingController::class);
    Route::post('general-settings-logo', [GeneralSettingController::class, 'logoUpdate'])->name('general-settings.logo');



    // Database Backup
    Route::resource('database-backups', DatabaseBackupController::class);
    Route::get('database-backups-download/{fileName}', [DatabaseBackupController::class, 'databaseBackupDownload'])->name('database-backups.download');

    Route::get('customer-wavier-snapshot', [CustomerController::class, 'custWavierSnapshot'])->name('cust-wavier.snapshot');
    Route::get('generate-customer-wavier-snapshot-pdf/{wavierSnapshot}', [CustomerController::class, 'generateCustWavierSnapshotPdf'])->name('cust-wavier.snapshot.pdf');

    Route::get('global-search', [CustomerController::class, 'globalSearch'])->name('globalSearch');

    Route::get('send-notifications', [NotificationController::class, 'create'])->name('notifications.create');
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('notifications', [NotificationController::class, 'store'])->name('notifications.store');
    Route::get('update-notifications/{notificationId}', [NotificationController::class, 'update']);
});


Route::get('signup-waiver', [WaiverController::class, 'create'])->name('signup-waiver');
Route::post('signup-waiver/store', [WaiverController::class, 'store'])->name('signup-waiver.store');


//camp

Route::get('camp-booking', [CampController::class, 'create'])->name('booking-camp');
Route::post('signup-camp/store', [CampController::class, 'store'])->name('booking-camp.store');

//booking form

