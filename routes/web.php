<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ClaimController;
use App\Models\Blog;

Route::get('/', function () {
    $blogs = Blog::where('status', true)->latest()->get();

    return view('index', compact('blogs'));
})->name('home');

Route::get('/about', function () {
    return view('about', [
        'name' => 'นางสาวธนภรณ์ พรโคกกรวด',
        'date' => '1 มิถุนายน 2547',
    ]);
})->name('about');

Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{id}', [BlogController::class, 'detail'])->name('blog.detail');
Route::get('/blog2', [AdminController::class, 'blog2'])->name('blog2');
Route::get('/from', [AdminController::class, 'create'])->name('from');
Route::post('/insert', [AdminController::class, 'insert'])->name('insert');

// Author prefix routes นักเขียนบทความ
Route::prefix('author')->group(function () {
    Route::get('/blog2', [AdminController::class, 'blog2'])->name('author.blog2');
    Route::get('/create', [AdminController::class, 'create'])->name('author.create');
    Route::post('/insert', [AdminController::class, 'insert'])->name('author.insert');
    Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('author.edit');
    Route::post('/update/{id}', [AdminController::class, 'update'])->name('author.update');
    Route::get('/delete/{id}', [AdminController::class, 'delete'])->name('author.delete');
    Route::get('/change/{id}', [AdminController::class, 'change'])->name('author.change');
});

// Route names for author/create, author/blog2, author/edit/{id}
Route::get('/author/create', [AdminController::class, 'create'])->name('author/create');
Route::get('/author/blog2', [AdminController::class, 'blog2'])->name('author/blog2');
Route::get('/author/edit/{id}', [AdminController::class, 'edit'])->name('edit');
Route::get('/edit/{id}', [AdminController::class, 'edit']);

Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();

        return "เชื่อมต่อฐานข้อมูลสำเร็จ : "
            . DB::connection()->getDatabaseName();

    } catch (\Exception $e) {

        return "เชื่อมต่อฐานข้อมูลไม่สำเร็จ : "
            . $e->getMessage();
    }
});

Route::get('/student/{id}', function ($id) {
    return view('student', ['id' => $id]);
})->name('student.profile');

Route::get('/claim', [ClaimController::class, 'create'])->name('claim.create');
Route::post('/claim', [ClaimController::class, 'store'])->name('claim.store');

Route::get('/blog/{id}/status', [AdminController::class, 'change'])->name('blog.changeStatus');
Route::get('/change/{id}', [AdminController::class, 'change'])->name('change');

Route::post('/update/{id}', [AdminController::class, 'update'])->name('update');

Route::get('/blog/{id}/delete', [BlogController::class, 'delete'])->name('blog.delete');
Route::get('/delete/{id}', [BlogController::class, 'delete'])->name('delete');

Route::fallback(function () {
    return 'ไม่พบหน้าเว็บ';
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');