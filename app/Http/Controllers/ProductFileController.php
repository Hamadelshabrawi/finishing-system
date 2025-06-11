<?php

namespace App\Http\Controllers;

use App\Models\ProductFile;
use App\Models\Product;
use App\Helpers\FileHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductFileController extends Controller
{
    public function store(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validator = Validator::make($request->all(), [
            'files.*' => 'required|file|max:5120', // 5MB max
            'phase' => 'required|in:initial,technical,final',
            'description' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $files = $request->file('files');
        $phase = $request->input('phase');
        $description = $request->input('description');

        foreach ($files as $file) {
            // Generate a new filename with product ID and timestamp
            $timestamp = now()->format('Y-m-d_H-i-s');
            $newFilename = $productId . '_' . $timestamp . '_' . 
                str_replace(' ', '_', $file->getClientOriginalName());
            
            // Store the file with the new name
            $path = $file->storeAs('products/files', $newFilename);
            
            ProductFile::create([
                'product_id' => $productId,
                'name' => $newFilename,
                'path' => $path,
                'type' => $file->getMimeType(),
                'extension' => $file->getClientOriginalExtension(),
                'original_name' => FileHelper::encodeFilename($file->getClientOriginalName()),
                'size' => $file->getSize(),
                'description' => $description,
                'phase' => $phase,
            ]);
        }

        return redirect()->back()->with('success', 'Files uploaded successfully');
    }

    public function destroy($productId, $id)
    {
        $product = Product::findOrFail($productId);
        $file = ProductFile::findOrFail($id);

        if ($file->product_id !== (int)$productId) {
            abort(404);
        }

        if (Storage::exists($file->path)) {
            Storage::delete($file->path);
        }
        $file->delete();
        return redirect()->back()->with('success', 'File deleted successfully');
    }

    public function download($id)
    {
        $file = ProductFile::findOrFail($id);
        
        return Storage::download($file->path, FileHelper::decodeFilename($file->original_name));
    }
}
