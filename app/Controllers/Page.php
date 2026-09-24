<?php

namespace App\Controllers;

use App\Models\PageModel;

class Page extends BaseController
{
    public function view($slug)
    {
        $pageModel = new PageModel();
        $page = $pageModel->getPageBySlug($slug);

        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Page not found: ' . $slug);
        }

        return view('pages/view', [
            'page_title' => ($page['meta_title'] ?? $page['title']) . ' | Balaji Computech',
            'page'       => $page,
        ]);
    }
}
