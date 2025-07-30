<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ContactMessage;

class ContactMessageController extends Controller
{
    public function store(Request $request)
    {
        ContactMessage::create($request->all());

        return redirect()->route('contact')->with('success', 'Your message has been sent successfully!');
    }
    //
}
