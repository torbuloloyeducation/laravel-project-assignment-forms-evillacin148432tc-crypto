<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Pages
Route::view('/', 'welcome');
Route::view('/about', 'about');
Route::view('/contact', 'contact');
Route::view('/services', 'services');
Route::view('/showcases', 'showcases');
Route::view('/blog', 'blog');

// Email Form (GET + POST)
Route::match(['get', 'post'], '/emails', function (Request $request) {

    $emails = session('emails', []);

    if ($request->isMethod('post')) {

        // 1. Validate input
        $request->validate([
            'email' => 'required|email',
        ]);

        // 2. Check duplicate
        if (in_array($request->email, $emails)) {
            return back()->with('warning', 'Email already exists.');
        }

        // 3. Limit to 5 emails
        if (count($emails) >= 5) {
            return back()->with('warning', 'Only 5 emails allowed.');
        }

        // 4. Save email
        $emails[] = $request->email;
        session(['emails' => $emails]);

        return back()->with('success', 'Email added.');
    }

    // Show page
    return view('emails', compact('emails'));
});


// Delete email
Route::post('/emails/delete/{index}', function ($index) {

    $emails = session('emails', []);

    if (isset($emails[$index])) {
        unset($emails[$index]); // remove
        session(['emails' => array_values($emails)]); // fix index
    }

    return back()->with('success', 'Email deleted.');
});