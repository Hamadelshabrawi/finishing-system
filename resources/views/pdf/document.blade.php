<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Tajawal", sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            padding: 20px;
            background-color: #f9f9f9;
        }
        
        .container {
            background-color: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            max-width: 1000px;
            margin: 0 auto;
        }
        
        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 2px solid #eee;
            font-weight: 700;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 13px;
        }
        
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        
        th {
            background-color: #f2f2f2;
            font-weight: 600;
            color: #444;
        }
        
        .header-row {
            background-color: #e9f7fe;
            font-weight: bold;
        }
        
        .project-title {
            font-size: 16px;
            font-weight: 700;
            color: #2980b9;
            margin-bottom: 5px;
        }
        
        .section-title {
            font-weight: 700;
            color: #2c3e50;
            margin: 20px 0 10px 0;
            padding-right: 5px;
            border-right: 3px solid #3498db;
        }
        
        .description-box {
            background-color: #f8f9fa;
            border: 1px solid #eee;
            padding: 12px;
            border-radius: 5px;
            margin: 15px 0;
            line-height: 1.8;
        }
        
        .signature-table {
            margin-top: 40px;
            width: 100%;
        }
        
        .signature-table td {
            border: none;
            padding: 5px;
            text-align: center;
            vertical-align: bottom;
        }
        
        .signature-line {
            border-top: 1px solid #333;
            width: 70%;
            margin: 0 auto;
            padding-top: 5px;
        }
        
        .checkbox-label {
            margin-left: 8px;
            margin-right: 8px;
        }
        
        .notes-row {
            background-color: #fffde7;
        }
        
        .empty-row td {
            height: 25px;
            border: 1px solid #ddd;
        }


    </style>
</head>
<body>
    <div class="container">
        <h2>أمر تشغيل</h2>
        
        <div class="project-title">{{ $project->item_name }}</div>
        
        <table>
            <tr class="header-row">
                <td width="15%"><strong>التاريخ</strong></td>
                <td width="15%">{{ \Carbon\Carbon::parse($project->date)->format('Y-m-d') }}</td>
                <td width="15%"><strong>البند</strong></td>
                <td width="15%">{{ $project->item_name }}</td>
                <td width="15%"><strong>الكمية</strong></td>
                <td width="15%">{{ $project->quantity }}</td>
            </tr>
            <tr>
                <td><strong>مدة التنفيذ</strong></td>
                <td>{{ $project->execution_period }} يوم</td>
                <td><strong>موعد التوريد</strong></td>
                <td>{{ \Carbon\Carbon::parse($project->delivery_date)->format('Y-m-d') }}</td>
                <td><strong>مكان التوريد</strong></td>
                <td>{{ $project->delivery_location }}</td>
            </tr>
            <tr>
                <td><strong>اسم/رقم اللوحة</strong></td>
                <td>{{ $project->panel_number }}</td>
                <td><strong>طباعة</strong></td>
                <td>
                    <label class="checkbox-label">
                        <input type="checkbox" {{ $project->print == 'one_to_one' ? 'checked="checked"' : '' }}> 1:1
                    </label>
                </td>
                <td>
                    <label class="checkbox-label">
                        <input type="checkbox" {{ $project->print == 'A3' ? 'checked="checked"' : '' }}> A3
                    </label>
                </td>
                <td>
                    <label class="checkbox-label">
                        <input type="checkbox" {{ $project->print == 'A4' ? 'checked="checked"' : '' }}> A4
                    </label>
                </td>
            </tr>
        </table>
        
        <div class="section-title">وصف البند</div>
        <div class="description-box">
            {{ $project->description }}
        </div>
        
        <div class="section-title">الخامات المطلوبة</div>
        <table>
            <tr class="header-row">
                <th width="30%">الخام المطلوب</th>
                <th width="10%">الوحدة</th>
                <th width="10%">الكمية</th>
                <th width="15%">التكلفة</th>
                <th width="20%">موقف المخزون</th>
                <th width="15%">أولوية</th>
            </tr>
            @foreach ($project->materials as $material)
            <tr>
                <td>{{ $material->item->name ?? '' }}</td>
                <td>{{ $material->item->unit ?? '' }}</td>
                <td>{{ $material->quantity }}</td>
                <td>{{ $material->cost ?? '-' }}</td>
                <td>{{ $material->item->total_stock ?? '' }}</td>
                <td>
                    @if($material->item && isset($material->item->total_stock))
                        @if($material->item->total_stock >= $material->quantity)
                            <span style="color: #27ae60;">متوفر</span>
                        @elseif($material->item->total_stock == 0)
                            <span style="color: #e74c3c;">يحتاج شراء</span>
                        @else
                            <span style="color: #f39c12;">جزئي ({{ $material->item->total_stock }})</span>
                        @endif
                    @else
                        <span style="color: #e74c3c;">غير متاح</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        
        <div class="section-title">التشطيب النهائي</div>
        <table>
            <tr>
                <td width="15%"><strong>التشطيب النهائي</strong></td>
                <td width="15%">
                    دهانات داخلية <input type="checkbox" {{ !empty($project->finalFinish->internal_paint) ? 'checked="checked"' : '' }}>
                </td>
                <td width="10%">{{$project->finalFinish->internal_paint ?? ''}}</td>
                <td width="15%">
                    إلكتروستاتيك <input type="checkbox" {{ !empty($project->finalFinish->electrostatic) ? 'checked="checked"' : '' }}>
                </td>
                <td width="10%">{{$project->finalFinish->electrostatic ?? ''}}</td>
                <td width="15%">
                    PVD <input type="checkbox" {{ !empty($project->finalFinish->pvd) ? 'checked="checked"' : '' }}>
                </td>
                <td width="10%">{{$project->finalFinish->pvd ?? ''}}</td>
                <td width="15%">
                    فرش تلميع <input type="checkbox" {{ !empty($project->finalFinish->polishing) ? 'checked="checked"' : '' }}>
                </td>
                <td width="10%">{{$project->finalFinish->polishing ?? ''}}</td>
            </tr>
        </table>
    </div>

    <div class="container">
        <div class="section-title">مصنعيات خارجية</div>
        <table>
            <tr class="header-row">
                <td width="30%">مصنعيات خارجية</td>
                <td width="50%">ملاحظات / اسم اللوحة</td>
                <td width="20%">الكمية</td>
                <td width="20%">التكلفة</td>
            </tr>
            @foreach ($project->outsources as $outsource)
            <tr>
                <td>{{ $outsource->outsource_name }}</td>
                <td>{{ $outsource->boarder_note }}</td>
                <td>{{ $outsource->quantity }}</td>
                <td>{{ $outsource->cost }}</td>
            </tr>
            @endforeach
        </table>
        
        <div class="section-title">ملاحظات عامة</div>
        <table>
            <tr class="notes-row">
                <td>{{$project->generalNote->Note ?? ' '}}</td>
            </tr>
        </table>
        
        <table class="signature-table">
            <tr>
                <td width="33%">
                    <div class="signature-line"></div>
                    <div>مدير الإنتاج</div>
                </td>
                <td width="33%">
                    <div class="signature-line"></div>
                    <div>مسؤول التشغيل</div>
                </td>
                <td width="33%">
                    <div class="signature-line"></div>
                    <div>مدير المشروع</div>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>