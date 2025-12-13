<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;

class DocumentController extends Controller
{
    public function index()
    {
        $document = Document::latest()->first();
        return view('document', compact('document'));
    }

    public function store(Request $request)
    {
        // validate as generic files (DB stores paths only). Keep size limit.
        $validated = $request->validate([
            'student_id' => 'required|file|max:51200',
            'government_id' => 'required|file|max:51200',
            'personal_photo' => 'required|file|max:51200',
            'reference' => 'nullable|file|max:51200',
        ]);

        // store files in storage/app/public/documents and save relative paths
        $studentPath = $request->file('student_id')->store('documents', 'public');
        $governmentPath = $request->file('government_id')->store('documents', 'public');
        $photoPath = $request->file('personal_photo')->store('documents', 'public');
        $referencePath = null;
        if ($request->hasFile('reference')) {
            $referencePath = $request->file('reference')->store('documents', 'public');
        }

        // Map to DB columns (matching the existing MySQL table columns)
        $doc = Document::create([
            'dorm_id' => $request->input('dorm_id'),
            'user_id' => Auth::check() ? Auth::id() : $request->input('user_id'),
            'status' => 'Pending',
            // store relative paths (e.g. "documents/abc.jpg"). Blade constructs public URL via asset('storage/' . $path)
            'Student_id' => $studentPath,
            'Government_id' => $governmentPath,
            'Personal_photo' => $photoPath,
            'Reference' => $referencePath,
        ]);

        return redirect()->route('documents.index')->with('status', 'Documents uploaded successfully.');
    }
}
