<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Release extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name', 'description', 'main_text', 'version', 'release_date',
        'media', 'link', 'is_protected', 'project_id'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

public function up()
{
    Schema::create('releases', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->text('description');
        $table->longText('main_text'); // Підтримка HTML
        $table->string('version'); // Від 1.01 до 100.00
        $table->date('release_date');
        $table->string('media')->nullable(); // Файл (зображення або відео)
        $table->string('link')->nullable(); // Посилання
        $table->boolean('is_protected')->default(false); // Приватний реліз
        $table->foreignId('project_id')->constrained(); // Прив'язка до проекту
        $table->timestamps(); // Дата створення, оновлення
        $table->softDeletes(); // Дата видалення
    });
}
