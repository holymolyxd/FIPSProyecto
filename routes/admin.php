<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RolesController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\PostsController;
use App\Http\Controllers\Admin\CommentsController;

Route::prefix('/admin')->group(function (){
    Route::get('/', [DashboardController::class, 'getDashboard'])->name('dashboard');
    Route::get('/reportUsers',[DashboardController::class,'reportUsers'])->name('reportUsers');
    Route::get('/reportRoles',[DashboardController::class,'reportRoles'])->name('reportRoles');
    Route::get('/reportPermissions',[DashboardController::class,'reportPermissions'])->name('reportPermissions');

    //Module Users
    Route::get('/users/{status}', [UserController::class, 'getUsers'])->name('user_list');
    Route::get('/user/add', [UserController::class, 'getUserAdd'])->name('user_add');
    Route::post('/user/add', [UserController::class, 'postUserAdd'])->name('user_add');
    Route::post('/user/search', [UserController::class, 'postUserSearch'])->name('user_search');
    Route::get('/user/{id}/delete', [UserController::class, 'getUserDelete'])->name('user_delete');
    Route::get('/user/{id}/restore', [UserController::class, 'getUserRestore'])->name('user_delete');
    Route::get('/user/{id}/edit', [UserController::class, 'getUserEdit'])->name('user_edit');
    Route::put('/user/{id}/edit',[UserController::class, 'postUsersEdit'])->name('user_edit');
    #Route::get('/user/{id}/auditing', [UserController::class, 'getUserAuditing'])->name('user_auditing');
    Route::get('/user/{id}/permissions', [UserController::class, 'getUsersPermissions'])->name('user_permissions');
    Route::post('/user/{id}/permissions', [UserController::class, 'postUsersPermissions'])->name('user_permissions');

    //Module Roles
    Route::get('/roles/{status}', [RolesController::class, 'getRoles'])->name('role_list');
    Route::get('/role/{id}/edit', [RolesController::class, 'getRoleEdit'])->name('role_edit');
    Route::put('/role/{id}/edit',[RolesController::class, 'postRolesEdit'])->name('role_edit');
    Route::get('/role/add', [RolesController::class, 'getRoleAdd'])->name('role_add');
    Route::post('/role/add', [RolesController::class, 'postRoleAdd'])->name('role_add');
    Route::post('/role/search', [RolesController::class, 'postRoleSearch'])->name('role_search');
    Route::get('/role/{id}/delete', [RolesController::class, 'getRoleDelete'])->name('role_delete');
    Route::get('/role/{id}/restore', [RolesController::class, 'getRoleRestore'])->name('role_delete');
    Route::get('/role/{id}/auditing', [RolesController::class, 'getRoleAuditing'])->name('role_auditing');

    //Module Permissions
    Route::get('/permissions/{status}', [PermissionController::class, 'getPermissions'])->name('permission_list');
    Route::get('/permission/{id}/edit', [PermissionController::class, 'getPermissionEdit'])->name('permission_edit');
    Route::put('/permission/{id}/edit', [PermissionController::class, 'postPermissionEdit'])->name('permission_edit');
    Route::get('/permission/add', [PermissionController::class, 'getPermissionAdd'])->name('permission_add');
    Route::post('/permission/add', [PermissionController::class, 'postPermisssionAdd'])->name('permission_add');
    Route::post('/permission/search', [PermissionController::class, 'postPermissionsSearch'])->name('permission_search');
    Route::get('/permission/{id}/delete', [PermissionController::class, 'getPermissionDelete'])->name('permission_delete');
    Route::get('/permission/{id}/restore', [PermissionController::class, 'getPermissionRestore'])->name('permission_delete');
    Route::get('/permission/{id}/auditing', [PermissionController::class, 'getPermissionAuditing'])->name('permission_auditing');

    //Modulo Regions
    //Route::get('/regions', [RegionController::class, 'getRegions'])->name('region_list');

    //Modulo Communes
    //Route::get('/communes', [CommuneController::class, 'getCommunes'])->name('commune_list');

    //Modulo de Publicaciones
    Route::get('/posts', [PostsController::class, 'getPosts'])->name('posts_list');
    Route::get('/post/{id}/edit', [PostsController::class, 'getPostEdit'])->name('post_edit');
    Route::put('/post/{id}/edit', [PostsController::class, 'postPostEdit'])->name('post_edit');
    Route::post('/post/search', [PostsController::class, 'postPostSearch'])->name('posts_search');
    Route::get('/post/{id}/auditing', [PostsController::class, 'getPostsAuditing'])->name('posts_auditing');

    //Modulo de Comentarios
    Route::get('/comments', [CommentsController::class, 'getComments'])->name('comments_list');
    Route::get('comment/{id}/edit', [CommentsController::class, 'getCommentEdit'])->name('comment_edit');
    Route::put('/comment/{id}/edit', [CommentsController::class, 'postCommentEdit'])->name('comment_edit');
    Route::post('/comment/search', [CommentsController::class, 'postCommentSearch'])->name('comment_search');
    Route::get('/comment/{id}/auditing', [CommentsController::class, 'getCommentsAuditing'])->name('comment_auditing');
});
