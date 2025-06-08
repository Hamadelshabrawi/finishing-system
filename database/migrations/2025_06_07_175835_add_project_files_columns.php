<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectFilesColumns extends Migration
{
    public function up()
    {
        Schema::table('project_files', function (Blueprint $table) {
            $table->string('file_name')->nullable()->after('file_path');
            $table->string('mime_type')->nullable()->after('file_name');
            $table->text('notes')->nullable()->after('mime_type');
            $table->string('phase')->default('initial')->after('notes');
            $table->index(['phase', 'project_id']);
            $table->index(['created_at']);
        });
    }

    public function down()
    {
        Schema::table('project_files', function (Blueprint $table) {
            $table->dropColumn(['file_name', 'mime_type', 'notes', 'phase']);
            $table->dropIndex(['phase_project_id_index']);
            $table->dropIndex(['created_at_index']);
        });
    }
}
