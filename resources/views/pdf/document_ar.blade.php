<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>أمر تشغيل المشروع</title>
    <!-- Google Fonts - Tajawal for Arabic -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <style>
        /* Base styles */
        body {
            font-family: "Tajawal", sans-serif;
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
            padding-right: 0.8rem; /* Slightly reduced from 1rem */
            border-right: 4px solid #3b82f6; /* border-r-4 border-blue-500 */
        }

        /* General Table styles */
        table {
            width: 100%; /* w-full */
            border-collapse: collapse; /* border-collapse */
            font-size: 0.85rem; /* Slightly reduced from 0.875rem */
            text-align: right; /* text-right */
            border-radius: 0.5rem; /* rounded-lg */
            overflow: hidden; /* overflow-hidden */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
        }
        th, td {
            border: 1px solid #d1d5db; /* border-gray-300 */
            padding: 0.6rem; /* Slightly reduced from 0.75rem */
            text-align: center; /* text-center */
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
            text-align: right; /* Ensure text is right-aligned in RTL for labels/values */
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
            padding-right: 0.3rem; /* Reduced from 0.4rem */
            border-right: 3px solid #60a5fa; /* border-r-3 border-blue-400 */
        }

        /* Lists (Final Finishes, Outsourcing) */
        ul.list-disc {
            list-style-type: disc; /* list-disc */
            padding-right: 0.8rem; /* Reduced from 1rem */
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
            border-right: 4px solid #93c5fd; /* border-r-4 border-blue-300 */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
        }

        /* Outsourcing specific styling */
        ul.list-disc li.bg-green-100 {
            background-color: #dcfce7; /* bg-green-100 */
            border-right: 4px solid #86efac; /* border-r-4 border-green-300 */
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
            padding-right: 1.5rem; /* pr-6 */
            color: #374151; /* text-gray-700 */
        }
        #materials-list-container ul li {
            margin-bottom: 1rem; /* space-y-4 */
            background-color: #f3f4f6; /* bg-gray-100 */
            padding: 1rem; /* p-4 */
            border-radius: 0.5rem; /* rounded-lg */
            border-right: 4px solid #9ca3af; /* border-r-4 border-gray-400 */
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); /* shadow-sm */
        }
        #materials-list-container ul li strong.text-blue-700 {
            color: #1d4ed8; /* text-blue-700 */
            font-size: 1rem; /* text-base */
        }
        #materials-list-container ul li ul.list-none {
            list-style-type: none; /* list-none */
            padding-right: 0; /* pr-0 */
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
            أمر تشغيل
        </h1>

        <!-- Project Details Section - Card Layout (First Page) -->
        <div class="section-card" id="project-details-card">
            <h2>
                تفاصيل المشروع
            </h2>
            <div class="overflow-x-auto">
                <table>
                    <thead>
                        <tr>
                            <th>التاريخ</th>
                            <th></th>
                            <th>البند</th>
                            <th></th>
                            <th>الكمية</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>التاريخ</td>
                            <td>{{ \Carbon\Carbon::parse($project->date)->format('Y-m-d') }}</td>
                            <td>البند</td>
                            <td>{{ $project->project_name }}</td>
                            <td>الكمية</td>
                            <td>{{ $project->contact_value }}</td>
                        </tr>
                        <tr>
                            <td>مدة التنفيذ</td>
                            <td>{{ $project->execution_period }} يوم</td>
                            <td>موعد التوريد</td>
                            <td>{{ \Carbon\Carbon::parse($project->delivery_date)->format('Y-m-d') }}</td>
                            <td>مكان التوريد</td>
                            <td>{{ $project->delivery_location }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Project Description Section - Card Layout (First Page) -->
        <div class="section-card" id="project-description-card">
            <h2>
                وصف البند
            </h2>
            <div id="project-description">
                {{ $project->description }}
            </div>
        </div>

        <!-- Contact Information Section - Card Layout (Second Page) -->
        <div class="section-card" id="contact-info-card">
            <h2>
                معلومات التواصل
            </h2>
            <table class="contact-table w-full text-sm rounded-lg overflow-hidden shadow-sm">
                <tbody>
                    <tr class="group-header">
                        <td colspan="2">بيانات الاتصال</td>
                    </tr>
                    <tr>
                        <td style="width: 50%;"><strong>الإسم:</strong></td>
                        <td style="width: 50%;">{{ $project->contacts->name ?? 'غير محدد' }}</td>
                    </tr>
                    <tr>
                        <td><strong>الوظيفة:</strong></td>
                        <td>{{ $project->contacts->position ?? 'غير محدد' }}</td>
                    </tr>
                    <tr>
                        <td><strong>رقم الهاتف:</strong></td>
                        <td>{{ $project->contacts->phone ?? 'غير محدد' }}</td>
                    </tr>
                    <tr>
                        <td><strong>البريد الإلكتروني:</strong></td>
                        <td>{{ $project->contacts->email ?? 'غير محدد' }}</td>
                    </tr>
                    <tr class="group-header">
                        <td colspan="2">معلومات العميل</td>
                    </tr>
                    <tr>
                        <td><strong>الإسم:</strong></td>
                        <td>{{ $project->client->name ?? 'غير محدد' }}</td>
                    </tr>
                    <tr>
                        <td><strong>البريد الإلكتروني:</strong></td>
                        <td>{{ $project->client->email ?? 'غير محدد' }}</td>
                    </tr>
                    <tr>
                        <td><strong>رقم الهاتف:</strong></td>
                        <td>{{ $project->client->phone ?? 'غير محدد' }}</td>
                    </tr>
                    <tr>
                        <td><strong>الشركة:</strong></td>
                        <td>{{ $project->client->company_name ?? 'غير محدد' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Products Section (starts on its own page, each product then on its own page) -->
        <div class="section-card" id="products-section-container">
            <h2>
                المنتجات
            </h2>
            <div id="products-list">
                @foreach($project->products as $product)
                    <div class="product-section">
                        <h3>
                            المنتج {{ $loop->iteration }}: {{ $product->name }}
                        </h3>
                        @if($product->description)
                            <p>
                                <strong>الوصف:</strong> {{ $product->description }}
                            </p>
                        @endif

                        <!-- Final Finishes -->
                        @if($product->finalFinish)
                            <h4>
                                اللمسات النهائية
                            </h4>
                            <ul class="list-disc">
                                @if($product->finalFinish->internal_paint)
                                    <li class="bg-blue-100"><strong>الدهانات الداخلية:</strong> {{ $product->finalFinish->internal_paint }}</li>
                                @endif
                                @if($product->finalFinish->electrostatic)
                                    <li class="bg-blue-100"><strong>الالكتروستاتيك:</strong> {{ $product->finalFinish->electrostatic }}</li>
                                @endif
                                @if($product->finalFinish->pvd)
                                    <li class="bg-blue-100"><strong>PVD:</strong> {{ $product->finalFinish->pvd }}</li>
                                @endif
                                @if($product->finalFinish->polishing)
                                    <li class="bg-blue-100"><strong>الفرش والتلميع:</strong> {{ $product->finalFinish->polishing }}</li>
                                @endif
                            </ul>
                        @endif

                        <!-- Outsourcing Details -->
                        @if($product->outsources->count() > 0)
                            <h4>
                                العمل الخارجي
                            </h4>
                            <ul class="list-disc">
                                @foreach($product->outsources as $outsource)
                                    <li class="bg-green-100">
                                        <strong>الاسم:</strong> {{ $outsource->outsource_name }}،
                                        <strong>الملاحظات:</strong> {{ $outsource->boarder_note }}،
                                        <strong>التكلفة:</strong> {{ $outsource->cost }}،
                                        <strong>الكمية:</strong> {{ $outsource->quantity }}
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                        <!-- Product Items Table -->
                        <h4>
                            العناصر الداخلية للمنتج
                        </h4>
                        <div class="overflow-x-auto">
                            <table>
                                <thead>
                                    <tr>
                                        <th>العنصر</th>
                                        <th>الوحدة</th>
                                        <th>الكمية</th>
                                        <th>ملاحظات</th>
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