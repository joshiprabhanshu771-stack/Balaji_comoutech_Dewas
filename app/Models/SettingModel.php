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
        'created_at',
        'updated_at',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Retrieve all settings as key-value pairs.
     *
     * @return array<string, string|null>
     */
    public function getAllAsMap(): array
    {
        try {
            $builder = $this->db->table($this->table);
            $rows = $builder->get()->getResultArray();

            $map = [];
            foreach ($rows as $row) {
                $map[$row['setting_key']] = $row['setting_value'];
            }
            return $map;
        } catch (\Throwable $e) {
            log_message('error', 'SettingModel::getAllAsMap error: ' . $e->getMessage());
            return [];
        }
    }

    /**
     * Get a single setting value by its key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getVal(string $key, $default = null)
    {
        try {
            $row = $this->db->table($this->table)
                ->where('setting_key', $key)
                ->get()
                ->getRowArray();

            return $row ? $row['setting_value'] : $default;
        } catch (\Throwable $e) {
            log_message('error', "SettingModel::getVal error for '{$key}': " . $e->getMessage());
            return $default;
        }
    }

    /**
     * Set/Upsert a single setting by key and value.
     * Uses a direct query builder instance to prevent model state pollution in loops.
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @return bool
     */
    public function setVal(string $key, $value, string $group = 'general'): bool
    {
        $key = trim($key);
        if ($key === '') {
            return false;
        }

        $now = date('Y-m-d H:i:s');
        $valStr = ($value === null) ? null : (string)$value;

        try {
            $builder = $this->db->table($this->table);
            $existing = $builder->where('setting_key', $key)->get()->getRowArray();

            if ($existing) {
                return (bool)$this->db->table($this->table)
                    ->where('id', $existing['id'])
                    ->update([
                        'setting_value' => $valStr,
                        'setting_group' => $group ?: ($existing['setting_group'] ?? 'general'),
                        'updated_at'    => $now,
                    ]);
            } else {
                return (bool)$this->db->table($this->table)
                    ->insert([
                        'setting_key'   => $key,
                        'setting_value' => $valStr,
                        'setting_group' => $group ?: 'general',
                        'created_at'    => $now,
                        'updated_at'    => $now,
                    ]);
            }
        } catch (\Throwable $e) {
            log_message('error', "SettingModel::setVal failed for '{$key}': " . $e->getMessage());
            return false;
        }
    }

    /**
     * Save multiple settings atomically inside a transaction.
     *
     * @param array<string, mixed> $settings
     * @param array<string, string> $groupMapping
     * @return bool
     */
    public function saveMany(array $settings, array $groupMapping = []): bool
    {
        $db = $this->db;
        $db->transBegin();

        try {
            foreach ($settings as $key => $val) {
                $group = $groupMapping[$key] ?? $this->detectGroup($key);
                $ok = $this->setVal($key, $val, $group);
                if (!$ok) {
                    $db->transRollback();
                    return false;
                }
            }

            if ($db->transStatus() === false) {
                $db->transRollback();
                return false;
            }

            $db->transCommit();

            // Refresh helper cache
            if (function_exists('get_setting')) {
                get_setting('', null, true);
            }

            return true;
        } catch (\Throwable $e) {
            $db->transRollback();
            log_message('error', 'SettingModel::saveMany transaction failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Automatically deduce setting group from setting key.
     *
     * @param string $key
     * @return string
     */
    protected function detectGroup(string $key): string
    {
        if (str_starts_with($key, 'firebase_')) {
            return 'firebase';
        }
        if (str_starts_with($key, 'meta_') || str_starts_with($key, 'seo_')) {
            return 'seo';
        }
        if (str_starts_with($key, 'hero_') || str_starts_with($key, 'home_')) {
            return 'home';
        }
        if (str_contains($key, 'contact') || str_contains($key, 'phone') || str_contains($key, 'whatsapp') || str_contains($key, 'address') || str_contains($key, 'maps')) {
            return 'contact';
        }
        return 'general';
    }
}
