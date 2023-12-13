<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSyslogTable extends Migration
{
    public function up(): void
    {
        Schema::connection(config('syslog.connection'))->create('syslogs', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30)->nullable();
            $table->text('description')->nullable();
            $table->string('event', 30);
            $table->nullableMorphs('subject');
            $table->nullableMorphs('causer');
            $table->json('properties')->nullable();
            $table->dateTime('created_at')->useCurrent();

            $table->index('name');
            $table->index('event');
            $table->index('subject_id');
            $table->index('subject_type');
            $table->index('causer_id');
            $table->index('causer_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::connection(config('syslog.connection'))->dropIfExists('syslogs');
    }
};
