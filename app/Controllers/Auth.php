<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\RoleModel;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function login()
    {
        if (session()->get('isLoggedIn')) {
            if ((int)session()->get('role_id') === 1) {
                return redirect()->to(base_url('admin/dashboard'));
            }
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/login', [
            'page_title' => 'Sign In | Balaji Computech',
        ]);
    }

    public function attemptLogin()
    {
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        if (empty($email) || empty($password)) {
            return redirect()->back()->withInput()->with('error', 'Please provide both email and password.');
        }

        $user = $this->userModel->getUserWithRoleByEmail($email);
        if (!$user) {
            $user = $this->userModel->where('email', $email)->first();
        }

        if (!$user || !password_verify($password, $user['password_hash'])) {
            return redirect()->back()->withInput()->with('error', 'Invalid email or password.');
        }

        if ($user['status'] !== 'active') {
            return redirect()->back()->withInput()->with('error', 'Your account has been deactivated. Please contact support.');
        }

        $roleModel = new RoleModel();
        $role = $roleModel->find($user['role_id']);
        $roleName = $role ? $role['name'] : 'customer';

        $sessionData = [
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
            'role_id'    => (int)$user['role_id'],
            'role_name'  => $roleName,
            'isLoggedIn' => true,
        ];
        session()->set($sessionData);

        if ((int)$user['role_id'] === 1) {
            return redirect()->to(base_url('admin/dashboard'))->with('success', 'Welcome back, ' . esc($user['name']) . '!');
        }

        return redirect()->to(base_url('dashboard'))->with('success', 'Welcome back, ' . esc($user['name']) . '!');
    }

    public function register()
    {
        if (session()->get('isLoggedIn')) {
            return redirect()->to(base_url('dashboard'));
        }

        return view('auth/register', [
            'page_title' => 'Create Account | Balaji Computech',
        ]);
    }

    public function attemptRegister()
    {
        $rules = [
            'name'             => 'required|min_length[3]|max_length[100]',
            'email'            => 'required|valid_email|is_unique[users.email]',
            'mobile'           => 'required|min_length[10]|max_length[15]',
            'password'         => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]',
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $userData = [
            'role_id'       => 2, // Default: Customer
            'name'          => trim($this->request->getPost('name')),
            'email'         => strtolower(trim($this->request->getPost('email'))),
            'mobile'        => trim($this->request->getPost('mobile')),
            'password_hash' => password_hash($this->request->getPost('password'), PASSWORD_BCRYPT),
            'status'        => 'active',
        ];

        $userId = $this->userModel->insert($userData);

        if ($userId) {
            $sessionData = [
                'user_id'    => $userId,
                'user_name'  => $userData['name'],
                'user_email' => $userData['email'],
                'role_id'    => 2,
                'role_name'  => 'customer',
                'isLoggedIn' => true,
            ];
            session()->set($sessionData);

            return redirect()->to(base_url('dashboard'))->with('success', 'Account created successfully! Welcome to Balaji Computech.');
        }

        return redirect()->back()->withInput()->with('error', 'Failed to register account. Please try again.');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to(base_url('auth/login'))->with('success', 'You have been signed out safely.');
    }
}
