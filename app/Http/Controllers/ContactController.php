<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
public function index()
{
    $contact = [
        [
            'name' => 'Engr. Maria Santos',
            'role' => 'Operations Manager',
            'email' => 'maria.santos@example.com',
            'phone' => '0917-123-4567',
        ],
        [
            'name' => 'John Reyes',
            'role' => 'Support Officer',
            'email' => 'john.reyes@example.com',
            'phone' => '0918-234-5678',
        ],
        [
            'name' => 'Ana Dela Cruz',
            'role' => 'Driver Coordinator',
            'email' => 'ana.delacruz@example.com',
            'phone' => '0920-345-6789',
        ],
    ];

    return view('contact', compact('contact'));
}


}
