<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run()
    {
        $settings = [
            ['setting_key' => 'site_name', 'setting_value' => 'Balaji Computech', 'setting_group' => 'general'],
            ['setting_key' => 'site_tagline', 'setting_value' => 'Your Trusted Tech Partner for Sales, Service & CCTV Solutions', 'setting_group' => 'general'],
            ['setting_key' => 'owner_name', 'setting_value' => 'Gourav Joshi', 'setting_group' => 'general'],
            ['setting_key' => 'contact_phone', 'setting_value' => '+91 98260 12345', 'setting_group' => 'contact'],
            ['setting_key' => 'whatsapp_number', 'setting_value' => '919826012345', 'setting_group' => 'contact'],
            ['setting_key' => 'contact_email', 'setting_value' => 'info@balajicomputech.com', 'setting_group' => 'contact'],
            ['setting_key' => 'shop_address', 'setting_value' => 'Shop No. 12, Mainashree Complex, Near Netram, AB Road, Dewas, Madhya Pradesh - 455001', 'setting_group' => 'contact'],
            ['setting_key' => 'opening_hours', 'setting_value' => 'Monday - Saturday: 10:00 AM - 08:30 PM | Sunday: 11:00 AM - 04:00 PM', 'setting_group' => 'general'],
            ['setting_key' => 'facebook_url', 'setting_value' => 'https://facebook.com', 'setting_group' => 'social'],
            ['setting_key' => 'instagram_url', 'setting_value' => 'https://instagram.com', 'setting_group' => 'social'],
            ['setting_key' => 'youtube_url', 'setting_value' => 'https://youtube.com', 'setting_group' => 'social'],
            ['setting_key' => 'google_maps_embed', 'setting_value' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14705.89069151219!2d76.0465!3d22.9654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39631745456789%3A0x123456789abcdef!2sMainashree%20Complex%2C%20AB%20Road%2C%20Dewas%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1600000000000!5m2!1sen!2sin" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>', 'setting_group' => 'contact'],
            ['setting_key' => 'meta_title', 'setting_value' => 'Balaji Computech - Best Computer Shop & Repair Center in Dewas', 'setting_group' => 'seo'],
            ['setting_key' => 'meta_description', 'setting_value' => 'Balaji Computech is Dewas\'s leading computer store for laptops, custom gaming PCs, CCTV security cameras, printer repairs, and IT hardware components.', 'setting_group' => 'seo'],
            ['setting_key' => 'hero_title', 'setting_value' => 'Premium Computers, Custom PCs & Pro Repair Services', 'setting_group' => 'home'],
            ['setting_key' => 'hero_subtitle', 'setting_value' => 'Welcome to Balaji Computech, Dewas. Discover top brand laptops, high-performance desktop components, security CCTV systems, and expert chip-level repairing.', 'setting_group' => 'home'],
        ];

        foreach ($settings as $setting) {
            $existing = $this->db->table('settings')->where('setting_key', $setting['setting_key'])->get()->getFirstRow();
            if ($existing) {
                $this->db->table('settings')->where('setting_key', $setting['setting_key'])->update([
                    'setting_value' => $setting['setting_value'],
                    'setting_group' => $setting['setting_group'],
                    'updated_at'    => date('Y-m-d H:i:s'),
                ]);
            } else {
                $setting['created_at'] = date('Y-m-d H:i:s');
                $setting['updated_at'] = date('Y-m-d H:i:s');
                $this->db->table('settings')->insert($setting);
            }
        }
    }
}
