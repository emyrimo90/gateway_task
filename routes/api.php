<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use App\Http\Controllers\Api\V1\Auth\{
    LoginController,
    LogoutController,
    ForgotPasswordController,
    ResetPasswordController
};

use App\Http\Controllers\Api\V1\{ActivityLogController,
    FileController,
    FilterController,
    GatewaySettingController,
    GeneralSettingsController,
    TransactionController,
    PermissionController,
    ReportExportController,
    RoleController,
    UserController};

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['localization']], function () {
    Route::post('login', LoginController::class);

    Route::post('reset-password', ForgotPasswordController::class);
    Route::post('change-password', ResetPasswordController::class);
    Route::post('save-password', 'Auth\ResetPasswordController@savePassword');

    Route::middleware('auth:sanctum')->group(function () {
        Route::resource('files', FileController::class)->only(['store', 'destroy']);
        Route::resource('roles', RoleController::class)->except('edit', 'create');
        Route::get('permissions', PermissionController::class);
        Route::get('/filters/{model}', FilterController::class);
        Route::resource('users', UserController::class)->except('create', 'edit');
        Route::post('/gateway-settings/change-status/{client}', [GatewaySettingController::class, 'changeStatus']);
        Route::resource('gateway-settings', GatewaySettingController::class)->except('create', 'edit');
        Route::group(['prefix'=> 'transactions'], static function () {
           Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
           Route::get('/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');
           Route::post('/process-transaction', [TransactionController::class, 'processTransaction']);
        });

        Route::group(['prefix' => 'settings'], static function () {
            Route::get('/logs', [ActivityLogController::class,'index']);
            Route::resource('general', GeneralSettingsController::class)->only('index', 'update');
        });
        Route::get("/change-locale/{locale}", [GeneralSettingsController::class, 'changeLanguage']);
        Route::controller(ReportExportController::class)->prefix('export-excel/reports')->group(function () {
            Route::get('logs', 'logsExport');
        });
        Route::post('logout', LogoutController::class);
    });
});

