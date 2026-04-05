<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::view('/', 'welcome');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::view('/services', 'services');
Route::view('/showcases', 'showcases');
Route::view('/blog', 'blog');

Route::match(['get', 'post'], '/emails', function (Request $request) {
    if ($request->isMethod('post')) {
        $request->validate([
            'email' => 'required|email',
        ]);

        $emails = session('emails', []);

        if (count($emails) >= 5) {
            return back()->with('warning', 'Maximum of 5 emails only.');
        }

        if (in_array($request->email, $emails)) {
            return back()->with('warning', 'Email already exists.');
        }

        $emails[] = $request->email;
        session(['emails' => $emails]);

        return back()->with('success', 'Email added successfully.');
    }

    return view('emails', [
        'emails' => session('emails', [])
    ]);
});

Route::post('/emails/delete/{index}', function ($index) {
    $emails = session('emails', []);

    if (isset($emails[$index])) {
        unset($emails[$index]);
        session(['emails' => array_values($emails)]);
    }

    return back()->with('success', 'Email deleted successfully.');
});