<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SettingModel;

class SettingController extends BaseController
{
    protected $settingModel;

    public function __construct()
    {
        $this->settingModel = new SettingModel();
    }

    public function index()
    {
        try {
            $settings = $this->settingModel->getAllAsMap();
        } catch (\Throwable $e) {
            log_message('error', 'SettingController::index failed: ' . $e->getMessage());
            $settings = [];
        }

        return view('admin/settings/index', [
            'page_title' => 'General & Shop Settings | Admin',
            'settings'   => $settings,
        ]);
    }

    public function update()
    {
        $postedSettings = $this->request->getPost('settings');

        if (!is_array($postedSettings) || empty($postedSettings)) {
            return redirect()->to(base_url('admin/settings'))
                ->with('error', 'No settings data received to update.');
        }

        // 1. Validation Rules for specific sensitive setting keys
        $rules = [
            'settings.site_name' => [
                'label'  => 'Shop / Website Name',
                'rules'  => 'permit_empty|min_length[2]|max_length[150]',
                'errors' => [
                    'min_length' => 'Shop/Website name must be at least 2 characters.',
                    'max_length' => 'Shop/Website name cannot exceed 150 characters.',
                ],
            ],
            'settings.contact_email' => [
                'label'  => 'Contact Email Address',
                'rules'  => 'permit_empty|valid_email|max_length[150]',
                'errors' => [
                    'valid_email' => 'Please enter a valid email address (e.g. info@balajicomputech.com).',
                    'max_length'  => 'Contact email cannot exceed 150 characters.',
                ],
            ],
            'settings.contact_phone' => [
                'label'  => 'Helpline Phone Number',
                'rules'  => 'permit_empty|indian_mobile',
                'errors' => [
                    'indian_mobile' => 'Helpline phone must be a valid 10-digit Indian number (e.g. 9826012345 or +919826012345).',
                ],
            ],
            'settings.whatsapp_number' => [
                'label'  => 'WhatsApp Number',
                'rules'  => 'permit_empty|indian_mobile',
                'errors' => [
                    'indian_mobile' => 'WhatsApp number must be a valid 10-digit Indian number (e.g. 9826012345 or +919826012345).',
                ],
            ],
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // 2. Normalize and sanitize values
        if (!empty($postedSettings['contact_phone'])) {
            $normPhone = normalize_indian_mobile($postedSettings['contact_phone']);
            if ($normPhone) {
                $postedSettings['contact_phone'] = $normPhone;
            }
        }

        if (!empty($postedSettings['whatsapp_number'])) {
            $normWa = normalize_indian_mobile($postedSettings['whatsapp_number']);
            if ($normWa) {
                $postedSettings['whatsapp_number'] = $normWa;
            }
        }

        if (!empty($postedSettings['contact_email'])) {
            $postedSettings['contact_email'] = strtolower(trim((string)$postedSettings['contact_email']));
        }

        // 3. Save atomically
        try {
            $saved = $this->settingModel->saveMany($postedSettings);

            if ($saved) {
                return redirect()->to(base_url('admin/settings'))
                    ->with('success', 'Website and shop settings have been updated successfully!');
            }

            return redirect()->to(base_url('admin/settings'))
                ->with('error', 'Could not save one or more settings. Please review the values and try again.');

        } catch (\Throwable $e) {
            log_message('error', 'SettingController::update exception: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            return redirect()->to(base_url('admin/settings'))
                ->with('error', 'An error occurred while saving site settings. Please try again.');
        }
    }
}
