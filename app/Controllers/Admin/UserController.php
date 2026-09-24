<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\RoleModel;

class UserController extends BaseController
{
    protected $userModel;
    protected $roleModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->roleModel = new RoleModel();
    }

    public function index()
    {
        $users = $this->userModel->select('users.*, roles.name as role_name')
                                 ->join('roles', 'roles.id = users.role_id', 'left')
                                 ->orderBy('users.id', 'DESC')
                                 ->findAll();

        return view('admin/users/index', [
            'page_title' => 'User & Customer Management | Admin',
            'users'      => $users,
        ]);
    }

    public function edit($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        $roles = $this->roleModel->findAll();

        return view('admin/users/edit', [
            'page_title' => 'Edit User: ' . esc($user['name']),
            'user'       => $user,
            'roles'      => $roles,
        ]);
    }

    public function update($id)
    {
        $user = $this->userModel->find($id);
        if (!$user) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('User not found.');
        }

        $rules = [
            'name'    => 'required|min_length[3]|max_length[100]',
            'email'   => "required|valid_email|is_unique[users.email,id,{$id}]",
            'mobile'  => 'required|min_length[10]|max_length[15]',
            'role_id' => 'required|is_natural_no_zero',
            'status'  => 'required|in_list[active,inactive,blocked]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $updateData = [
            'name'    => trim($this->request->getPost('name')),
            'email'   => strtolower(trim($this->request->getPost('email'))),
            'mobile'  => trim($this->request->getPost('mobile')),
            'role_id' => (int)$this->request->getPost('role_id'),
            'status'  => $this->request->getPost('status'),
        ];

        $newPassword = $this->request->getPost('new_password');
        if (!empty($newPassword)) {
            $updateData['password_hash'] = password_hash($newPassword, PASSWORD_BCRYPT);
        }

        $this->userModel->update($id, $updateData);

        return redirect()->to(base_url('admin/users'))->with('success', 'User updated successfully!');
    }
}
