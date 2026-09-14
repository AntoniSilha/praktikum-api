<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Blog;
use App\Models\Ticketing;

// // fungsi untuk mendapatkan user, but need authentikasi
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

// disini http method get, menampikan hello world
// dengan parameter name, by default adalah Antoni

// BREAD
// B = BROWSE (menampilkan list data)
// R = READ (menampilkan detail data)
// E = EDIT (mengubah data)
// A = ADD (menambahkan data)
// D = DELETE (menghapus data)


Route::get('/hello-world',function() {
    $name = request()->get('name')?? 'Antoni';

    return response()->json([
        'message' => "Hello World, {$name}"
    ]);
});


// blogs: untuk menampilkan semua data blogs (GET)
// B (Browse): MENAMPILKAN LIST DARIPADA BLOG YANG ADA DI DATABASE
Route::get('/blogs', function() {
    $blogs=Blog::get();


    return  response()->json([
        'data' => $blogs
    ]);
});

// blogs/{id}: untuk menampilkan data blog berdasarkan id (GET)
// R (Read): MENAMPILKAN DETAIL DATA BLOG BERDASARKAN ID
Route::get('/blog/{id}', function($id){
    $blog = Blog::findOrFail($id);

    return response()->json([
        'message' => "Data Blog Berhasil di tampilkan",
        'data' => $blog,
    ]);
});

// blogs/{id}: untuk mengupdate data blog berdasarkan id (PUT)
// E (Edit): MENGUPDATE DATA BLOG BERDASARKAN ID
Route::put('/blog/{id}', function($id){
    $blog = Blog::findOrFail($id);
    $blog->update([
        'title' => request()->input('title'),
        'content' => request()->input('content')
    ]);

    return response()->json([
        'message' => "Data Blog Berhasil di update",
    ]);
});

// blogs: untuk menambahkan data baru (POST)
// A (Add): MENAMBAHKAN DATA BLOG YANG ADA DI DATABASE
Route::post('/blogs', function(){
    $blogs=Blog::create([
    'title' => request()->input('satu'), 
    'content' => request()->input('Lorem Ipsum Blablabla'),
    ]);
    
    return response()->json([
        'message' => "Data Berhasil di tambahkan",
        'data' => $blogs,
    ]);
});

// blogs/{id}: untuk menghapus data blog berdasarkan id (DELETE)
// D (Delete): MENGHAPUS DATA BLOG BERDASARKAN ID
Route::delete('/blog/{id}', function($id){
    $blog = Blog::findOrFail($id);
    $blog->delete();

    return response()->json([
        'message' => "Data Blog Berhasil di hapus",
    ]);
});




//ticketing
Route::get('/ticketing', function(){
    $ticketing = Ticketing::get();
    return response()->json([
        'message' => $ticketing->isEmpty() ? "Data Tiket Tidak Ada" : "Data Tiket Ada",
        'data' => $ticketing
    ]);
});

Route::get('/ticketing/{id}', function($id){
    $ticketing = Ticketing::findOrFail($id);
    return response()->json([
        'message' => "Data Tiket Berhasil di tampilkan",
        'data' => $ticketing
    ]);
});

Route::put('/ticketing/{noAntrian}', function($noAntrian){
    $noAntrian = Ticketing::findOrFail($noAntrian);
    $noAntrian->update([
        'layanan' => request()->input('layanan'),
    ]);

    return response()->json([
        'message' => "Data Antrian Berhasil di update",
        'data' => $noAntrian,
    ]);
});

Route::post('/ticketing', function(){
     $ticketTerakhir = Ticketing::latest('id')->first();

    if ($ticketTerakhir) {
        $nomor = (int) str_replace('INV-', '', $ticketTerakhir->noAntrian) + 1;
    } else {
        $nomor = 1;
    }
    $noAntrian = 'INV-' . str_pad($nomor, 3, '0', STR_PAD_LEFT);

    $ticketing = Ticketing::create([
        'noAntrian' => $noAntrian,
        'layanan' => request()->input('layanan')
    ]);

    return response()->json([
        'message' => "Data Antrian Berhasil di tambahkan",
        'data' => [ 
            'noAntrian' => $ticketing->noAntrian,
            'layanan' => $ticketing->layanan,
        ],
    ]);
});

Route::delete('/ticketing/{noAntrian}', function($noAntrian){
    $ticketing = Ticketing::findOrFail($noAntrian);
    $ticketing->delete();
    return response()->json([
        'message' => "Data Antrian Berhasil di hapus",
    ]);
});