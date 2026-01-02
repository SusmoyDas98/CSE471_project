<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Document;

class DocumentController extends Controller
{
    /**
     * Show the document upload form
     */
    public function index()
    {
        // For testing: use a fake user ID
        $userId = 1; // make sure this user exists in your DB

        // Get the latest document uploaded by this test user
        $document = Document::where('user_id', $userId)->latest()->first();

        return view('document', compact('document'));
    }

    /**
     * Handle document upload
     */
    public function store(Request $request)
    {
        // Validate uploaded files
        $validated = $request->validate([
            'student_id' => 'required|file|max:51200',      // max 50MB
            'government_id' => 'required|file|max:51200',
            'personal_photo' => 'required|file|max:51200',
            'reference' => 'nullable|file|max:51200',
        ]);

        // Store files in storage/app/public/documents
        $studentPath = $request->file('student_id')->store('documents', 'public');
        $governmentPath = $request->file('government_id')->store('documents', 'public');
        $photoPath = $request->file('personal_photo')->store('documents', 'public');
        $referencePath = $request->hasFile('reference') ? $request->file('reference')->store('documents', 'public') : null;

        // Save paths in DB with fake user ID
        $doc = Document::create([
            'dorm_id' => $request->input('dorm_id', 0), // optional dorm id
            'user_id' => 1, // fake test user
            'status' => 'Pending',
            'Student_id' => $studentPath,
            'Government_id' => $governmentPath,
            'Personal_photo' => $photoPath,
            'Reference' => $referencePath,
        ]);

        return redirect()->route('documents.test')->with('status', 'Documents uploaded successfully.');
    }
}
