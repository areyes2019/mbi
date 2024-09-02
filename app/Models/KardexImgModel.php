<?php

namespace App\Models;

use CodeIgniter\Model;

class KardexImgModel extends Model
{
    protected $table            = 'mbi_kardex_img';
    protected $primaryKey       = 'id_img';
    protected $allowedFields    = [

        'img',
        'id_kardex'
    ];

}
