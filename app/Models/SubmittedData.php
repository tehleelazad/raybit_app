<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class SubmittedData extends Model
{
    use HasFactory;
    protected $table = 'submitted_data';
    protected $fillable = ['name', 'email'];
}