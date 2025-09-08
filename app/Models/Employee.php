<?php
//Employee.php
namespace AppModel;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'name', 'posisi', 'department', 'tugas', 'gaji'
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}