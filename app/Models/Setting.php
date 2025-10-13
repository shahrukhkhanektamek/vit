<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Database;
class Setting extends Model
{
    const CREATED_AT = 'add_date_time';
    const UPDATED_AT = 'update_date_time';
    protected $table = 'setting';

    public static function get()
    {
        $db = Database::connect();
        $setting = $db->table('setting')->whereIn('name',['main','logo'])->get()->getResultObject();
        return [
            "main"=>json_decode($setting[0]->data),
            "logo"=>json_decode($setting[1]->data),
        ];
    }


    
}
