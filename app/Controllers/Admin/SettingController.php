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
        $settings = $this->settingModel->getAllAsMap();

        return view('admin/settings/index', [
            'page_title' => 'General & Shop Settings | Admin',
            'settings'   => $settings,
        ]);
    }

    public function update()
    {
        $postedSettings = $this->request->getPost('settings');

        if (is_array($postedSettings)) {
            foreach ($postedSettings as $key => $val) {
                $this->settingModel->setVal($key, $val);
            }
        }

        return redirect()->to(base_url('admin/settings'))->with('success', 'Website and shop settings updated successfully!');
    }
}
