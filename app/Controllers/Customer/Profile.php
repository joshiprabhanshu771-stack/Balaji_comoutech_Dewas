<?php

namespace App\Controllers\Customer;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        return view('customer/profile', [
            'page_title' => 'My Profile & Account Settings | Balaji Computech',
            'user'       => $user,
        ]);
    }

    public function update()
    {
        $userId = session()->get('user_id');

        $rules = [
            'name'   => 'required|min_length[3]|max_length[100]',
            'email'  => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'mobile' => 'required|min_length[10]|max_length[15]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $this->userModel->update($userId, [
            'name'   => trim($this->request->getPost('name')),
            'email'  => strtolower(trim($this->request->getPost('email'))),
            'mobile' => trim($this->request->getPost('mobile')),
        ]);

        session()->set([
            'user_name'  => trim($this->request->getPost('name')),
            'user_email' => strtolower(trim($this->request->getPost('email'))),
        ]);

        return redirect()->to(base_url('dashboard/profile'))->with('success', 'Profile details updated successfully!');
    }

    public function changePassword()
    {
        $userId = session()->get('user_id');
        $user = $this->userModel->find($userId);

        $rules = [
            'current_password' => 'required',
            'new_password'     => 'required|min_length[6]',
            'confirm_password' => 'required|matches[new_password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('password_errors', $this->validator->getErrors());
        }

        $currentPass = $this->request->getPost('current_password');
        if (!password_verify($currentPass, $user['password_hash'])) {
            return redirect()->back()->with('error', 'Current password entered is incorrect.');
        }

        $this->userModel->update($userId, [
            'password_hash' => password_hash($this->request->getPost('new_password'), PASSWORD_BCRYPT),
        ]);

        return redirect()->to(base_url('dashboard/profile'))->with('success', 'Password updated successfully!');
    }
}
