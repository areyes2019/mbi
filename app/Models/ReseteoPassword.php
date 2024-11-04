<?php

namespace App\Models;

use CodeIgniter\Model;

class ReseteoPassword extends Model
{
    protected $table            = 'mbi_password_resets';
    protected $primaryKey       = 'email';
    protected $allowedFields    = [
        'token',
        'created_at'
    ];

   
}
