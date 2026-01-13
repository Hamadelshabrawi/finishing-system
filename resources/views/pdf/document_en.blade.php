<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Work Order</title>
    <!-- Google Fonts - Inter for English (or keep Tajawal if preferred for consistent look) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Base styles */
        body {
            font-family: "Inter", sans-serif; /* Changed font to Inter for English */
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background-color: #f3f4f6; /* bg-gray-100 */
            padding: 1.5rem; /* Consolidate outer margin here for all screen sizes */
            color: #374151; /* text-gray-800 */
        }
        /* No media query for body padding, keep it consistent */

        /* Container styles */
        .container {
            max-width: 64rem; /* max-w-4xl */
            margin-left: auto; /* mx-auto */
            margin-right: auto; /* mx-auto */
            background-color: #ffffff; /* bg-white */
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1); /* shadow-lg, slightly reduced from shadow-xl */
            border-radius: 0.75rem; /* rounded-xl */
            padding: 1.25rem; /* Slightly reduced from 1.5rem to make internal content denser */
            border: 1px solid #e5e7eb; /* border border-gray-200 */
        }
        @media (min-width: 768px) {
            .container {
                padding: 2rem; /* Reduced from 2.5rem for larger screens */
            }
        }

        /* Main Title */
        h1 {
            text-align: center; /* text-center */
            font-size: 2.1rem; /* Slightly reduced from 2.25rem */
            font-weight: 800; /* font-extrabold */
            color: #1e40af; /* text-blue-800 */
            margin-bottom: 1.5rem; /* Slightly reduced from 2rem */
            padding-bottom: 0.8rem; /* Slightly reduced from 1rem */
            border-bottom: 4px solid #93c5fd; /* border-b-4 border-blue-300 */
            letter-spacing: 0.05em; /* tracking-wide */
            line-height: 1.25; /* leading-tight */
        }

        /* Section Card Layout */
        .section-card {
            background-color: #ffffff; /* bg-white */
            padding: 1.25rem; /* Slightly reduced from 1.5rem */
            border-radius: 0.5rem; /* rounded-lg */
            box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.06); /* Slightly reduced shadow */
            margin-bottom: 1.5rem; /* Reduced from 2rem */
            border: 1px solid #f3f4f6; /* border border-gray-100 */
        }

        /* Specific page breaks for content flow */
        /* Project details and description on first page */
        #project-description-card {
            page-break-after: always; /* Ensures contact info starts on a new page */
        }
        /* Contact info on second page */
        #contact-info-card {
            page-break-after: always; /* Ensures products section starts on a new page */
        }
        /* Products section starts on a new page, each product then on its own page */
        .product-section + .product-section {
            page-break-before: always; /* Ensures each subsequent product is on its own page */
        }
        /* Materials and signature start on a new page */
        #materials-signature-container {
            page-break-before: always;
            page-break-after: auto; /* No page break after the very last section */
        }

        /* Prevent content within cards/sections from breaking across pages */
        .section-card,
        .product-section,
        .contact-table,
        table tbody,
        ul.list-disc {
            page-break-inside: avoid;
        }

        /* Section Titles */
        h2 {
            font-size: 1.4rem; /* Slightly reduced from 1.5rem */
            font-weight: 700; /* font-bold */
            color: #1d4ed8; /* text-blue-700 */
            margin-bottom: 1rem; /* Slightly reduced from 1.25rem */
            padding-left: 0.8rem; /* Changed from padding-right to padding-left for LTR */
            border-left: 4px solid #3b82f6; /* Changed from border-right to border-left for LTR */
            border-right: none; /* Ensure no right border for LTR */
        }

        /* General Table styles */
        table {
            width: 100%; /* w-full */
            border-collapse: collapse; /* border-collapse */
            font-size: 0.85rem; /* Slightly reduced from 0.875rem */
            text-align: left; /* Changed from right for LTR */
            border-radius: 0.5rem; /* rounded-lg */
            overflow: hidden; /* overflow-hidden */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
        }
        th, td {
            border: 1px solid #d1d5db; /* border-gray-300 */
            padding: 0.6rem; /* Slightly reduced from 0.75rem */
            text-align: center; /* Centered for table cells */
        }
        thead th {
            background-color: #2563eb; /* bg-blue-600 */
            color: #ffffff; /* text-white */
            font-weight: 700; /* font-bold */
            font-size: 0.9rem; /* Slightly reduced from 1rem */
        }
        tbody tr {
            background-color: #ffffff; /* bg-white */
            transition-property: background-color; /* transition */
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1); /* ease-in-out */
            transition-duration: 150ms; /* duration-150 */
        }
        tbody tr:hover {
            background-color: #eff6ff; /* hover:bg-blue-50 */
        }
        tbody td {
            font-weight: 500; /* font-medium */
        }
        
        .overflow-x-auto {
            overflow-x: auto;
        }

        /* Contact Table specific styling */
        .contact-table {
            margin-top: 1rem; /* Reduced from 1.5rem */
        }
        .contact-table td {
            text-align: left; /* Changed from right to left for LTR */
        }
        .contact-table td strong {
            font-weight: 700;
        }
        .contact-table tbody tr.group-header td {
            background-color: #f9fafb; /* bg-gray-50 */
            font-weight: 600; /* font-semibold */
            color: #4b5563; /* text-gray-700 */
            text-align: center; /* Center header text */
            padding: 0.5rem; /* Slightly reduced */
        }
        .contact-table tbody tr:not(.group-header):hover {
            background-color: #f3f4f6; /* hover:bg-gray-100 for data rows */
        }

        /* Project Description */
        #project-description {
            background-color: #eff6ff; /* bg-blue-50 */
            border-left: 4px solid #60a5fa; /* border-l-4 border-blue-400 */
            border-right: none; /* Ensure no right border for LTR */
            padding: 0.9rem; /* Slightly reduced from 1rem */
            border-radius: 0.375rem; /* rounded-md */
            color: #1e40af; /* text-blue-800 */
            font-style: italic; /* italic */
            margin-bottom: 0.4rem; /* Slightly reduced from 0.5rem */
            box-shadow: inset 0 1px 2px 0 rgba(0, 0, 0, 0.06); /* Slightly reduced shadow */
            font-size: 0.85rem; /* Slightly reduced */
        }

        /* Product Section */
        .product-section {
            background-color: #ffffff; /* bg-white */
            border-radius: 0.75rem; /* rounded-xl */
            box-shadow: 0 5px 10px -2px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.06); /* Reduced shadow */
            padding: 0.8rem; /* Further reduced from 1rem */
            margin-bottom: 0.8rem; /* Further reduced from 1rem */
            border: 1px solid #dbeafe; /* border border-blue-100 */
        }
        /* Rule for page break before each product section, except the first in the loop */
        .product-section + .product-section {
            page-break-before: always;
        }

        .product-section h3 {
            font-size: 0.95rem; /* Reduced from 1rem */
            font-weight: 700; /* font-bold */
            color: #1d4ed8; /* text-blue-700 */
            margin-bottom: 0.4rem; /* Reduced from 0.5rem */
            padding-bottom: 0.3rem; /* Reduced from 0.4rem */
            border-bottom: 2px solid #bfdbfe; /* border-b-2 border-blue-200 */
        }
        .product-section p {
            background-color: #f9fafb; /* bg-gray-50 */
            padding: 0.5rem; /* Reduced from 0.6rem */
            border-radius: 0.5rem; /* rounded-lg */
            color: #374151; /* text-gray-700 */
            margin-bottom: 0.6rem; /* Reduced from 0.8rem */
            border: 1px solid #e5e7eb; /* border border-gray-200 */
            font-size: 0.75rem; /* Further slightly reduced */
        }
        .product-section p strong {
            color: #111827; /* text-gray-900 */
        }

        /* Sub-section Titles (Final Finishes, Outsourcing, Product Items) */
        h4 {
            font-size: 0.9rem; /* Reduced from 0.95rem */
            font-weight: 600; /* font-semibold */
            color: #2563eb; /* text-blue-600 */
            margin-bottom: 0.3rem; /* Reduced from 0.4rem */
            padding-left: 0.3rem; /* Changed from padding-right for LTR */
            border-left: 3px solid #60a5fa; /* Changed from border-right for LTR */
            border-right: none; /* Ensure no right border for LTR */
        }

        /* Lists (Final Finishes, Outsourcing) */
        ul.list-disc {
            list-style-type: disc; /* list-disc */
            padding-left: 1.25rem; /* Changed from padding-right for LTR */
            padding-right: 0; /* Removed old padding-right */
            margin-bottom: 0.6rem; /* Reduced from 0.8rem */
            color: #374151; /* text-gray-700 */
            font-size: 0.75rem; /* Reduced from 0.8rem */
        }
        ul.list-disc li {
            margin-bottom: 0.3rem; /* Reduced from 0.4rem */
            padding: 0.3rem; /* Reduced from 0.4rem */
            border-radius: 0.375rem; /* rounded-md */
        }
        ul.list-disc li strong {
            font-weight: 700;
        }

        /* Final Finishes specific styling */
        ul.list-disc li.bg-blue-100 {
            background-color: #dbeafe; /* bg-blue-100 */
            border-left: 4px solid #93c5fd; /* Changed from border-right for LTR */
            border-right: none; /* Ensure no right border for LTR */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
        }

        /* Outsourcing specific styling */
        ul.list-disc li.bg-green-100 {
            background-color: #dcfce7; /* bg-green-100 */
            border-left: 4px solid #86efac; /* Changed from border-right for LTR */
            border-right: none; /* Ensure no right border for LTR */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
        }

        /* Product Items Table */
        .product-section .overflow-x-auto table th,
        .product-section .overflow-x-auto table td {
            padding: 0.3rem; /* Reduced from 0.4rem */
            font-size: 0.65rem; /* Reduced from 0.7rem, for compactness */
        }
        .product-section .overflow-x-auto table th {
            background-color: #e5e7eb; /* bg-gray-200 */
            color: #374151; /* text-gray-800 */
            font-weight: 600; /* font-semibold */
        }
        .product-section .overflow-x-auto table tbody tr:hover {
            background-color: #f3f4f6; /* hover:bg-gray-100 */
        }

        /* Common Materials List */
        #materials-list-container ul {
            list-style-type: disc; /* list-disc */
            padding-left: 1.5rem; /* Changed from padding-right for LTR */
            padding-right: 0; /* Removed old padding-right */
            color: #374151; /* text-gray-700 */
        }
        #materials-list-container ul li {
            margin-bottom: 1rem; /* space-y-4 */
            background-color: #f3f4f6; /* bg-gray-100 */
            padding: 1rem; /* p-4 */
            border-radius: 0.5rem; /* rounded-lg */
            border-left: 4px solid #9ca3af; /* Changed from border-right for LTR */
            border-right: none; /* Ensure no right border for LTR */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
        }
        #materials-list-container ul li strong.text-blue-700 {
            color: #1d4ed8; /* text-blue-700 */
            font-size: 1rem; /* text-base */
        }
        #materials-list-container ul li ul.list-none {
            list-style-type: none; /* list-none */
            padding-left: 0; /* Changed from padding-right for LTR */
            padding-right: 0; /* Removed old padding-right */
            margin-top: 0.5rem; /* mt-2 */
            font-size: 0.875rem; /* text-sm */
            color: #4b5563; /* text-gray-600 */
        }
        #materials-list-container ul li ul.list-none li {
            margin-bottom: 0.25rem; /* space-y-1 */
            background-color: transparent; /* Override parent bg */
            padding: 0; /* Override parent padding */
            border: none; /* Override parent border */
            box-shadow: none; /* Override parent shadow */
        }
        #materials-list-container ul li ul.list-none li strong {
            color: #1f2937; /* text-gray-800 */
        }

        /* No common materials message */
        #materials-list-container p {
            color: #6b7280; /* text-gray-500 */
            font-style: italic; /* italic */
            padding: 1rem; /* p-4 */
            background-color: #f9fafb; /* bg-gray-50 */
            border-radius: 0.5rem; /* rounded-lg */
        }

        /* Signature Table */
        .mt-12 {
            margin-top: 3rem; /* mt-12 */
        }
        .w-3\/4 {
            width: 75%; /* w-3/4 */
        }
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }
        .border-t {
            border-top-width: 1px;
        }
        .border-gray-500 {
            border-color: #6b7280;
        }
        .pt-3 {
            padding-top: 0.75rem;
        }
        .text-base {
            font-size: 1rem;
        }
        .text-gray-600 {
            color: #4b5563;
        }
    </style>
</head>
<body class="bg-gray-100 p-4 text-gray-800 md:p-8">
    <div class="container">
        <!-- Main Title -->
        <h1>
            Work Order
        </h1>

        <!-- Project Details Section - Card Layout (First Page) -->
        <div class="section-card" id="project-details-card">
            <h2>
                Project Details
            </h2>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th></th>
                            <th>Project</th>
                            <th></th>
                            <th>Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Date</td>
                            <td>{{ \Carbon\Carbon::parse($project->date)->format('Y-m-d') }}</td>
                            <td>Item</td>
                            <td>{{ $project->project_name }}</td>
                            <td>Quantity</td>
                            <td>{{ $project->contact_value }}</td>
                        </tr>
                        <tr>
                            <td>Execution Period</td>
                            <td>{{ $project->execution_period }} days</td>
                            <td>Delivery Date</td>
                            <td>{{ \Carbon\Carbon::parse($project->delivery_date)->format('Y-m-d') }}</td>
                            <td>Delivery Location</td>
                            <td>{{ $project->delivery_location }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Project Description Section - Card Layout (First Page) -->
        <div class="section-card" id="project-description-card">
            <h2>
                Item Description
            </h2>
            <div id="project-description">
                {{ $project->description }}
            </div>
        </div>

        <!-- Contact Information Section - Card Layout (Second Page) -->
        <div class="section-card" id="contact-info-card">
            <h2>
                Contact Information
            </h2>
            <table class="contact-table w-full text-sm rounded-lg overflow-hidden shadow-sm">
                <tbody>
                    <tr class="group-header">
                        <td colspan="2">Contact Details</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;"><strong>Name:</strong></td>
                        <td style="width: 50%;">{{ $project->contacts->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Position:</strong></td>
                        <td>{{ $project->contacts->position ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone Number:</strong></td>
                        <td>{{ $project->contacts->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ \Illuminate\Support\Str::limit($project->contacts->email ?? 'N/A', 50) }}</td>
                    </tr>
                    <tr class="group-header">
                        <td colspan="2">Client Information</td>
                    </tr>
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $project->client->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Email:</strong></td>
                        <td>{{ \Illuminate\Support\Str::limit($project->client->email ?? 'N/A', 50) }}</td>
                    </tr>
                    <tr>
                        <td><strong>Phone Number:</strong></td>
                        <td>{{ $project->client->phone ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Company:</strong></td>
                        <td>{{ $project->client->company_name ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Products Section (starts on its own page, each product then on its own page) -->
        <div class="section-card" id="products-section-container">
            <h2>
                Products
            </h2>
            <div id="products-list">
                @foreach($project->products as $product)
                    <div class="product-section">
                        <h3>
                            Product {{ $loop->iteration }}: {{ $product->name }}
                        </h3>
                        @if($product->description)
                            <p>
                                <strong>Description:</strong> {{ $product->description }}
                            </p>
                        @endif

                        <!-- Final Finishes -->
                        @if($product->finalFinish)
                            <h4>
                                Final Finishes
                            </h4>
                            <ul class="list-disc">
                                @if($product->finalFinish->internal_paint)
                                    <li class="bg-blue-100"><strong>Internal Paint:</strong> {{ $product->finalFinish->internal_paint }}</li>
                                @endif
                                @if($product->finalFinish->electrostatic)
                                    <li class="bg-blue-100"><strong>Electrostatic:</strong> {{ $product->finalFinish->electrostatic }}</li>
                                @endif
                                @if($product->finalFinish->pvd)
                                    <li class="bg-blue-100"><strong>PVD:</strong> {{ $product->finalFinish->pvd }}</li>
                                @endif
                                @if($product->finalFinish->polishing)
                                    <li class="bg-blue-100"><strong>Brushing and Polishing:</strong> {{ $product->finalFinish->polishing }}</li>
                                @endif
                            </ul>
                        @endif

                        <!-- Outsourcing Details -->
                        @if($product->outsources->count() > 0)
                            <h4>
                                Outsourced Work
                            </h4>
                            <ul class="list-disc">
                                @foreach($product->outsources as $outsource)
                                    <li class="bg-green-100">
                                        <strong>Name:</strong> {{ $outsource->outsource_name }}،
                                        <strong>Notes:</strong> {{ $outsource->boarder_note }}،
                                        <strong>Cost:</strong> {{ $outsource->cost }}،
                                        <strong>Quantity:</strong> {{ $outsource->quantity }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Product Items Table -->
                        <h4>
                            Internal Product Items
                        </h4>
                        <div class="overflow-x-auto">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Unit</th>
                                        <th>Quantity</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->items as $item)
                                        <tr>
                                            <td>{{ $item->item->name }}</td>
                                            <td>{{ $item->item->unit }}</td>
                                            <td>{{ $item->quantity ?? '' }}</td>
                                            <td>{{ $item->item->description ?? '' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</body>
</html>
