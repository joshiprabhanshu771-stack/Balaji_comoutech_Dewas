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
        try {
            $services = $this->serviceModel->getActiveServices();
        } catch (\Throwable $e) {
            log_message('error', 'Service::index error: ' . $e->getMessage());
            $services = [];
        }

        if (empty($services)) {
            $services = $this->getFallbackServices();
        }

        return view('services/index', [
            'page_title' => 'Computer Repair & IT Services in Dewas | Balaji Computech',
            'services'   => $services,
        ]);
    }

    public function detail($slug)
    {
        try {
            $service = $this->serviceModel->where('slug', $slug)
                                          ->where('is_active', 1)
                                          ->first();
        } catch (\Throwable $e) {
            log_message('error', 'Service::detail error: ' . $e->getMessage());
            $service = null;
        }

        if (!$service) {
            $fallbacks = $this->getFallbackServices();
            foreach ($fallbacks as $f) {
                if ($f['slug'] === $slug) {
                    $service = $f;
                    break;
                }
            }
        }

        if (!$service) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Service not found: ' . $slug);
        }

        try {
            $allServices = $this->serviceModel->where('is_active', 1)
                                              ->where('id !=', $service['id'] ?? 0)
                                              ->findAll();
        } catch (\Throwable $e) {
            $allServices = [];
        }

        if (empty($allServices)) {
            $fallbacks = $this->getFallbackServices();
            $allServices = array_values(array_filter($fallbacks, fn($s) => $s['slug'] !== $slug));
        }

        $startingPrice = !empty($service['starting_price']) ? $service['starting_price'] : 0;
        $priceText = $startingPrice ? 'Starting from ₹' . number_format((float)$startingPrice, 2) : 'Contact for Estimate';
        $waMessage = "Hello Gourav Joshi / Balaji Computech,\n\nI need service assistance for:\nService: {$service['name']}\nEstimated: {$priceText}\nLink: " . current_url() . "\n\nPlease let me know appointment schedule and turnaround time. Thanks!";
        $whatsappUrl = get_whatsapp_url($waMessage);

        return view('services/detail', [
            'page_title'  => esc($service['name']) . ' | Balaji Computech Dewas',
            'service'     => $service,
            'allServices' => $allServices,
            'whatsappUrl' => $whatsappUrl,
        ]);
    }

    private function getFallbackServices(): array
    {
        return [
            [
                'id'                => 1,
                'name'              => 'Chip-Level Laptop & Desktop Motherboard Repair',
                'slug'              => 'chip-level-laptop-motherboard-repair',
                'icon'              => 'bi bi-tools',
                'image'             => 'service_laptop_repair.jpg',
                'short_description' => 'Expert diagnosing and microscopic level component repairing for no-display, power dead, charging issues, and liquid damage.',
                'description'       => '<p>Our laboratory at Balaji Computech is equipped with advanced BGA rework stations, digital oscilloscopes, and thermal cameras. We repair dead laptops, graphics chip issues, shorted circuits, power rail faults, and IC replacements with warranty.</p><ul><li>No display / Black screen troubleshooting</li><li>Charging port & DC jack replacement</li><li>Liquid spill cleanup & circuit trace repair</li><li>BIOS reprogramming & clear ME region</li><li>Overheating issue & thermal paste upgrade</li></ul>',
                'features'          => "Advanced BGA Soldering\nDead Motherboard Revival\nSame-Day Diagnostic\nGenuine Replacement Components\n30-Day Service Guarantee",
                'turnaround_time'   => '24 - 48 Hours',
                'starting_price'    => 999.00,
                'is_featured'       => 1,
                'is_active'         => 1,
            ],
            [
                'id'                => 2,
                'name'              => 'Custom PC Build & Gaming Rig Assembly',
                'slug'              => 'custom-pc-build-gaming-assembly',
                'icon'              => 'bi bi-gear-wide-connected',
                'image'             => 'service_custom_pc.jpg',
                'short_description' => 'Tailor-made computer builds for esports gaming, video editing, 3D rendering, stock trading, and architecture workstations.',
                'description'       => '<p>Get your dream PC assembled by hardware specialists. We help you choose the best budget-to-performance component matching, provide clean cable management, install optimized OS & drivers, and perform multi-hour stress testing before handover.</p>',
                'features'          => "Component Compatibility Check\nClean Cable Management\nBIOS Configuration & XMP Tuning\nStress & Thermal Testing\nLifetime Assembly Support",
                'turnaround_time'   => 'Same Day (4 - 6 Hours)',
                'starting_price'    => 499.00,
                'is_featured'       => 1,
                'is_active'         => 1,
            ],
            [
                'id'                => 3,
                'name'              => 'CCTV Security Installation & AMC',
                'slug'              => 'cctv-camera-installation-amc',
                'icon'              => 'bi bi-camera-video-fill',
                'image'             => 'service_cctv_install.jpg',
                'short_description' => 'Full HD & IP CCTV setup, smartphone remote live view configuration, and annual maintenance contracts in Dewas.',
                'description'       => '<p>End-to-end surveillance for shops, homes, offices, and factories in Dewas. Professional cable routing, DVR/NVR setup, and mobile viewing app configuration.</p>',
                'features'          => "Site Survey & Planning\nHD / IP Camera Installation\nSmartphone App Remote Monitoring\nDVR / NVR Storage Setup\nAnnual Maintenance Contracts (AMC)",
                'turnaround_time'   => '1 - 2 Days',
                'starting_price'    => 1499.00,
                'is_featured'       => 1,
                'is_active'         => 1,
            ],
            [
                'id'                => 4,
                'name'              => 'Laptop Screen, Keyboard & Battery Replacement',
                'slug'              => 'laptop-screen-battery-keyboard-replacement',
                'icon'              => 'bi bi-laptop-fill',
                'image'             => 'service_screen_replacement.jpg',
                'short_description' => '100% original OEM displays (FHD/IPS/144Hz), responsive keyboards, and genuine battery packs.',
                'description'       => '<p>Quick replacement of broken screens, dim displays, malfunctioning keys, and swollen or degraded batteries with brand warranty.</p>',
                'features'          => "Original OEM Replacement Panels\n100% Brand New Grade-A Batteries\nInstant Replacement in 30 Mins\n6 Months to 1 Year Warranty",
                'turnaround_time'   => '1 - 3 Hours',
                'starting_price'    => 450.00,
                'is_featured'       => 1,
                'is_active'         => 1,
            ],
            [
                'id'                => 5,
                'name'              => 'High-Speed SSD & RAM Upgrades',
                'slug'              => 'ssd-ram-speed-upgrade',
                'icon'              => 'bi bi-speedometer2',
                'image'             => 'service_software_setup.jpg',
                'short_description' => 'Transform slow laptops and desktop PCs with lightning-fast NVMe/SATA SSDs and dual-channel RAM.',
                'description'       => '<p>Make your old computer 10x faster with genuine Kingston, Crucial, and WD SSDs. We clone your existing Windows, files, and programs with zero data loss.</p>',
                'features'          => "Genuine Windows Installation\nVirus / Ransomware Removal\nSSD Data Cloning without data loss\nDriver & Utility Configuration",
                'turnaround_time'   => '30 - 60 Mins',
                'starting_price'    => 299.00,
                'is_featured'       => 0,
                'is_active'         => 1,
            ],
            [
                'id'                => 6,
                'name'              => 'Laser & InkTank Printer Repair & Cartridge Refill',
                'slug'              => 'printer-repair-cartridge-refilling',
                'icon'              => 'bi bi-printer-fill',
                'image'             => 'service_printer_repair.jpg',
                'short_description' => 'Paper jam fixing, print head cleaning, logic board repair, and high-yield laser toner refilling.',
                'description'       => '<p>Complete servicing for HP, Canon, Epson, and Brother printers. High-density black and color toner refilling with crisp output.</p>',
                'features'          => "Clogged Printhead Recovery\nPaper Pickup Roller Replacement\nLogic Card & Power Supply Repair\nHigh Yield Toner Refilling",
                'turnaround_time'   => 'Same Day',
                'starting_price'    => 199.00,
                'is_featured'       => 0,
                'is_active'         => 1,
            ]
        ];
    }

}
