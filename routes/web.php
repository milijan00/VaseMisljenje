<?php

use Illuminate\Support\Facades\Route;


Route::middleware("userAlreadySignedIn")->group(function(){
// HOME
    Route::get("/", [App\Http\Controllers\HomeController::class, "index"])->name("home");
// AUTH
    Route::get("/auth/register", [App\Http\Controllers\AuthController::class, "register"])->name("register");
    Route::post("/auth/create", [App\Http\Controllers\AuthController::class, "createAccount"])->name("createAccount")->middleware("ajaxDataValid");
    Route::post("/auth/login", [App\Http\Controllers\AuthController::class, "login"])->name("login")->middleware("ajaxDataValid");
});

Route::middleware([\App\Http\Middleware\EnsureUserSignedIn::class])->group(function(){
// USER
    Route::get("/user/", [App\Http\Controllers\UserController::class, "index"])->name("profile");
    Route::get("/user/show/{id}", [App\Http\Controllers\UserController::class, "show"])->name("showOtherProfiles");
    Route::get("/user/editprofile", [App\Http\Controllers\UserController::class, "editProfile"])->name("editprofile");
    Route::put("/user/updateProfilePicture", [App\Http\Controllers\UserController::class, "updateProfilePicture"])->name("updateProfilePicture");
    Route::patch("/user/updateprofile", [App\Http\Controllers\UserController::class, "update"])->name("updateProfile");
    Route::get("/user/followers", [App\Http\Controllers\UserController::class, "followers"])->name("followers");
    Route::delete("/user/unfollow/", [App\Http\Controllers\UserController::class, "unfollow"])->name("unfollow");
    Route::post("/user/follow/", [App\Http\Controllers\UserController::class, "follow"])->name("follow");
// CONTACT
    Route::get("/contact", [App\Http\Controllers\ContactController::class, "index"])->name("contact");
    Route::post("/contact/send", [App\Http\Controllers\ContactController::class, "sendemail"])->name("sendEmail");
// AUTHOR
    Route::get("/author", [App\Http\Controllers\AuthorController::class, "index"])->name("author");
    Route::get("/author/get", [App\Http\Controllers\AuthorController::class, "getAuthorInfo"]);
// DISCUSIONS
    Route::get("/discusions", [App\Http\Controllers\DuscusionController::class, "index"])->name("discusions");
    Route::get("/discusions/cat/{id}", [App\Http\Controllers\DuscusionController::class, "showFromCat"])->name("showFromCat");
    Route::get("/discusions/create", [App\Http\Controllers\DuscusionController::class, "create"])->name("newDiscusion");
    Route::post("/discusions/store", [App\Http\Controllers\DuscusionController::class, "store"])->name("storeDiscusion");
    Route::delete("/discusions/delete",  [App\Http\Controllers\DuscusionController::class, "deleteDiscusion"])->name("deleteDiscusion");
    Route::get("/discusions/edit/{id}",  [App\Http\Controllers\DuscusionController::class, "edit"])->name("editDiscusion");
    Route::put("/discusions/update/",  [App\Http\Controllers\DuscusionController::class, "update"])->name("updateDiscsusion");
// COMMENTS
    Route::post("/comments/store", [App\Http\Controllers\CommentController::class, "store"])->name("insertComment");
    Route::delete("/comments/delete/", [App\Http\Controllers\CommentController::class, "delete"])->name("deleteComment");
    Route::get("/comments/edit/{id}", [App\Http\Controllers\CommentController::class, "edit"])->name("editComment");
    Route::put("/comments/update",[App\Http\Controllers\CommentController::class, "updateComment"])->name("updateComment");
//  Likes
    Route::post("/likes/store", [App\Http\Controllers\LikesController::class, "store"])->name("storeLike");
    Route::post("/likes/delete", [App\Http\Controllers\LikesController::class, "deleteLike"])->name("deleteLike");
//   AUTH
    Route::get("/auth/logout", [App\Http\Controllers\AuthController::class, "logout"])->name("logout");
});
