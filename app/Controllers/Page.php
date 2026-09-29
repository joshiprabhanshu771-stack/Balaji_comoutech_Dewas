<?php

namespace App\Controllers;

use App\Models\PageModel;

class Page extends BaseController
{
    public function view($slug)
    {
        try {
            $pageModel = new PageModel();
            $page = $pageModel->getPageBySlug($slug);
        } catch (\Throwable $e) {
            log_message('error', 'Page::view error: ' . $e->getMessage());
            $page = null;
        }

        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Page not found: ' . $slug);
        }

        return view('pages/view', [
            'page_title' => ($page['meta_title'] ?? $page['title']) . ' | Balaji Computech',
            'page'       => $page,
        ]);
    }
}
