<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up(): void {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt');
            $table->longText('content');
            $table->string('thumbnail')->nullable();
            $table->foreignId('author_id')->constrained('instructors')->cascadeOnDelete();
            $table->json('tags')->nullable();
            $table->string('category');
            $table->date('published_at')->nullable();
            $table->string('reading_time')->nullable();
            $table->boolean('is_published')->default(false);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('blog_posts'); }
};
