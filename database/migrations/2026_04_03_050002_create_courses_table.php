<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('description');
            $table->string('short_description');
            $table->string('thumbnail')->nullable();
            $table->decimal('price', 8, 2)->default(0);
            $table->decimal('discount_price', 8, 2)->nullable();
            $table->enum('level', ['beginner', 'intermediate', 'advanced'])->default('beginner');
            $table->string('category');
            $table->json('tags')->nullable();
            $table->foreignId('instructor_id')->constrained()->cascadeOnDelete();
            $table->string('duration')->nullable();
            $table->unsignedInteger('students_count')->default(0);
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->unsignedInteger('reviews_count')->default(0);
            $table->string('language')->default('English');
            $table->date('last_updated')->nullable();
            $table->boolean('is_published')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('courses'); }
};
