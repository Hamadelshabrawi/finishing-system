<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use Illuminate\Http\Request;

class TranslationController extends Controller
{
    public function index()
    {
        $this->authorize('Manage Translations');
        
        $translations = Translation::orderBy('group')->get();
        
        return view('translations.index', compact('translations'));
    }

    public function create()
    {
        $this->authorize('Manage Translations');
        
        return view('translations.create');
    }

    public function store(Request $request)
    {
        $this->authorize('Manage Translations');
        
        $validated = $request->validate([
            'key' => 'required|string|unique:translations',
            'value_en' => 'required|string',
            'value_ar' => 'required|string',
            'group' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Translation::create($validated);

        return redirect()->route('translations.index')
            ->with('success', __('messages.translation_created'));
    }

    public function edit(Translation $translation)
    {
        $this->authorize('Edit Translation');
        
        return view('translations.edit', compact('translation'));
    }

    public function update(Request $request, Translation $translation)
    {
        $this->authorize('Edit Translation');
        
        $validated = $request->validate([
            'key' => 'required|string|unique:translations,key,' . $translation->id,
            'value_en' => 'required|string',
            'value_ar' => 'required|string',
            'group' => 'required|string',
            'description' => 'nullable|string',
            'is_active' => 'nullable',
        ]);

        // Convert checkbox value to boolean
        $validated['is_active'] = $request->has('is_active');

        $translation->update($validated);

        return redirect()->route('translations.index')
            ->with('success', __('messages.translation_updated'));
    }

    public function destroy(Translation $translation)
    {
        $this->authorize('Manage Translations');
        
        $translation->delete();

        return redirect()->route('translations.index')
            ->with('success', __('messages.translation_deleted'));
    }
}
