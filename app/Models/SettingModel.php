<?php

namespace App\Models;

use CodeIgniter\Model;

class SettingModel extends Model
{
    protected $table            = 'settings';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'setting_key',
        'setting_value',
        'setting_group',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllAsMap()
    {
        $all = $this->findAll();
        $map = [];
        foreach ($all as $item) {
            $map[$item['setting_key']] = $item['setting_value'];
        }
        return $map;
    }

    public function getVal($key, $default = null)
    {
        $item = $this->where('setting_key', $key)->first();
        return $item ? $item['setting_value'] : $default;
    }

    public function setVal($key, $value, $group = 'general')
    {
        $existing = $this->where('setting_key', $key)->first();
        if ($existing) {
            return $this->update($existing['id'], ['setting_value' => $value, 'setting_group' => $group]);
        }
        return $this->insert(['setting_key' => $key, 'setting_value' => $value, 'setting_group' => $group]);
    }
}
