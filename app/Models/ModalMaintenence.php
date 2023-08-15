<?php

namespace App\Models;

use CodeIgniter\Model;

class ModalMaintenence extends Model
{
    protected $table      = 'maintenence';
    protected $primaryKey = 'status';

    protected $returnType     = 'array';
}
