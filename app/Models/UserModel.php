<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['uuid','email', 'password','role','status','name','phone', 'created_at', 'updated_at', 'deleted_at'];
}
