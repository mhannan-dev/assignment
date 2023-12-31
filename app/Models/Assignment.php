<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;
    protected $fillable = ['type','assigned_by',
    'class_model_id','section_id',
    'subject_id','assign_date','description',
    'submission_date','marks','attachment','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_model_id');
    }
    public function files()
    {
        return $this->hasMany(AssignmentAttachment::class);
    }

}
