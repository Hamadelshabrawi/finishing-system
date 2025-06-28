<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemLog;

class ClientController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'can:Clients List'])->only('index');
        $this->middleware(['auth', 'can:Create Client'])->only(['create', 'store']);
        $this->middleware(['auth', 'can:Edit Client'])->only(['edit', 'update']);
        $this->middleware(['auth', 'can:Delete Client'])->only('destroy');
        $this->middleware(['auth', 'can:Search Clients'])->only('search');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $clients = Client::select([
                'id', 'name', 'email', 'phone', 'company_name', 'address',
                'tax_number', 'commercial_registration_number', 'type',
                'created_at', 'updated_at', 'deleted_at'
            ]);
            
            return datatables()
                ->eloquent($clients)
                ->addColumn('actions', function($client) {
                    $actions = '';

                    if (auth()->user()->can('Edit Client')) {
                        $actions .= '<a href="'.route('clients.edit', $client->id).'" class="btn btn-warning btn-sm">Edit</a> ';
                    }

                    if (auth()->user()->can('Delete Client')) {
                        $actions .= '<form action="'.route('clients.destroy', $client->id).'" method="POST" style="display:inline;">
                                        '.csrf_field().method_field('DELETE').'
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>';
                    }

                    return $actions;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }
    
        return view('clients.index');
    }
    
    
    public function create()
    {
        return view('clients.create');
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|unique:clients,email',
            'phone' => 'nullable|string',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'commercial_registration_number' => 'nullable|string|max:50',
            'type' => 'required|in:individual,company',
        ]);
    
        $client = new Client();
        $client->fill($validated);
        $client->created_by = auth()->id();
        $client->save();

        // Log client creation
        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'client_created',
            'description' => 'Client created: ' . $validated['name'],
            'data' => [
                'client_id' => $client->id,
                'client_name' => $client->name,
                'client_type' => $client->type,
                'created_by' => auth()->id()
            ]
        ]);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'client' => $client
            ]);
        }
    
        return redirect()->route('clients.index')->with('success', 'Client created successfully!');
    }

    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        
        if (empty($searchTerm)) {
            return response()->json(['clients' => []]);
        }

        $clients = Client::where('name', 'like', '%' . $searchTerm . '%')
            ->orWhere('email', 'like', '%' . $searchTerm . '%')
            ->orWhere('phone', 'like', '%' . $searchTerm . '%')
            ->get(['id', 'name']);

        return response()->json(['clients' => $clients]);
    }
    

    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        // Validating the form inputs
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['nullable', 'email', Rule::unique('clients')->ignore($client->id)],
            'phone' => 'nullable|string|max:15',
            'company_name' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'tax_number' => 'nullable|string|max:50',
            'commercial_registration_number' => 'nullable|string|max:50',
            'type' => 'required|in:individual,company',
        ]);

        // Update the client
        $client->name = $request->name;
        $client->email = $request->email;
        $client->phone = $request->phone;
        $client->company_name = $request->company_name;
        $client->address = $request->address;
        $client->tax_number = $request->tax_number;
        $client->commercial_registration_number = $request->commercial_registration_number;
        $client->type = $request->type;
        $client->save();

        return redirect()->route('clients.index')->with('success', 'Client updated successfully!');
    }

    public function destroy(Client $client)
    {
        // Check if client is being used in any projects
        if ($client->projects()->count() > 0) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete client because it is associated with one or more projects.'
                ], 400);
            }
            return redirect()->back()->with('error', 'Cannot delete client because it is associated with one or more projects.');
        }

        // Log client deletion
        SystemLog::create([
            'user_id' => auth()->id(),
            'action' => 'client_deleted',
            'description' => 'Client deleted: ' . $client->name,
            'data' => [
                'client_id' => $client->id,
                'client_name' => $client->name,
                'client_type' => $client->type
            ]
        ]);

        $client->delete(); // Soft delete the client

        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Client deleted successfully'
            ]);
        }

        return redirect()->route('clients.index')->with('success', 'Client deleted successfully!');
    }

    public function restore($id)
    {
        $client = Client::withTrashed()->find($id);
        $client->restore();
        
        return redirect()->route('clients.index')->with('success', 'Client restored successfully!');
    }
}
