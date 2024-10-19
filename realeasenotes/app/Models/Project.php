<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name'];

    public function releases()
    {
        return $this->hasMany(Release::class);
    }
}
public function up()
{
    Schema::create('projects', function (Blueprint $table) {
        $table->id();
        $table->string('name'); // Назва проекту
        $table->timestamps();
    });
}
