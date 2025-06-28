<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Models\EmailFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailFolderController extends Controller
{
    public function index()
    {
        $folders = EmailFolder::where('user_id', Auth::id())
            ->withCount('campaigns')
            ->orderBy('name')
            ->get();

        return view('email.folders.index', compact('folders'));
    }

    public function create()
    {
        return view('email.folders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
        ]);

        EmailFolder::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('email.folders.index')
            ->with('success', 'Folder created successfully!');
    }

    public function show(EmailFolder $folder)
    {
        // Ensure user owns this folder
        if ($folder->user_id !== Auth::id()) {
            abort(403);
        }

        $campaigns = $folder->campaigns()
            ->withCount(['recipients as total_recipients'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('email.folders.show', compact('folder', 'campaigns'));
    }

    public function edit(EmailFolder $folder)
    {
        // Ensure user owns this folder
        if ($folder->user_id !== Auth::id()) {
            abort(403);
        }

        return view('email.folders.edit', compact('folder'));
    }

    public function update(Request $request, EmailFolder $folder)
    {
        // Ensure user owns this folder
        if ($folder->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'color' => 'required|string|regex:/^#[0-9A-F]{6}$/i',
        ]);

        $folder->update([
            'name' => $request->name,
            'description' => $request->description,
            'color' => $request->color,
        ]);

        return redirect()->route('email.folders.index')
            ->with('success', 'Folder updated successfully!');
    }

    public function destroy(EmailFolder $folder)
    {
        // Ensure user owns this folder
        if ($folder->user_id !== Auth::id()) {
            abort(403);
        }

        // Move campaigns to "Uncategorized" or delete them
        $folder->campaigns()->update(['email_folder_id' => null]);
        
        $folder->delete();

        return redirect()->route('email.folders.index')
            ->with('success', 'Folder deleted successfully!');
    }
} 