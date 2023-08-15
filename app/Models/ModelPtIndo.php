<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelPtIndo extends Model
{
    protected $table      = 'perguruan_tinggi';
    protected $primaryKey = 'id_perguruan_tinggi';

    protected $returnType     = 'array';
}