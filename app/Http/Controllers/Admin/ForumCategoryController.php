<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ForumCategoryController extends Controller
{
    public function index()
    {
        $forums = Forum::orderBy('order')->get();
        return view('admin.forum.categories', compact('forums'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:forums,name',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'required|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        Forum::create($validated);

        return redirect()->route('admin.forum-categories.index')->with('success', 'Kategori Forum berhasil ditambahkan.');
    }

    public function update(Request $request, Forum $forum)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:forums,name,' . $forum->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'order' => 'required|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $forum->update($validated);

        return redirect()->route('admin.forum-categories.index')->with('success', 'Kategori Forum berhasil diperbarui.');
    }

    public function destroy(Forum $forum)
    {
        if ($forum->threads()->count() > 0) {
            return redirect()->route('admin.forum-categories.index')->with('error', 'Kategori ini tidak bisa dihapus karena masih memiliki thread di dalamnya.');
        }

        $forum->delete();

        return redirect()->route('admin.forum-categories.index')->with('success', 'Kategori Forum berhasil dihapus.');
    }
}
