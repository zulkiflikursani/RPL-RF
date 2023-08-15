<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelDosen extends Model
{
    protected $table      = 'dosen';
    protected $primaryKey = 'id';

    protected $returnType     = 'array';
}
