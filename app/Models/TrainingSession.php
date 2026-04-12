<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingSession extends Model
{
    use HasFactory;

    // These fields allow the 'store' and 'update' functions to work
    protected $fillable = ['user_id', 'title', 'description', 'scheduled_at', 'status', 'amount', 'payment_status'];

    // This links the session to the User who booked it
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
