<?php

namespace App\Controllers;

use App\Models\ServiceModel;

class Service extends BaseController
{
    protected $serviceModel;

    public function __construct()
    {
        $this->serviceModel = new ServiceModel();
    }

    public function index()
    {
        $services = $this->serviceModel->getActiveServices();

        return view('services/index', [
            'page_title' => 'Computer Repair & IT Services in Dewas | Balaji Computech',
            'services'   => $services,
        ]);
    }

    public function detail($slug)
    {
        $service = $this->serviceModel->where('slug', $slug)
                                      ->where('is_active', 1)
                                      ->where('deleted_at', null)
                                      ->first();

        if (!$service) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Service not found: ' . $slug);
        }

        $allServices = $this->serviceModel->where('is_active', 1)
                                          ->where('deleted_at', null)
                                          ->where('id !=', $service['id'])
                                          ->findAll();

        $priceText = $service['starting_price'] ? 'Starting from ₹' . number_format($service['starting_price'], 2) : 'Contact for Estimate';
        $waMessage = "Hello Gourav Joshi / Balaji Computech,\n\nI need service assistance for:\nService: {$service['name']}\nEstimated: {$priceText}\nLink: " . current_url() . "\n\nPlease let me know appointment schedule and turnaround time. Thanks!";
        $whatsappUrl = get_whatsapp_url($waMessage);

        return view('services/detail', [
            'page_title'  => esc($service['name']) . ' | Balaji Computech Dewas',
            'service'     => $service,
            'allServices' => $allServices,
            'whatsappUrl' => $whatsappUrl,
        ]);
    }
}
