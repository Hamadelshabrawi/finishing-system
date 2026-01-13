<style>

    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #007bff;
        border-bottom: 3px solid #0056b3;
        padding-bottom: 10px;
        text-transform: uppercase;
    }

    /* Info Sections - More Depth & Elegance */
    .info-section {
        background: white;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0 6px 14px rgba(0,0,0,0.18);
        margin-bottom: 24px;
        transition: all 0.3s ease-in-out;
    }
    .info-section:hover {
        box-shadow: 0 8px 18px rgba(0,0,0,0.25);
        transform: translateY(-3px);
    }

    /* File List - Premium Look */
    .file-list {
        max-height: 450px;
        overflow-y: auto;
        border: 2px solid #dee2e6;
        border-radius: 8px;
        padding: 12px;
        background: #f8f9fa;
    }
    .file-item {
        background: white;
        padding: 12px;
        border-radius: 8px;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.2s ease-in-out;
    }
    .file-item:hover {
        background: #e9ecef;
        transform: scale(1.02);
    }
    .file-info {
        font-size: 1rem;
        font-weight: 500;
        color: #343a40;
    }

    /* Button Upgrades */
    .btn {
        border-radius: 30px;
        padding: 8px 16px;
        font-weight: 600;
        transition: all 0.3s ease-in-out;
    }
    .btn:hover {
        transform: scale(1.08);
    }

    /* Badges - Sleek Look */
    .badge {
        font-size: 1rem;
        padding: 8px 12px;
        font-weight: bold;
        text-transform: uppercase;
    }

    /* Description Panel - High-End Styling */
    .description-content {
        background: #ffffff;
        padding: 18px;
        border-left: 5px solid #007bff;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* Material table styling */
    .material-table th {
        background-color: #007bff;
        color: white;
    }
</style>
<style>
    /* Add to your CSS file */
    .info-section {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .section-title {
        color: #0d6efd;
        padding-bottom: 10px;
        border-bottom: 1px solid #dee2e6;
        margin-bottom: 20px;
    }
</style>

<style>
    .custom-tabs {
        width: 100%;
        position: relative;
        margin: 2rem 0;
    }

    .custom-tabs input[type="radio"] {
        position: absolute;
        opacity: 0;
    }

    .tab-label {
        display: inline-block;
        padding: 12px 20px;
        margin-right: 5px;
        cursor: pointer;
        background: #f1f1f1;
        border-radius: 5px 5px 0 0;
        font-weight: 500;
        color: #555;
        transition: all 0.3s;
        position: relative;
        top: 1px;
        z-index: 1;
    }

    .tab-content {
        display: none;
        padding: 20px;
        border: 1px solid #ddd;
        border-top: none;
        background: #fff;
        position: relative;
        z-index: 0;
        border-radius: 0 5px 5px 5px;
        animation: fadeIn 0.5s ease;
    }

    input[type="radio"]:checked + .tab-label {
        background: #fff;
        border: 1px solid #ddd;
        border-bottom: 1px solid #fff;
        color: #2563eb;
        font-weight: 600;
    }

    input[type="radio"]:checked + .tab-label + .tab-content {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Responsive styles */
    @media (max-width: 768px) {
        .tab-label {
            display: block;
            width: 100%;
            margin-right: 0;
            margin-bottom: 5px;
            border-radius: 5px;
            text-align: center;
            top: 0;
        }

        input[type="radio"]:checked + .tab-label {
            border: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .tab-content {
            border-radius: 0 0 5px 5px;
            border-top: 1px solid #ddd;
        }
    }
</style>