<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use App\Models\ProjectFiles;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables; 
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectUpdateMail;



class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('can:Projects List')->only(['index']);
        $this->middleware('can:Create Project')->only(['create', 'store']);
        $this->middleware('can:Edit Project')->only(['edit', 'update']);
        $this->middleware('can:Delete Project')->only(['destroy']);
        $this->middleware('can:Send Project Email')->only(['emailProject']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $projects = Project::with('client')->select('projects.*');
    
            return DataTables::eloquent($projects)
                ->addColumn('client_name', function($project) {
                    return $project->client ? $project->client->name : 'N/A';
                })
                ->addColumn('actions', function($project) {
                    $actions = '';
    
                    if (auth()->user()->can('Project Details')) {
                        $actions .= '<a href="'.route('projects.show', $project->id).'" class="btn btn-info btn-sm">View</a> ';
                    }
    
                    // Check permission for editing project
                    if (auth()->user()->can('Create Project')) {
                        $actions .= '<a href="'.route('projects.edit', $project->id).'" class="btn btn-warning btn-sm">Edit</a> ';
                    }
    
                    // Check permission for deleting project
                    if (auth()->user()->can('Delete Project')) {
                        $actions .= '<form action="'.route('projects.destroy', $project->id).'" method="POST" style="display:inline;">
                                        '.csrf_field().method_field('DELETE').'
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>';
                    }
                    if (auth()->user()->can('Export Project')) {
                        $actions .= '<a href="'.route('projects.export', $project->id).'" class="btn btn-warning btn-sm">Export</a> ';
                    }
                    if (auth()->user()->can('Send Project Email')) {
                        $actions .= '<a href="'.route('projects.email', $project->id).'" class="btn btn-danger btn-sm">Send Email</a> ';
                    }
    
                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    
        return view('projects.index');
    }


    public function exportProject($id)
    {
        $project = Project::with(['materials.item', 'finalFinish'])->findOrFail($id);
    
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
    
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $fontData = $defaultFontConfig['fontdata'];
    
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => array_merge($fontDirs, [resource_path('fonts')]),
            'fontdata' => $fontData + [
            'tajawal' => [
        'R' => 'Tajawal-Regular.ttf',
        'B' => 'Tajawal-Bold.ttf',
        'useOTL' => 0xFF,
        'useKashida' => 75,
    ]
    ],

            'default_font' => 'tajawal',
            'directionality' => 'rtl',
            'margin_top' => 20,
            'margin_right' => 15,
            'margin_left' => 15,
            'margin_bottom' => 20,
        ]);
    
        $html = view('pdf.document', compact('project'))->render();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('project_order_'.$project->id.'.pdf', 'I');
    }
    
    public function emailProject($id)
    {
        $project = Project::with(['initialFiles', 'technicalFiles', 'client'])->findOrFail($id);
        return view('projects.email_form', compact('project'));
    }

    public function sendProjectEmail(Request $request)
    {
        $request->validate([
            'to' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
            'attachments.*' => 'file|max:10240', // 10MB max per file
        ]);
    
        // Process attachments
        $attachments = [];
        
        // Handle existing attachments
        $existingAttachments = $request->input('existing_attachments', []);

        
        // Handle new file uploads
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $path = $file->store('temp_attachments');
                $attachments[] = [
                    'path' => storage_path('app/'.$path),
                    'name' => $file->getClientOriginalName(),
                    'mime' => $file->getClientMimeType()
                ];
            }
        }

        // Create and send email
        $mail = new ProjectUpdateMail(
            $request->subject,
            $request->message,
            $existingAttachments,
            $attachments
        );
    
        Mail::to($request->to)->send($mail);
    
        // Clean up temporary files
        foreach ($attachments as $attachment) {
            if (file_exists($attachment['path'])) {
                unlink($attachment['path']);
            }
        }
    
        return redirect()->back()->with('success', 'Email sent successfully!');
    }

    public function create()
    {
        $clients = Client::all();
        return view('projects.create', compact('clients'));
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'date' => 'required|date',
                'item_name' => 'required|string|max:255',
                'project_name' => 'required|string|max:255',
                'quantity' => 'required|integer|min:1',
                'execution_period' => 'required|integer|min:1',
                'delivery_date' => 'required|date|after_or_equal:date',
                'delivery_location' => 'required|string|max:255',
                'panel_number' => 'required|string|max:255',
                'initial_approval' => 'nullable|in:pending,approved,rejected',
                'technical_approval' => 'required|in:pending,approved,rejected',
                'description' => 'required|string',
                'client_id' => 'required|exists:clients,id',
                'initial_files.*' => 'nullable',
                'technical_files.*' => 'nullable',
            ]);
        } catch (ValidationException $e) {
            
            // Log validation error
            Log::error('Validation Error', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            
            // Return errors as JSON response
            if ($request->ajax()) {
                return response()->json([
                    'message' => 'Validation Error',
                    'errors' => $e->errors()
                ], 422);
            }
    
            // Re-throw the error for non-AJAX requests
            throw $e;
        }


        // Proceed with project saving if validation passes
        $project = new Project();
        $project->created_by = Auth::id();
        $project->project_name = $validated['project_name'];
        $project->fill($validated);
        $project->save();
    
        // Handle Initial Files
        if ($request->hasFile('initial_files')) {
            foreach ($request->file('initial_files') as $file) {
                $path = $file->store('projects/initial_files', 'public');
                $project->initialFiles()->create([
                    'file_path' => $path,
                    'phase' => 'initial',
                    'uploaded_by' => Auth::id()
                ]);
            }
        }
    
        // Handle Technical Files
        if ($request->hasFile('technical_files')) {
            foreach ($request->file('technical_files') as $file) {
                $path = $file->store('projects/technical_files', 'public');
                $project->technicalFiles()->create([
                    'file_path' => $path,
                    'phase' => 'technical',
                    'uploaded_by' => Auth::id()
                ]);
            }
        }
        if ($request->ajax()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to create project!'
            ], 500);
        }
        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }
        

    public function show(Project $project)
    {
        $project->load('products.items');
        return view('projects.show', compact('project'));
    }

    public function edit($id)
    {
        $project = Project::with(['initialFiles', 'technicalFiles', 'client'])->findOrFail($id);
        $clients = Client::all();
    
        return view('projects.edit', compact('project', 'clients'));
    }
    
    public function update(Request $request, $id)
    {
        $project = Project::findOrFail($id);
    
        $project->update($request->except(['initial_files', 'technical_files', 'delete_initial_files', 'delete_technical_files']));

        // Check if approval changed to 'approved'
        if ( $project->technical_approval === 'approved') {
            foreach ($project->materials()->whereNotNull('item_id')->get() as $material) {
                $item = $material->item;
                
                if ($item) {
                    $qtyToConsume = $material->quantity;
                    $purchases = $item->purchases()->where('remaining_quantity', '>', 0)->orderBy('purchase_date')->get();

                    foreach ($purchases as $purchase) {
                        if ($qtyToConsume <= 0) break;

                        $available = $purchase->remaining_quantity;
                        $deduct = min($qtyToConsume, $available);

                        $purchase->remaining_quantity -= $deduct;
                        $purchase->save();

                        $qtyToConsume -= $deduct;
                    }

                    if ($qtyToConsume > 0) {
                        // Not enough stock — you could log a warning or notify
                        Log::warning("Not enough stock for item {$item->name} for Project {$project->id}");
                        // Optionally: create a NeedsPurchase notification
                    }

                    $item->decrement('total_stock', $material->quantity);
                }
            }
        }
    
        if ($request->has('delete_initial_files')) {
            foreach ($request->delete_initial_files as $fileId) {
                $file = ProjectFiles::find($fileId);
                if ($file && !empty($file->path) && Storage::disk('public')->exists($file->path)) {
                    Storage::disk('public')->delete($file->path);
                }
                $file?->delete();
            }
        }
    
        if ($request->has('delete_technical_files')) {
            foreach ($request->delete_technical_files as $fileId) {
                $file = TechnicalFiles::find($fileId);
                if ($file && !empty($file->path) && Storage::disk('public')->exists($file->path)) {
                    Storage::disk('public')->delete($file->path);
                }
                $file?->delete();
            }
        }
    
        if ($request->hasFile('initial_files')) {
            foreach ($request->file('initial_files') as $file) {
                $path = $file->store('projects/initial', 'public');
    
                $project->initialFiles()->create([
                    'file_path' => $path,
                    'phase' => 'initial',
                    'uploaded_by' => Auth::id()
                ]);
            }
        }
    
        if ($request->hasFile('technical_files')) {
            foreach ($request->file('technical_files') as $file) {
                $path = $file->store('projects/technical', 'public');
    
                $project->technicalFiles()->create([
                    'file_path' => $path,
                    'phase' => 'technical',
                    'uploaded_by' => Auth::id()
                ]);
            }
        }
    
        return redirect()->back()->with('success', 'Project updated successfully.');
    }
    
    public function destroy(Project $project)
    {
        // Delete all related files first
        $project->files()->delete();
        
        // Then delete the project
        $project->delete();
        
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }
}
