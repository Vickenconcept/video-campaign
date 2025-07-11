<?php

namespace App\Http\Controllers\Email;

use App\Http\Controllers\Controller;
use App\Models\EmailFolder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmailFolderController extends Controller
{
    public function index(Request $request)
    {
        $query = EmailFolder::where('user_id', Auth::id())
            ->withCount('campaigns');

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $folders = $query->orderBy('name')->paginate(10);

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

    public function show(Request $request, EmailFolder $folder)
    {
        // Ensure user owns this folder
        if ($folder->user_id !== Auth::id()) {
            abort(403);
        }

        $query = $folder->campaigns()
            ->withCount(['recipients as total_recipients']);

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $campaigns = $query->orderBy('created_at', 'desc')->paginate(10);

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