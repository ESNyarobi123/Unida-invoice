<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number',
        'issue_date',
        'support_line',
        'client_name',
        'client_company',
        'client_email',
        'client_location',
        'client_mobile',
        'service',
        'website',
        'currency',
        'budget',
        'created_by',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'budget' => 'decimal:2',
    ];
}
