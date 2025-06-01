<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $table = 'Teacher';
    protected $primaryKey = 'teacher_id';
    public $timestamps = false;

    protected $fillable = ['name', 'email', 'subject'];

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'teacher_id');
    }
}
