<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactQuery;
use Illuminate\Http\Request;

class ContactQueryController extends Controller
{
    public function store(Request $request)
    {
        $request->merge([
            'company_name' => $request->input('company_name', $request->input('subject')),
            'phone_number' => $request->input('phone_number', $request->input('phone')),
            'comment' => $request->input('comment', $request->input('message')),
        ]);

        $validated = $request->validate([
            'company_name' => ['nullable', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:50'],
            'comment' => ['required', 'string', 'max:5000'],
        ]);

        $contactQuery = ContactQuery::create([
            ...$validated,
            'phone' => $validated['phone_number'],
            'subject' => $validated['company_name'] ?? null,
            'message' => $validated['comment'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Contact query submitted successfully',
            'data' => $contactQuery,
        ], 201);
    }
}
