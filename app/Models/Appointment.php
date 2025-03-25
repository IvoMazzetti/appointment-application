<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Appointment extends Model
{
    use HasFactory;

    protected $table = 'appointments';

    protected $fillable = [
        'name',
        'notes',
        'phone',
        'email',
        'date',
        'time',
        'terms_and_conditions',
        'service_id',
        'company_id',
    ];

    public function service(): HasOne
    {
        return $this->HasOne(Service::class, 'id', 'service_id');
    }
}
