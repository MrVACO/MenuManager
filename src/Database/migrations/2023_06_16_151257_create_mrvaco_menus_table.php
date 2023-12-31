<?php

declare(strict_types = 1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use MrVaco\NovaStatusesManager\Classes\StatusClass;
use MrVaco\SomeHelperCode\Enums\LinkTarget;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mrvaco_menus', function(Blueprint $table)
        {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->string('title');
            $table->string('description')->nullable();
            $table->string('slug');
            $table->string('link_target')->default(LinkTarget::Self->value);
            $table->integer('status')->default(StatusClass::DEFAULT_ID());
            $table->integer('sort_order')->nullable();
            $table->timestamps();
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('mrvaco_menus');
    }
};
