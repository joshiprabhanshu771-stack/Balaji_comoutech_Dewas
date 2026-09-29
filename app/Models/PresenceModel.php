<?php

namespace App\Models;

use CodeIgniter\Model;

class PresenceModel extends Model
{
    protected $table            = 'presence_locations';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'address',
        'address_line1',
        'address_line2',
        'city',
        'state',
        'pincode',
        'phone',
        'alternate_phone',
        'email',
        'landmark',
        'google_maps_embed',
        'google_maps_link',
        'opening_hours',
        'is_primary',
        'is_active',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getPrimaryLocation(): ?array
    {
        try {
            $primary = $this->where('is_primary', 1)->first();
            if (!$primary) {
                $primary = $this->first();
            }
            return $primary;
        } catch (\Throwable $e) {
            log_message('error', 'PresenceModel::getPrimaryLocation error: ' . $e->getMessage());
            return null;
        }
    }
}
