<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ContactQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactQueryController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $query = ContactQuery::create($validator->validated());

        return response()->json([
            'status' => true,
            'message' => 'Contact query saved successfully',
            'data' => $query,
        ], 201);
    }
}
