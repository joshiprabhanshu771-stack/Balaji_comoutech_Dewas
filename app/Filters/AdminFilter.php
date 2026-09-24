<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->get('isLoggedIn')) {
            return redirect()->to(base_url('auth/login'))->with('error', 'Please log in with admin privileges.');
        }

        if ((int)$session->get('role_id') !== 1) {
            return redirect()->to(base_url('/'))->with('error', 'Access denied. Administrator privileges required.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do nothing
    }
}
