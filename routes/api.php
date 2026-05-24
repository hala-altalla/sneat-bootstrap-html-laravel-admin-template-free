<?php

use App\Http\Controllers\api\Authcontroller;
use App\Http\Controllers\api\BusinessAccountController;
use App\Http\Controllers\api\FavoriteController;
use App\Http\Controllers\api\MessagesController;
use App\Http\Controllers\api\NotificationsController;
use App\Http\Controllers\api\OrderController;
use App\Http\Controllers\api\RatingController;
use App\Http\Controllers\api\ReportController;
use App\Http\Controllers\api\ServiceController;
use App\Http\Controllers\ConversationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


//

Route::post('/register', [Authcontroller::class, 'register']);
Route::post('/verify-otp', [Authcontroller::class, 'verifyOtp']);
Route::post('/login', [Authcontroller::class, 'login']);
Route::middleware('auth:api')->group(function () {
//updateuser

Route::post('/user/update/send-otp', [AuthController::class, 'sendUpdateOtp']);

Route::post('/user/update/verify-otp', [AuthController::class, 'verifyUpdateOtp']);
//

Route::post('/logout', [Authcontroller::class, 'logout']);
Route::post('/orders', [OrderController::class, 'store']);
Route::put('/orders/{id}', [OrderController::class, 'update']);
Route::get('/orders/sent', [OrderController::class, 'sent']);
 Route::get('/orders/received', [OrderController::class, 'received']);
 Route::post('/orders/{id}/accept', [OrderController::class, 'accept']);
 Route::post('/orders/{id}/reject', [OrderController::class, 'reject']);
 Route::delete('/delete_orders/{id}', [OrderController::class, 'deleteorder']);
//business account
Route::post('/businessaccount',[BusinessAccountController::class,'store']);
Route::post('/business-account/{id}', [BusinessAccountController::class, 'update']);
//services
Route::post('/services', [ServiceController::class, 'store'])->name('api.services.store');
Route::get('/services', [ServiceController::class, 'viewservice']);
Route::post('/services/{id}', [ServiceController::class, 'update']);
Route::get('/dynamic-fields', [ServiceController::class, 'getIds']);
//notifications
Route::get('/notifications', [NotificationsController::class , 'index']);
Route::get('/notifications/unread', [NotificationsController::class , 'unread']);
Route::post('/notifications/{id}/read',[NotificationsController::class,'markAsRead']);
//my service

Route::get('/myaccept_services', [ServiceController::class, 'myacceptservice']);
Route::get('/myrejected_services', [ServiceController::class, 'myrejectedservice']);
Route::get('/mypending_services', [ServiceController::class, 'mypendingservice']);

//my businees account
Route::get('myaccept_busineesaccount',[BusinessAccountController::class,'myacceptaccount']);
Route::get('myrejected_busineesaccount',[BusinessAccountController::class,'myrejectaccount']);
Route::get('mypending_busineesaccount',[BusinessAccountController::class,'mypendingaccount']);

//ratings
Route::post('/ratings', [RatingController::class, 'store']);

//favorites
Route::post('/favorite',[FavoriteController::class,'store']);
Route::get('/myfavorites', [FavoriteController::class, 'index']);
Route::delete('/deletemyfavorite/{id}', [FavoriteController::class, 'delete']);

//sliders
Route::get('/sliders',[ServiceController::class,'viewsliders']);
//reports
Route::post('/reports', [ReportController::class, 'store']);
//chat
Route::post('/conversations', [ConversationController::class, 'store']);
Route::get('/messages/{id}', [MessagesController::class, 'index']);
Route::post('/messages', [MessagesController::class, 'store']);
Route::get('/conversation', [MessagesController::class, 'myconversation']);

});