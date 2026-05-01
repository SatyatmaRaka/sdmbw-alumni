<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::orderBy('order_num')->paginate(10);
        return view('admin.faqs.index', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string|max:500',
            'answer' => 'required|string',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        Faq::create($validated);
        Cache::forget('landing_faqs');
        return back()->with('success', 'FAQ berhasil ditambahkan');
    }

    public function update(Request $request, Faq $faq)
    {
        \Log::info('FAQ Update Request:', $request->all());

        $validated = $request->validate([
            'question' => 'required|string|max:500', // dinaikkan dari 255
            'answer' => 'required|string',
            'order_num' => 'nullable|integer',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active');

        $faq->update($validated);
        
        Cache::forget('landing_faqs');
        
        return back()->with('success', 'FAQ berhasil diperbarui');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        Cache::forget('landing_faqs');
        return back()->with('success', 'FAQ berhasil dihapus');
    }
}
