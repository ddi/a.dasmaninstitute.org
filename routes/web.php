<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Api\V1\PatientController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GateLog\EmployeesController;
use App\Http\Controllers\HubLinkController;
use App\Http\Controllers\PatientsController;
use App\Models\HubLink;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home', ['hubLinks' => HubLink::all()->sortBy('order')->toArray()]);
})->name('home');
Route::match(['get', 'post'], '/login', [AuthController::class, 'login'])->name('login')->middleware('guest');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

Route::get('/hublinks', [HubLinkController::class, 'index'])
    ->name('hublinks.index')
    ->middleware('auth')
    ->can('manage', HubLink::class);

Route::get('/hublinks/create', [HubLinkController::class, 'create'])
    ->name('hublinks.create')
    ->middleware('auth')
    ->can('manage', HubLink::class);

Route::post('/hublinks', [HubLinkController::class, 'store'])
    ->middleware('auth')
    ->name('hublinks.store')
    ->can('manage', HubLink::class);

Route::delete('/hublinks/{hublink}', [HubLinkController::class, 'destroy'])
    ->middleware('auth')
    ->name('hublinks.destroy')
    ->can('manage', HubLink::class);

Route::get('/hublinks/{hublink}/edit', function (HubLink $hublink) {
    return view('hub-links.edit', ['hublink' => $hublink]);
})
    ->name('hublinks.edit')
    ->middleware('auth')
    ->can('manage', HubLink::class);

Route::patch('/hublinks/{hublink}', [HubLinkController::class, 'update'])
    ->name('hublinks.update')
    ->middleware('auth')
    ->can('manage', HubLink::class);

Route::get('/admin/users', [UserController::class, 'index'])
    ->name('users.index')
    ->middleware('auth')
    ->can('manage', User::class);
Route::get('/admin/users/create', [UserController::class, 'create'])
    ->name('users.create')
    ->middleware('auth')
    ->can('manage', User::class);
Route::get('/admin/users/{user}/edit', [UserController::class, 'edit'])
    ->name('users.edit')
    ->middleware('auth')
    ->can('manage', User::class);
Route::put('/admin/users/{user}', [UserController::class, 'update'])
    ->name('users.update')
    ->middleware('auth')
    ->can('manage', User::class);
Route::post('/admin/users', [UserController::class, 'store'])
    ->middleware('auth')
    ->name('users.store')
    ->can('manage', User::class);


Route::get('/patient/forms', [PatientsController::class, 'forms'])
    ->name('patient.forms')
    ->middleware('auth');

Route::get('/patient/consent-form/{patient}', [PatientsController::class, 'consentForm'])
    ->name('patient.consent-form')
    ->middleware('auth')
    ->can('search', Patient::class);

Route::get('/patient/forms', [PatientsController::class, 'forms'])
    ->name('patient.forms')
    ->middleware('auth');

Route::view('/patients', 'patient.index')
    ->name('patients.index')
    ->middleware('auth')
    ->can('search', Patient::class);

Route::view('/patient/{id}', 'patient.view')
    ->name('patients.view');

Route::get('about', function () {
    return view('about');
})
    ->name('about');

Route::get('dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//Route::resource('hublinks', HubLinkController::class)->middleware('auth');

// Route::get('/admin/users/create', [HubLinkController::class, 'create'])
//     ->name('hublinks.create')
//     ->middleware('auth')
//     ->can('manage', HubLink::class);


// Route::delete('/admin/users/{hublink}', [HubLinkController::class, 'destroy'])
//     ->middleware('auth')
//     ->name('hublinks.destroy')
//     ->can('manage', HubLink::class);









// Route::resource('admin/users', UserController::class)
//     ->middleware('auth')
//     ->can('manage', User::class);
// ->middleware('auth')

// ->can('manage', User::class);


// Route::get('/hublinks/{hublink}/edit', [HubLinkController::class, 'edit'])
//     ->middleware('auth')
//     ->can('edit', 'hublink');
// Route::get('/hublinks/{hublink}', [HubLinkController::class, 'show']);
// 





Route::resource('employees', EmployeesController::class);
