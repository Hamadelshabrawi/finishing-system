@extends('layouts.app')

@section('title') Project Overview: {{ $project->project_name }} @endsection

@section('content')
<div class="min-h-screen bg-gradient-to-br from-blue-50 to-indigo-100 p-4 sm:p-6 lg:p-10 font-inter text-gray-800">
    <div class="container mx-auto max-w-7xl bg-white shadow-3xl rounded-2xl overflow-hidden transform transition-all duration-500 ease-in-out hover:scale-[1.005] hover:shadow-4xl">

        <div class="bg-gradient-to-br from-blue-700 to-purple-800 text-white p-10 sm:p-12 lg:p-16 text-center relative overflow-hidden">
            <div class="absolute inset-0 opacity-15 bg-white transform -skew-y-6 scale-150"></div>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold mb-4 leading-tight tracking-tight drop-shadow-lg relative z-10">
                {{ $project->project_name }}
            </h1>
            <p class="text-blue-200 text-lg sm:text-xl lg:text-2xl font-light relative z-10 max-w-3xl mx-auto">
                A comprehensive overview of your project, detailing its specifications, products, and associated items.
            </p>
            <div class="mt-6 relative z-10">
                <span class="text-blue-100 text-base sm:text-lg">Created on: <span class="font-semibold text-white">{{ \Carbon\Carbon::parse($project->date)->format('F d, Y') }}</span> by <span class="font-semibold text-white">{{ $project->created_by }}</span></span>
            </div>
            <div class="absolute inset-x-0 bottom-0 h-4 bg-blue-600 opacity-60"></div>
        </div>

        <div class="bg-blue-600 text-white py-4 px-6 sm:px-8 lg:px-10 flex flex-wrap justify-around items-center text-center -mt-1 rounded-b-lg">
            <div class="flex-1 min-w-[150px] p-2">
                <p class="text-sm opacity-80">Client ID</p>
                <p class="font-bold text-lg">{{ $project->client_id }}</p>
            </div>
            <div class="flex-1 min-w-[150px] p-2 border-l border-r border-blue-500">
                <p class="text-sm opacity-80">Delivery Date</p>
                <p class="font-bold text-lg">{{ \Carbon\Carbon::parse($project->delivery_date)->format('M d, Y') }}</p>
            </div>
            <div class="flex-1 min-w-[150px] p-2">
                <p class="text-sm opacity-80">Execution Period</p>
                <p class="font-bold text-lg">{{ $project->execution_period }}</p>
            </div>
        </div>

        <div class="p-6 sm:p-8 lg:p-10 bg-white">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 text-center border-b border-gray-200 pb-4">Project Overview</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <div class="detail-card">
                    <span class="detail-label">Delivery Location</span>
                    <span class="detail-value">{{ $project->delivery_location }}</span>
                </div>
                <div class="detail-card">
                    <span class="detail-label">Panel Number</span>
                    <span class="detail-value">{{ $project->panel_number }}</span>
                </div>
                <div class="detail-card">
                    <span class="detail-label">Quantity</span>
                    <span class="detail-value">{{ $project->quantity }}</span>
                </div>
                <div class="detail-card col-span-full">
                    <span class="detail-label">Description</span>
                    <span class="detail-value text-gray-700 font-normal leading-relaxed text-base">{{ $project->description ?? 'No detailed description available for this project.' }}</span>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="detail-card">
                    <span class="detail-label">Print Status</span>
                    <span class="detail-value">{{ $project->print ? 'Printed' : 'Not Printed' }}</span>
                </div>
                <div class="detail-card">
                    <span class="detail-label">Initial Approval</span>
                    <span class="detail-value">
                        <span class="px-4 py-1.5 rounded-full text-sm font-bold {{ $project->initial_approval ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} shadow-sm">
                            {{ $project->initial_approval ? 'Approved' : 'Pending' }}
                        </span>
                    </span>
                </div>
                <div class="detail-card">
                    <span class="detail-label">Technical Approval</span>
                    <span class="detail-value">
                        <span class="px-4 py-1.5 rounded-full text-sm font-bold {{ $project->technical_approval ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} shadow-sm">
                            {{ $project->technical_approval ? 'Approved' : 'Pending' }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="p-6 sm:p-8 lg:p-10 bg-gradient-to-br from-gray-50 to-gray-100 border-t border-gray-200">
            <h2 class="text-3xl sm:text-4xl font-bold text-gray-800 mb-8 text-center border-b-2 border-blue-400 pb-4 relative z-10">
                Products in This Project
                <span class="absolute bottom-0 left-1/2 -translate-x-1/2 w-16 h-1 bg-blue-500 rounded-full opacity-75"></span>
            </h2>

            @if($project->products->isEmpty())
                <div class="text-center text-gray-600 text-lg py-12 bg-white rounded-xl shadow-inner border border-gray-200 flex flex-col items-center justify-center">
                    <svg class="w-16 h-16 text-blue-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    <p class="font-semibold">No products associated with this project yet.</p>
                    <p class="text-sm text-gray-500 mt-2">Add products to see them listed here.</p>
                </div>
            @else
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    @foreach($project->products as $product)
                        <div class="bg-white border border-gray-200 rounded-xl shadow-xl p-6 flex flex-col h-full transform transition-transform duration-300 ease-in-out hover:scale-[1.01] hover:shadow-2xl">
                            <h3 class="text-2xl font-bold text-blue-700 mb-3 border-b-2 border-blue-200 pb-2">{{ $product->name }}</h3>
                            <p class="text-gray-600 mb-4 flex-grow text-base leading-relaxed">{{ $product->description ?? 'No description provided for this product.' }}</p>

                            <h4 class="text-xl font-semibold text-gray-700 mb-3 border-t pt-4 mt-4">Associated Items</h4>
                            @if($product->items->isEmpty())
                                <p class="text-gray-500 text-sm italic py-4 bg-gray-50 rounded-md text-center">No items associated with this product.</p>
                            @else
                                <div class="space-y-4">
                                    @foreach($product->items as $item)
                                        <div class="flex items-center bg-gray-100 rounded-lg p-4 shadow-sm border border-gray-200 hover:bg-gray-200 transition-colors duration-200">
                                            <svg class="h-8 w-8 text-blue-600 mr-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7.071 7.071a2 2 0 010 2.828l-7.071 7.071A2 2 0 007 21H5a2 2 0 01-2-2v-3.586a2 2 0 01.586-1.414L10.586 7.414A2 2 0 0112 7h.01" />
                                            </svg>
                                            <div class="flex-grow">
                                                <p class="font-medium text-gray-800 text-lg">{{ $item->name }} <span class="text-sm text-gray-500 font-normal">({{ $item->unit }})</span></p>
                                                <p class="text-sm text-gray-700">Price: <span class="font-bold text-blue-700">${{ number_format($item->selling_price, 2) }}</span> | Stock: <span class="font-bold text-blue-700">{{ $item->total_stock }}</span></p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    /* Custom shadow classes for more depth */
    .shadow-3xl {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .shadow-4xl {
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25), 0 15px 15px -7px rgba(0, 0, 0, 0.08);
    }

    /* Base styles for detail cards */
    .detail-card {
        @apply bg-gray-50 p-5 rounded-lg shadow-sm border border-gray-200 transition-all duration-200 ease-in-out hover:shadow-md hover:border-blue-400 transform hover:-translate-y-0.5;
    }
    /* Styles for labels within detail cards */
    .detail-label {
        @apply text-sm font-medium text-gray-500 block mb-1 uppercase tracking-wider;
    }
    /* Styles for values within detail cards */
    .detail-value {
        @apply text-xl font-semibold text-gray-900;
    }

    /* Inter font import for a modern look */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
    .font-inter {
        font-family: 'Inter', sans-serif;
    }
</style>
@endsection
