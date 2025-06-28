<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Client;
use App\Models\ProjectFiles;
use App\Models\ProjectContact;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\Facades\DataTables; 
use App\Models\SystemLog;
use App\Models\Item;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProjectUpdateMail;



class ProjectController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:Projects List')->only(['index']);
        $this->middleware('can:Create Project')->only(['create', 'store']);
        $this->middleware('can:Edit Project')->only(['edit', 'update']);
        $this->middleware('can:Delete Project')->only(['destroy']);
        $this->middleware('can:Send Project Email')->only(['emailProject']);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $projects = Project::with(['client', 'products', 'creator'])
                ->select([
                    'projects.id',
                    'projects.date',
                    'projects.project_name',
                    'projects.technical_approval',
                    'projects.delivery_date',
                    'projects.created_by',
                    'projects.created_at',
                    'projects.updated_at'
                ])
                ->latest();
    
            return DataTables::eloquent($projects)
                ->addColumn('client_name', function($project) {
                    return optional($project->client)->name ?? 'N/A';
                })
                ->addColumn('product_count', function($project) {
                    return $project->products->count();
                })
                ->addColumn('status', function($project) {
                    return $project->statusBadge;
                })
                ->addColumn('creator_name', function($project) {
                    return optional($project->creator)->name ?? 'System';
                })
                ->addColumn('actions', function($project) {
                    $actions = '<div class="action-buttons">';
    
                    if (auth()->user()->can('View Project Details')) {
                        $actions .= '<a href="'.route('projects.show', $project->id).'" 
                                    class="btn btn-info btn-sm" 
                                    title="View Details">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                        <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13 13 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5s3.879 1.168 5.168 2.457A13 13 0 0 1 14.828 8q-.086.13-.195.288c-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5s-3.879-1.168-5.168-2.457A13 13 0 0 1 1.172 8z"/>
                                        <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                    </svg>
                                </a> ';
                    }
    
                    if (auth()->user()->can('Create Project')) {
                        $actions .= '<a href="'.route('projects.edit', $project->id).'" 
                                    class="btn btn-warning btn-sm" 
                                    title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
  <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
  <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
</svg>
                                </a> ';
                    }
    
                    if (auth()->user()->can('Export Project')) {
                        $actions .= '<a href="'.route('projects.export', $project->id).'" 
                                    class="btn btn-secondary btn-sm" 
                                    title="Export">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" class="bi bi-file-arrow-down-fill" viewBox="0 0 16 16">
  <path d="M12 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2M8 5a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 9.293V5.5A.5.5 0 0 1 8 5"/>
</svg>
                                </a> ';
                    }
    
                    if (auth()->user()->can('Send Project Email')) {
                        $actions .= '<a href="'.route('projects.email', $project->id).'" 
                                    class="btn btn-primary btn-sm" 
                                    title="Send Email">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" class="bi bi-envelope-at" viewBox="0 0 16 16">
  <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2zm3.708 6.208L1 11.105V5.383zM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2z"/>
  <path d="M14.247 14.269c1.01 0 1.587-.857 1.587-2.025v-.21C15.834 10.43 14.64 9 12.52 9h-.035C10.42 9 9 10.36 9 12.432v.214C9 14.82 10.438 16 12.358 16h.044c.594 0 1.018-.074 1.237-.175v-.73c-.245.11-.673.18-1.18.18h-.044c-1.334 0-2.571-.788-2.571-2.655v-.157c0-1.657 1.058-2.724 2.64-2.724h.04c1.535 0 2.484 1.05 2.484 2.326v.118c0 .975-.324 1.39-.639 1.39-.232 0-.41-.148-.41-.42v-2.19h-.906v.569h-.03c-.084-.298-.368-.63-.954-.63-.778 0-1.259.555-1.259 1.4v.528c0 .892.49 1.434 1.26 1.434.471 0 .896-.227 1.014-.643h.043c.118.42.617.648 1.12.648m-2.453-1.588v-.227c0-.546.227-.791.573-.791.297 0 .572.192.572.708v.367c0 .573-.253.744-.564.744-.354 0-.581-.215-.581-.8Z"/>
</svg>
                                </a> ';
                    }
    
                    if (auth()->user()->can('Delete Project')) {
                        $actions .= '<form action="'.route('projects.destroy', $project->id).'" 
                                    method="POST" class="d-inline">
                                    '.csrf_field().'
                                    '.method_field('DELETE').'
                                    <button type="submit" 
                                        class="btn btn-danger btn-sm delete-btn" 
                                        title="Delete">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="8" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
  <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
  <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
</svg>
                                    </button>
                                </form>';
                    }
    
                    $actions .= '</div>';
                    return $actions;
                })
                ->editColumn('date', function($project) {
                    return $project->date ? $project->date->format('d M Y') : 'N/A';
                })
                ->editColumn('delivery_date', function($project) {
                    return $project->delivery_date ? $project->delivery_date->format('d M Y') : 'N/A';
                })
                ->editColumn('technical_approval', function($project) {
                    return ucfirst($project->technical_approval);
                })
                ->rawColumns(['status', 'actions'])
                ->make(true);
        }
    
        return view('projects.index');
    }


    public function exportProject($id)
    {
        $project = Project::with(['materials.item'])->findOrFail($id);
    
        $defaultConfig = (new \Mpdf\Config\ConfigVariables())->getDefaults();
        $fontDirs = $defaultConfig['fontDir'];
    
        $defaultFontConfig = (new \Mpdf\Config\FontVariables())->getDefaults();
        $config = [
            'margin_top' => 20,
            'margin_right' => 15,
            'margin_left' => 15,
            'margin_bottom' => 20,
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => array_merge($fontDirs, [resource_path('fonts')]),
            'fontdata' => array_merge($defaultFontConfig['fontdata'], [
                'tajawal' => [
                    'R' => 'Tajawal-Regular.ttf',
                    'B' => 'Tajawal-Bold.ttf',
                    'useOTL' => 0xFF,
                    'useKashida' => 75,
                ]
            ])
        ];

        $mpdf = new \Mpdf\Mpdf($config);
        if (request()->segment(3) === 'ar') {
            $html = view('pdf.document_ar', compact('project'))->render();
        } else {
            $html = view('pdf.document_en', compact('project'))->render();
        }
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
        $validated = $request->validate([
            'date' => 'required|date',
            'project_name' => 'required|string|max:255',
            'contact_value' => 'required|string|max:255',
            'execution_period' => 'required|integer|min:1',
            'delivery_date' => 'required|date|after_or_equal:date',
            'delivery_location' => 'required|string|max:255',
            'technical_approval' => 'required|in:pending,approved,need_modify,dismissed',
            'description' => 'required|string',
            'client_id' => 'required|exists:clients,id',
            'initial_files.*' => 'nullable',
            'contacts.*.name' => 'required_with:contacts',
            'contacts.*.position' => 'required_with:contacts',
            'contacts.*.phone_number' => 'nullable',
            'contacts.*.email' => 'nullable|email',
            'contacts.*.department' => 'nullable|string|max:255',
        ], [
            'client_id.required' => 'Please select a client for this project',
            'client_id.exists' => 'Selected client does not exist',
            'contacts.*.name.required_with' => 'Name is required for each contact',
            'contacts.*.position.required_with' => 'Position is required for each contact'
        ]);

        try {
            // Create project
            $project = new Project();
            $project->created_by = Auth::id();
            $project->fill($validated);
            $project->save();

            // Save single contact if provided
            if ($request->has('contacts')) {
                $contactData = $request->input('contacts')[0] ?? [];
                if (!empty($contactData)) {
                    $project->contacts()->create($contactData);
                }
            }

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

            // Log the project creation
            SystemLog::create([
                'user_id' => Auth::id(),
                'action' => 'project_created',
                'description' => 'Project created: ' . $validated['project_name'],
                'data' => json_encode(['project_id' => $project->id, 'project_name' => $validated['project_name']]),
                'project_id' => $project->id
            ]);

            return redirect()->route('projects.index')->with('success', 'Project created successfully!');

        } catch (\Exception $e) {
            Log::error('Project Creation Error', [
                'error' => $e->getMessage(),
                'request_data' => $request->all()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Failed to create project! ' . $e->getMessage()
                ], 500);
            }

            return back()->withInput()->withErrors(['error' => 'Failed to create project!']);
        }

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
    $project = Project::with(['contacts'])->findOrFail($project->id);
    $items = Item::all();
    return view('projects.show', compact('project', 'items'));
}

public function edit($id)
{
    $project = Project::with(['initialFiles', 'technicalFiles', 'client'])->findOrFail($id);
    $clients = Client::all();

    return view('projects.edit', compact('project', 'clients'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'contacts.*.name' => 'required_with:contacts',
        'contacts.*.position' => 'required_with:contacts',
        'contacts.*.phone_number' => 'nullable',
        'contacts.*.email' => 'nullable|email',
        'contacts.*.department' => 'nullable|string|max:255',
    ], [
        'contacts.*.name.required_with' => 'Name is required for each contact',
        'contacts.*.position.required_with' => 'Position is required for each contact',
    ]);

    try {
        $project = Project::findOrFail($id);

        // Get the data from request

        // Log the incoming data for debugging
        Log::info('Update request data:', [
            'project_id' => $id,
            'request_data' => $request->all()
        ]);

        // Convert string values to constants for approval fields
        if ($request->has('technical_approval')) {
            $approval = $request->input('technical_approval');
            switch ($approval) {
                case 'need_modify':
                    $approvalConstant = Project::APPROVAL_NEED_MODIFY;
                    break;
                case 'dismissed':
                    $approvalConstant = Project::APPROVAL_DISMISSED;
                    break;
                case 'approved':
                    $approvalConstant = Project::APPROVAL_APPROVED;
                    break;
                default:
                    $approvalConstant = Project::APPROVAL_PENDING;
            }
            $request->merge([
                'technical_approval' => $approvalConstant
            ]);
        }

        // Log the processed data for debugging
        Log::info('Processed data:', [
            'request_data' => $request->all(),
            'project_id' => $id
        ]);

        $validated = $request->validate([
            'project_name' => 'required|string|max:255',
            'date' => 'required|date',
            'contact_value' => 'required|numeric|min:0',
            'execution_period' => 'required|numeric|min:0',
            'delivery_date' => 'required|date|after_or_equal:date',
            'technical_approval' => 'required|string|in:need_modify,dismissed,approved,pending',
            'delivery_location' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
            'description' => 'nullable|string',
            'contacts.*.name' => 'required_with:contacts',
            'contacts.*.position' => 'required_with:contacts',
            'contacts.*.phone_number' => 'nullable',
            'contacts.*.email' => 'nullable|email',
            'contacts.*.department' => 'nullable|string|max:255'
        ]);

        // Handle contacts first
        if ($request->has('contacts')) {
            foreach ($request->contacts as $contactData) {
                if (isset($contactData['id'])) {
                    // Update existing contact
                    $contact = ProjectContact::find($contactData['id']);
                    if ($contact) {
                        $contact->update($contactData);
                    }
                } else {
                    // Create new contact
                    $project->contacts()->create($contactData);
                }
            }
        }

        // Update project data
        $project->update($validated);

        // Check if approval changed to 'approved'
        if ($project->technical_approval === Project::APPROVAL_APPROVED) {
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

                    // Update the remaining quantity in purchases table
                    $item->purchases()->where('remaining_quantity', '>', 0)
                        ->orderBy('purchase_date')
                        ->update([
                            'remaining_quantity' => DB::raw('remaining_quantity - ' . $material->quantity)
                        ]);

                    // Update technical approval to need_modify if insufficient stock
                    if ($qtyToConsume > 0) {
                        $project->technical_approval = Project::APPROVAL_NEED_MODIFY;
                        $project->save();
                    }
                }
            }
        }

        // Handle file deletions
        if ($request->has('delete_initial_files')) {
            foreach ($request->delete_initial_files as $fileId) {
                $file = ProjectFiles::find($fileId);
                if ($file && !empty($file->path) && Storage::disk('public')->exists($file->path)) {
                    Storage::disk('public')->delete($file->path);
                }
                $file?->delete();
            }
        }

        // Handle file uploads
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


        return redirect()->back()->with('success', 'Project updated successfully.');

    } catch (\Exception $e) {
        Log::error('Project update failed:', [
            'error' => $e->getMessage(),
            'project_id' => $id,
            'request_data' => $request->all()
        ]);
        throw $e;
    }
}

public function destroy(Project $project)
{
    // Delete all associated contacts
    $project->contacts()->delete();

    // Delete all related files
    $project->files()->delete();
    $project->SystemLog()->delete();

    // Delete technical files
    $project->technicalFiles()->delete();

    // Delete initial files
    $project->initialFiles()->delete();

    // Delete all products and their notes
    foreach ($project->products as $product) {
        $product->notes()->delete();
        $product->delete();
    }
    $project->delete();
    return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
}
}
