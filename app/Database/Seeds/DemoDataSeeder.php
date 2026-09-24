<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');

        // 1. CATEGORIES
        $categories = [
            [
                'id'          => 1,
                'name'        => 'Laptops',
                'slug'        => 'laptops',
                'description' => 'Latest gaming laptops, ultra-thin business notebooks, and student budget laptops.',
                'image'       => 'category_laptops.png',
                'icon'        => 'bi bi-laptop',
                'is_featured' => 1,
                'status'      => 'active',
                'sort_order'  => 1,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 2,
                'name'        => 'Desktop & All-in-One PCs',
                'slug'        => 'desktop-pcs',
                'description' => 'Pre-built desktop computers, office workstations, and space-saving All-in-One PCs.',
                'image'       => 'category_desktops.png',
                'icon'        => 'bi bi-pc-display-horizontal',
                'is_featured' => 1,
                'status'      => 'active',
                'sort_order'  => 2,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 3,
                'name'        => 'PC Components & Hardware',
                'slug'        => 'pc-components',
                'description' => 'Processors, Graphic Cards, Motherboards, RAM, NVMe SSDs, Power Supplies & Cabinets.',
                'image'       => 'category_components.png',
                'icon'        => 'bi bi-cpu',
                'is_featured' => 1,
                'status'      => 'active',
                'sort_order'  => 3,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 4,
                'name'        => 'Monitors & Displays',
                'slug'        => 'monitors',
                'description' => 'High refresh rate gaming monitors, 4K professional designer screens, and office displays.',
                'image'       => 'category_monitors.png',
                'icon'        => 'bi bi-display',
                'is_featured' => 1,
                'status'      => 'active',
                'sort_order'  => 4,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 5,
                'name'        => 'CCTV & Security Systems',
                'slug'        => 'cctv-security',
                'description' => 'HD IP cameras, Dome & Bullet cameras, DVR/NVR surveillance setups for home and business.',
                'image'       => 'category_cctv.png',
                'icon'        => 'bi bi-camera-video',
                'is_featured' => 1,
                'status'      => 'active',
                'sort_order'  => 5,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 6,
                'name'        => 'Printers & Inks',
                'slug'        => 'printers-inks',
                'description' => 'InkTank printers, Laser printers, all-in-one scanner copiers, and genuine cartridges.',
                'image'       => 'category_printers.png',
                'icon'        => 'bi bi-printer',
                'is_featured' => 1,
                'status'      => 'active',
                'sort_order'  => 6,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 7,
                'name'        => 'Networking Devices',
                'slug'        => 'networking',
                'description' => 'Wi-Fi 6 routers, Gigabit switches, range extenders, LAN cables, and patch panels.',
                'image'       => 'category_networking.png',
                'icon'        => 'bi bi-router',
                'is_featured' => 0,
                'status'      => 'active',
                'sort_order'  => 7,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
            [
                'id'          => 8,
                'name'        => 'Computer Accessories',
                'slug'        => 'accessories',
                'description' => 'Mechanical keyboards, gaming mice, laptop bags, UPS, webcams, and cables.',
                'image'       => 'category_accessories.png',
                'icon'        => 'bi bi-keyboard',
                'is_featured' => 0,
                'status'      => 'active',
                'sort_order'  => 8,
                'created_at'  => $now,
                'updated_at'  => $now,
            ],
        ];

        foreach ($categories as $cat) {
            $existing = $this->db->table('categories')->where('slug', $cat['slug'])->get()->getFirstRow();
            if (!$existing) {
                $this->db->table('categories')->insert($cat);
            }
        }

        // 2. BRANDS
        $brands = [
            ['id' => 1, 'name' => 'HP', 'slug' => 'hp', 'description' => 'Hewlett-Packard laptops, desktops, and printers.', 'logo' => 'brand_hp.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 2, 'name' => 'Dell', 'slug' => 'dell', 'description' => 'High reliability Inspiron, Vostro, and Latitude series.', 'logo' => 'brand_dell.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 3, 'name' => 'Lenovo', 'slug' => 'lenovo', 'description' => 'ThinkPad, IdeaPad and Legion gaming systems.', 'logo' => 'brand_lenovo.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 4, 'name' => 'ASUS', 'slug' => 'asus', 'description' => 'ROG, TUF Gaming, and ZenBook laptop innovations.', 'logo' => 'brand_asus.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 5, 'name' => 'Acer', 'slug' => 'acer', 'description' => 'Predator, Nitro, and Aspire reliable PCs.', 'logo' => 'brand_acer.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 6, 'name' => 'Intel', 'slug' => 'intel', 'description' => 'Core i3, i5, i7, i9 and Core Ultra processors.', 'logo' => 'brand_intel.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 7, 'name' => 'AMD', 'slug' => 'amd', 'description' => 'Ryzen 5000, 7000, and 8000 series CPUs and Radeon GPUs.', 'logo' => 'brand_amd.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 8, 'name' => 'Hikvision', 'slug' => 'hikvision', 'description' => 'World leading security cameras and DVR/NVRs.', 'logo' => 'brand_hikvision.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 9, 'name' => 'CP PLUS', 'slug' => 'cp-plus', 'description' => 'Advanced surveillance and smart security solutions.', 'logo' => 'brand_cpplus.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 10, 'name' => 'Canon', 'slug' => 'canon', 'description' => 'PIXMA and imageCLASS high efficiency printers.', 'logo' => 'brand_canon.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 11, 'name' => 'Epson', 'slug' => 'epson', 'description' => 'EcoTank high-yield color ink tank printers.', 'logo' => 'brand_epson.png', 'is_featured' => 1, 'status' => 'active'],
            ['id' => 12, 'name' => 'TP-Link', 'slug' => 'tp-link', 'description' => 'Reliable Wi-Fi routers and networking accessories.', 'logo' => 'brand_tplink.png', 'is_featured' => 1, 'status' => 'active'],
        ];

        foreach ($brands as $b) {
            $existing = $this->db->table('brands')->where('slug', $b['slug'])->get()->getFirstRow();
            if (!$existing) {
                $b['created_at'] = $now;
                $b['updated_at'] = $now;
                $this->db->table('brands')->insert($b);
            }
        }

        // 3. PRODUCTS
        $products = [
            [
                'id'                => 1,
                'category_id'       => 1,
                'brand_id'          => 4,
                'name'              => 'ASUS TUF Gaming F15 (Intel Core i5 12th Gen / 16GB / 512GB SSD / RTX 3050)',
                'slug'              => 'asus-tuf-gaming-f15-i5-12th-gen-rtx-3050',
                'sku'               => 'LAP-ASUS-TUF-F15',
                'short_description' => 'Engineered for serious gaming and real-world durability. Powered by 12th Gen Intel Core i5 & NVIDIA GeForce RTX 3050 graphics.',
                'full_description'  => '<p>The ASUS TUF Gaming F15 is a feature-packed gaming laptop built for action. Equipped with a high refresh rate 144Hz IPS-level display, military-grade MIL-STD-810H construction, and dual anti-dust fans for optimal cooling.</p><ul><li>Processor: 12th Gen Intel Core i5-12500H (12 Cores, up to 4.5GHz)</li><li>RAM: 16GB DDR4 3200MHz (Expandable to 32GB)</li><li>Storage: 512GB PCIe 4.0 NVMe M.2 SSD</li><li>Graphics: NVIDIA GeForce RTX 3050 4GB GDDR6</li><li>Display: 15.6" FHD (1920 x 1080) 144Hz Anti-Glare</li><li>OS: Windows 11 Home + MS Office 2021</li><li>Warranty: 1 Year Manufacturer Warranty</li></ul>',
                'specifications'    => "Processor: Intel Core i5-12500H\nRAM: 16GB DDR4\nStorage: 512GB NVMe SSD\nGraphics: RTX 3050 4GB\nDisplay: 15.6 Inch 144Hz FHD\nBattery: 56WHrs\nWeight: 2.20 kg",
                'price'             => 68990.00,
                'discount_price'    => 58990.00,
                'stock_status'      => 'in_stock',
                'main_image'        => 'product_asus_tuf.jpg',
                'is_featured'       => 1,
                'is_hot_deal'       => 1,
                'status'            => 'active',
                'views_count'       => 142,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 2,
                'category_id'       => 1,
                'brand_id'          => 1,
                'name'              => 'HP Pavilion 15 (AMD Ryzen 5 5625U / 16GB RAM / 512GB SSD / 15.6" FHD)',
                'slug'              => 'hp-pavilion-15-ryzen-5-16gb-512gb-ssd',
                'sku'               => 'LAP-HP-PAV15-R5',
                'short_description' => 'Lightweight, stylish, and powerful laptop for office productivity, coding, multimedia, and remote learning.',
                'full_description'  => '<p>Experience incredible performance with the AMD Ryzen 5 processor. Features Audio by B&O, backlit keyboard, fingerprint reader, and fast charging battery.</p><ul><li>Processor: AMD Ryzen 5 5625U (6 Cores, 12 Threads)</li><li>RAM: 16GB DDR4 RAM</li><li>Storage: 512GB PCIe M.2 SSD</li><li>Display: 15.6" Full HD IPS Micro-edge Display</li><li>Keyboard: Full-size backlit keyboard with numpad</li><li>Battery: Up to 8.5 hours with HP Fast Charge</li></ul>',
                'specifications'    => "Processor: AMD Ryzen 5 5625U\nRAM: 16GB DDR4\nStorage: 512GB M.2 SSD\nDisplay: 15.6 Inch FHD IPS\nAudio: B&O Dual Speakers\nWeight: 1.75 kg",
                'price'             => 56990.00,
                'discount_price'    => 49990.00,
                'stock_status'      => 'in_stock',
                'main_image'        => 'product_hp_pavilion.jpg',
                'is_featured'       => 1,
                'is_hot_deal'       => 0,
                'status'            => 'active',
                'views_count'       => 98,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 3,
                'category_id'       => 1,
                'brand_id'          => 2,
                'name'              => 'Dell Inspiron 3520 (Intel Core i3 12th Gen / 8GB RAM / 512GB SSD / Win 11)',
                'slug'              => 'dell-inspiron-3520-i3-12th-gen',
                'sku'               => 'LAP-DELL-3520-I3',
                'short_description' => 'Budget-friendly, ultra-reliable notebook designed for students, daily office workflows, and home usage.',
                'full_description'  => '<p>Dell Inspiron 3520 offers smooth multitasking and crisp visuals with its 120Hz refresh rate display. Built with lift-hinge ergonomics and eco-conscious recycled materials.</p>',
                'specifications'    => "Processor: Intel Core i3-1215U\nRAM: 8GB DDR4\nStorage: 512GB SSD\nDisplay: 15.6 Inch FHD 120Hz\nOS: Windows 11 Home\nWeight: 1.65 kg",
                'price'             => 42500.00,
                'discount_price'    => 36490.00,
                'stock_status'      => 'in_stock',
                'main_image'        => 'product_dell_inspiron.jpg',
                'is_featured'       => 1,
                'is_hot_deal'       => 0,
                'status'            => 'active',
                'views_count'       => 64,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 4,
                'category_id'       => 3,
                'brand_id'          => 6,
                'name'              => 'Intel Core i5-13400F Desktop Processor (10 Cores, up to 4.6 GHz)',
                'slug'              => 'intel-core-i5-13400f-processor',
                'sku'               => 'CPU-INTEL-13400F',
                'short_description' => '13th Gen Raptor Lake desktop CPU with 6 Performance cores and 4 Efficient cores for unbeatable value gaming.',
                'full_description'  => '<p>Great for high FPS gaming, streaming, and content creation. Compatible with Intel 600 and 700 series motherboards (LGA 1700).</p>',
                'specifications'    => "Socket: LGA 1700\nTotal Cores: 10 (6P + 4E)\nThreads: 16\nMax Turbo Frequency: 4.60 GHz\nCache: 20MB Intel Smart Cache\nTDP: 65W Base",
                'price'             => 18500.00,
                'discount_price'    => 16200.00,
                'stock_status'      => 'in_stock',
                'main_image'        => 'product_intel_i5.jpg',
                'is_featured'       => 1,
                'is_hot_deal'       => 1,
                'status'            => 'active',
                'views_count'       => 85,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 5,
                'category_id'       => 3,
                'brand_id'          => 7,
                'name'              => 'AMD Ryzen 5 7600X Desktop Processor (6 Cores / 12 Threads / AM5)',
                'slug'              => 'amd-ryzen-5-7600x-processor',
                'sku'               => 'CPU-AMD-7600X',
                'short_description' => 'Zen 4 architecture desktop processor built on cutting-edge 5nm process with up to 5.3GHz boost clock.',
                'full_description'  => '<p>Pure gaming power with PCIe 5.0 support, DDR5 memory readiness, and high clock speeds on the next-gen AM5 platform.</p>',
                'specifications'    => "Socket: AM5\nCores/Threads: 6/12\nBase Clock: 4.7GHz\nBoost Clock: up to 5.3GHz\nL3 Cache: 32MB\nMemory: DDR5 Support",
                'price'             => 23900.00,
                'discount_price'    => 19800.00,
                'stock_status'      => 'in_stock',
                'main_image'        => 'product_ryzen_7600x.jpg',
                'is_featured'       => 1,
                'is_hot_deal'       => 0,
                'status'            => 'active',
                'views_count'       => 72,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 6,
                'category_id'       => 5,
                'brand_id'          => 9,
                'name'              => 'CP PLUS 4 Camera 2.4MP Full HD CCTV Complete Surveillance Kit',
                'slug'              => 'cp-plus-4-camera-full-hd-cctv-kit',
                'sku'               => 'CCTV-CPP-4CAM-KIT',
                'short_description' => 'Complete home & shop security kit including 2 Dome + 2 Bullet cameras, 4CH HD DVR, 1TB WD Purple HDD & power supply.',
                'full_description'  => '<p>Keep your premises safe with crystal clear 1080P Full HD video surveillance. Includes night vision up to 20 meters, remote mobile viewing via CP PLUS app, and weatherproof casing.</p><ul><li>Cameras: 2 Indoor Dome + 2 Outdoor Weatherproof Bullet 2.4MP</li><li>DVR: 4 Channel HD DVR with HDMI/VGA output</li><li>Storage: 1TB Surveillance Hard Drive Included</li><li>Cables & Power: 90m 3+1 Coxial Cable + 4 Port SMPS + BNC/DC Connectors</li><li>Installation: Professional setup available in Dewas by Balaji Computech team</li></ul>',
                'specifications'    => "Resolution: 1080P Full HD (2.4MP)\nNight Vision: IR LED up to 20m\nStorage: 1TB Purple HDD included\nMobile App: gCMOB (Android / iOS)\nWarranty: 2 Years Onsite/Shop Support",
                'price'             => 14500.00,
                'discount_price'    => 11999.00,
                'stock_status'      => 'in_stock',
                'main_image'        => 'product_cpplus_cctv.jpg',
                'is_featured'       => 1,
                'is_hot_deal'       => 1,
                'status'            => 'active',
                'views_count'       => 210,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 7,
                'category_id'       => 6,
                'brand_id'          => 11,
                'name'              => 'Epson EcoTank L3210 All-in-One Ink Tank Color Printer',
                'slug'              => 'epson-ecotank-l3210-printer',
                'sku'               => 'PRN-EPSON-L3210',
                'short_description' => 'Economical and multi-functional printing solution for home and small offices. Print, scan, and copy with spill-free ink refill.',
                'full_description'  => '<p>The Epson EcoTank L3210 delivers high-yield printing with up to 4,500 black pages and 7,500 color pages per bottle set. Compact footprint with integrated ink tanks.</p>',
                'specifications'    => "Functions: Print, Scan, Copy\nPrint Speed: up to 10 ipm (Black), 5.0 ipm (Colour)\nPage Yield: 4,500 black / 7,500 color\nConnectivity: USB 2.0\nWarranty: 1 Year or 30,000 pages",
                'price'             => 14999.00,
                'discount_price'    => 12890.00,
                'stock_status'      => 'in_stock',
                'main_image'        => 'product_epson_l3210.jpg',
                'is_featured'       => 1,
                'is_hot_deal'       => 0,
                'status'            => 'active',
                'views_count'       => 115,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 8,
                'category_id'       => 4,
                'brand_id'          => 4,
                'name'              => 'ASUS TUF Gaming VG249Q1A (23.8 Inch FHD IPS / 165Hz / 1ms / FreeSync Premium)',
                'slug'              => 'asus-tuf-vg249q1a-gaming-monitor',
                'sku'               => 'MON-ASUS-VG249',
                'short_description' => 'Ultra-fast 165Hz gaming monitor with IPS panel, Extreme Low Motion Blur (ELMB), and Shadow Boost.',
                'full_description'  => '<p>Designed for professional gamers and immersive gameplay. Boasts 165Hz refresh rate overclock and FreeSync Premium technology for fluid, tear-free visuals.</p>',
                'specifications'    => "Screen Size: 23.8 Inch\nPanel: IPS\nResolution: 1920 x 1080 (FHD)\nRefresh Rate: 165Hz\nResponse Time: 1ms MPRT\nPorts: 2x HDMI 1.4, 1x DisplayPort 1.2",
                'price'             => 15500.00,
                'discount_price'    => 11490.00,
                'stock_status'      => 'in_stock',
                'main_image'        => 'product_asus_monitor.jpg',
                'is_featured'       => 0,
                'is_hot_deal'       => 1,
                'status'            => 'active',
                'views_count'       => 88,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ];

        foreach ($products as $prod) {
            $existing = $this->db->table('products')->where('slug', $prod['slug'])->get()->getFirstRow();
            if (!$existing) {
                $this->db->table('products')->insert($prod);
            }
        }

        // 4. SERVICES
        $services = [
            [
                'id'                => 1,
                'name'              => 'Chip-Level Laptop & Desktop Motherboard Repair',
                'slug'              => 'chip-level-laptop-motherboard-repair',
                'icon'              => 'bi bi-motherboard',
                'image'             => 'service_laptop_repair.jpg',
                'short_description' => 'Expert diagnosing and microscopic level component repairing for no-display, power dead, charging issues, and liquid damage.',
                'full_description'  => '<p>Our lab at Balaji Computech is equipped with advanced BGA rework stations, digital oscilloscopes, and thermal cameras. We repair dead laptops, graphics chip issues, shorted circuits, power rail faults, and IC replacements with warranty.</p><ul><li>No display / Black screen troubleshooting</li><li>Charging port & DC jack replacement</li><li>Liquid spill cleanup & circuit trace repair</li><li>BIOS reprogramming & clear ME region</li><li>Overheating issue & thermal paste upgrade</li></ul>',
                'features'          => "Advanced BGA Soldering\nDead Motherboard Revival\nSame-Day Diagnostic\nGenuine Replacement Components\n30-Day Service Guarantee",
                'turnaround_time'   => '24 to 48 Hours',
                'starting_price'    => 499.00,
                'is_featured'       => 1,
                'status'            => 'active',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 2,
                'name'              => 'Custom PC Build & Gaming Rig Assembly',
                'slug'              => 'custom-pc-build-gaming-assembly',
                'icon'              => 'bi bi-cpu-fill',
                'image'             => 'service_custom_pc.jpg',
                'short_description' => 'Tailor-made computer builds for esports gaming, video editing, 3D rendering, stock trading, and architecture workstations.',
                'full_description'  => '<p>Get your dream PC assembled by hardware specialists. We help you choose the best budget-to-performance component matching, provide clean cable management, install optimized OS & drivers, and perform multi-hour stress testing before handover.</p>',
                'features'          => "Component Compatibility Check\nClean Cable Management\nBIOS Configuration & XMP Tuning\nStress & Thermal Testing\nLifetime Assembly Support",
                'turnaround_time'   => '1 to 2 Days',
                'starting_price'    => 999.00,
                'is_featured'       => 1,
                'status'            => 'active',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 3,
                'name'              => 'CCTV Camera Setup, Installation & AMC',
                'slug'              => 'cctv-camera-installation-amc',
                'icon'              => 'bi bi-camera-video-fill',
                'image'             => 'service_cctv_install.jpg',
                'short_description' => 'End-to-end security camera installation, cabling, mobile remote view configuration, and annual maintenance contracts in Dewas.',
                'full_description'  => '<p>Protect your shop, warehouse, factory, school, or residence with reliable CCTV surveillance. We provide site survey, optimal camera placement advice, neat concealed wiring, and instant phone alert setups.</p>',
                'features'          => "Site Survey & Planning\nHD / IP Camera Installation\nSmartphone App Remote Monitoring\nDVR / NVR Storage Setup\nAnnual Maintenance Contracts (AMC)",
                'turnaround_time'   => 'Same Day / Next Day',
                'starting_price'    => 1499.00,
                'is_featured'       => 1,
                'status'            => 'active',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 4,
                'name'              => 'Laptop Screen, Keyboard & Battery Replacement',
                'slug'              => 'laptop-screen-keyboard-battery-replacement',
                'icon'              => 'bi bi-display-fill',
                'image'             => 'service_screen_replacement.jpg',
                'short_description' => 'Original quality replacement screens, LED panels, backlit keyboards, and long-life batteries for HP, Dell, Lenovo, Acer, Asus.',
                'full_description'  => '<p>Broken screen? Unresponsive keyboard keys? Battery draining in minutes? We carry ready stock of replacement parts for all major laptop models. Fast installation while you wait.</p>',
                'features'          => "Original OEM Replacement Panels\n100% Brand New Grade-A Batteries\nInstant Replacement in 30 Mins\n6 Months to 1 Year Warranty",
                'turnaround_time'   => '30 Mins to 2 Hours',
                'starting_price'    => 699.00,
                'is_featured'       => 1,
                'status'            => 'active',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 5,
                'name'              => 'Operating System, Antivirus & Software Setup',
                'slug'              => 'os-antivirus-software-setup',
                'icon'              => 'bi bi-shield-check',
                'image'             => 'service_software_setup.jpg',
                'short_description' => 'Genuine Windows 11/10 installation, virus & malware removal, Tally Prime setup, Microsoft Office, and SSD cloning.',
                'full_description'  => '<p>Keep your PC running fast and secure. We perform deep system cleanup, slow PC speed boost, SSD upgrade cloning without data loss, and licensed antivirus installation.</p>',
                'features'          => "Genuine Windows Installation\nVirus / Ransomware Removal\nSSD Data Cloning without data loss\nDriver & Utility Configuration",
                'turnaround_time'   => '1 to 3 Hours',
                'starting_price'    => 299.00,
                'is_featured'       => 0,
                'status'            => 'active',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
            [
                'id'                => 6,
                'name'              => 'Printer Repair, Head Cleaning & Cartridge Refill',
                'slug'              => 'printer-repair-cartridge-refill',
                'icon'              => 'bi bi-printer-fill',
                'image'             => 'service_printer_repair.jpg',
                'short_description' => 'InkTank printer head unblocking, paper jam resolution, roller replacement, and precision laser toner cartridge refilling.',
                'full_description'  => '<p>Cost-effective printer servicing for Canon, Epson, HP, and Brother. Fix print blank page issues, paper pickup errors, ink pad overflow reset, and high-density toner refilling.</p>',
                'features'          => "Clogged Printhead Recovery\nPaper Pickup Roller Replacement\nLogic Card & Power Supply Repair\nHigh Yield Toner Refilling",
                'turnaround_time'   => 'Same Day',
                'starting_price'    => 249.00,
                'is_featured'       => 0,
                'status'            => 'active',
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ];

        foreach ($services as $srv) {
            $existing = $this->db->table('services')->where('slug', $srv['slug'])->get()->getFirstRow();
            if (!$existing) {
                $this->db->table('services')->insert($srv);
            }
        }

        // 5. OFFERS
        $offers = [
            [
                'id'            => 1,
                'title'         => 'Festive Computer Upgrade Mega Deal',
                'slug'          => 'festive-upgrade-mega-deal',
                'description'   => 'Upgrade your existing slow laptop or desktop with a 512GB NVMe SSD + 8GB RAM + Full Service at special bundle price!',
                'banner_image'  => 'offer_festive_deal.jpg',
                'discount_text' => 'Save up to 30% on Upgrades',
                'coupon_code'   => 'SPEEDUP30',
                'valid_from'    => date('Y-m-d', strtotime('-5 days')),
                'valid_until'   => date('Y-m-d', strtotime('+60 days')),
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 2,
                'title'         => 'Student & Educator Laptop Discount',
                'slug'          => 'student-laptop-discount',
                'description'   => 'Show your valid school/college ID card and get free laptop backpack, wireless mouse, and antivirus on any laptop purchase.',
                'banner_image'  => 'offer_student_deal.jpg',
                'discount_text' => 'Free Combo Worth ₹2,500',
                'coupon_code'   => 'STUDENTPASS',
                'valid_from'    => date('Y-m-d', strtotime('-10 days')),
                'valid_until'   => date('Y-m-d', strtotime('+90 days')),
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
            [
                'id'            => 3,
                'title'         => 'Complete CCTV Security Package Discount',
                'slug'          => 'cctv-package-discount',
                'description'   => 'Get flat ₹1,500 OFF on full 4-camera HD CCTV surveillance kit with free site installation in Dewas municipal area.',
                'banner_image'  => 'offer_cctv_deal.jpg',
                'discount_text' => 'Flat ₹1,500 OFF + Free Setup',
                'coupon_code'   => 'SAFEHOME',
                'valid_from'    => date('Y-m-d', strtotime('-2 days')),
                'valid_until'   => date('Y-m-d', strtotime('+45 days')),
                'is_active'     => 1,
                'created_at'    => $now,
                'updated_at'    => $now,
            ],
        ];

        foreach ($offers as $off) {
            $existing = $this->db->table('offers')->where('slug', $off['slug'])->get()->getFirstRow();
            if (!$existing) {
                $this->db->table('offers')->insert($off);
            }
        }

        // 6. FAQS
        $faqs = [
            [
                'category'   => 'General & Shop',
                'question'   => 'Where is Balaji Computech located and what are the opening hours?',
                'answer'     => 'We are located at Shop No. 12, Mainashree Complex, Near Netram, AB Road, Dewas, Madhya Pradesh (455001). We are open Monday to Saturday from 10:00 AM to 08:30 PM, and Sundays from 11:00 AM to 04:00 PM.',
                'sort_order' => 1,
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category'   => 'General & Shop',
                'question'   => 'Can I buy products directly through this website?',
                'answer'     => 'This website is an online product showcase and inquiry catalog. We do not process online credit card/cart transactions. You can browse our full catalog, add items to your wishlist, send an inquiry through our site or click the WhatsApp button to chat directly with Gourav Joshi for instant pricing, availability, and shop pickup/delivery.',
                'sort_order' => 2,
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category'   => 'Products & Stock',
                'question'   => 'Are all products 100% genuine with manufacturer warranty?',
                'answer'     => 'Yes, absolutely! Every laptop, PC component, printer, monitor, and CCTV camera sold by Balaji Computech is 100% brand new, authentic, and backed by official brand warranty across India.',
                'sort_order' => 3,
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category'   => 'Products & Stock',
                'question'   => 'Can you arrange a specific laptop model or computer part if not listed on the website?',
                'answer'     => 'Yes! We have direct distributor tie-ups with HP, Dell, Lenovo, Asus, Intel, AMD, Gigabyte, MSI, and more. Send us the specific model number or configuration, and we can arrange it within 24-48 hours at competitive pricing.',
                'sort_order' => 4,
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category'   => 'Services & Repairs',
                'question'   => 'How much time does it take for chip-level laptop repair?',
                'answer'     => 'Most standard diagnostic and motherboard repairs take between 24 to 48 hours. Screen and keyboard replacements or SSD upgrades are usually done within 30 to 60 minutes.',
                'sort_order' => 5,
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'category'   => 'Services & Repairs',
                'question'   => 'Do you provide onsite CCTV installation and home repair visits in Dewas?',
                'answer'     => 'Yes, our certified technicians provide onsite site surveys, CCTV camera installations, network cabling, and home/office PC troubleshooting across Dewas and nearby surrounding areas.',
                'sort_order' => 6,
                'is_active'  => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($faqs as $faq) {
            $existing = $this->db->table('faqs')->where('question', $faq['question'])->get()->getFirstRow();
            if (!$existing) {
                $this->db->table('faqs')->insert($faq);
            }
        }

        // 7. PAGES
        $pages = [
            [
                'title'            => 'About Balaji Computech',
                'slug'             => 'about-us',
                'content'          => '<h2>Welcome to Balaji Computech</h2><p>Established as Dewas’s premier IT hardware and technology solutions center, <strong>Balaji Computech</strong> is dedicated to delivering the highest quality computing hardware, custom assembled PC builds, CCTV surveillance setups, and specialized chip-level repair services.</p><h3>Meet the Founder</h3><p>Founded and managed by <strong>Gourav Joshi</strong>, Balaji Computech was created with a mission to bring transparent pricing, genuine computer products, and professional technician support to individual customers, students, freelancers, and businesses across Dewas and Madhya Pradesh.</p><h3>Why Choose Balaji Computech?</h3><ul><li><strong>100% Genuine Products:</strong> Authorized partner for top global brands like HP, Dell, Lenovo, Asus, Intel, CP PLUS, and Hikvision.</li><li><strong>State-of-the-Art Repair Lab:</strong> Advanced BGA soldering and diagnostic equipment for chip-level repair.</li><li><strong>Custom PC Expertise:</strong> Built by gamers and workstation specialists who understand airflow, compatibility, and peak performance.</li><li><strong>Dedicated Customer Care:</strong> Fast inquiry response, WhatsApp support, and post-service warranty assistance.</li></ul>',
                'meta_title'       => 'About Us | Balaji Computech Dewas',
                'meta_description' => 'Learn more about Balaji Computech, founded by Gourav Joshi in Dewas, MP. Your trusted source for laptops, desktops, repairs, and CCTV systems.',
                'is_active'        => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'title'            => 'Terms & Conditions',
                'slug'             => 'terms-and-conditions',
                'content'          => '<h2>Terms & Conditions</h2><p>Welcome to the Balaji Computech website. By accessing or using this website, you agree to comply with and be bound by the following terms and conditions.</p><h3>1. Website Purpose</h3><p>This website serves as a digital product showcase, service portfolio, and customer inquiry platform. No online payment gateways are integrated, and no monetary transactions take place directly on this website.</p><h3>2. Inquiries and Quotes</h3><p>Submitting an inquiry through this site or communicating via WhatsApp does not constitute a legally binding sales contract until confirmed by Balaji Computech with official quotation and invoice at the shop premises.</p><h3>3. Pricing & Availability</h3><p>Prices and stock availability listed on the website are subject to market fluctuations and distributor changes. We reserve the right to modify prices without prior notice.</p><h3>4. Warranty & Repairs</h3><p>Brand new products carry standard manufacturer warranties. Repaired components carry a 30-day testing warranty unless specified otherwise on the repair job card.</p>',
                'meta_title'       => 'Terms & Conditions | Balaji Computech',
                'meta_description' => 'Read our terms and conditions regarding website usage, product inquiries, quotes, and repair service policies.',
                'is_active'        => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'title'            => 'Privacy Policy',
                'slug'             => 'privacy-policy',
                'content'          => '<h2>Privacy Policy</h2><p>At Balaji Computech, we value your trust and are committed to protecting your personal information.</p><h3>Information We Collect</h3><p>When you register an account, add items to your wishlist, or submit an inquiry, we collect information including your name, email address, mobile phone number, and any details you provide in your message.</p><h3>How We Use Your Information</h3><ul><li>To respond to your product and service inquiries promptly.</li><li>To provide quotation details and stock updates via email, phone, or WhatsApp.</li><li>To track your customer service history and support tickets.</li></ul><p>We do not sell, rent, or trade your personal information to any third parties.</p>',
                'meta_title'       => 'Privacy Policy | Balaji Computech',
                'meta_description' => 'Our privacy policy explains how we collect, use, and protect your personal information when you use our website.',
                'is_active'        => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'title'            => 'Product Inquiry & Return Policy',
                'slug'             => 'return-and-inquiry-policy',
                'content'          => '<h2>Product Inquiry & Return Policy</h2><h3>Inquiry Workflow</h3><p>When you submit an inquiry through our website:</p><ol><li>Our team receives your request and checks live stock availability.</li><li>Gourav Joshi or our service team will reply to your account dashboard and contact you via phone/WhatsApp with current best pricing.</li><li>You can visit our store in Mainashree Complex, Dewas to inspect the hardware, collect the invoice, and pick up your items.</li></ol><h3>Returns & Replacements</h3><p>Since all sales take place directly at our physical store, customers are encouraged to inspect goods before taking delivery. Defective goods under manufacturer warranty will be processed as per official brand service center replacement guidelines.</p>',
                'meta_title'       => 'Inquiry & Return Policy | Balaji Computech',
                'meta_description' => 'Learn how our inquiry system works and our store return and replacement policies.',
                'is_active'        => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
            [
                'title'            => 'Disclaimer',
                'slug'             => 'disclaimer',
                'content'          => '<h2>Website Disclaimer</h2><p>All brand logos, trademarks, and product images shown on this website (such as HP, Dell, Lenovo, Asus, Acer, Intel, AMD, CP PLUS, Hikvision, Canon, Epson) are the property of their respective trademark holders. Balaji Computech is an independent retailer and service provider.</p><p>Specifications and images are provided for reference purposes. Please confirm technical details with our team prior to purchase.</p>',
                'meta_title'       => 'Disclaimer | Balaji Computech',
                'meta_description' => 'Legal disclaimer regarding third-party brand trademarks and product specifications.',
                'is_active'        => 1,
                'created_at'       => $now,
                'updated_at'       => $now,
            ],
        ];

        foreach ($pages as $p) {
            $existing = $this->db->table('pages')->where('slug', $p['slug'])->get()->getFirstRow();
            if (!$existing) {
                $this->db->table('pages')->insert($p);
            }
        }

        // 8. PRESENCE LOCATIONS
        $locations = [
            [
                'id'                => 1,
                'title'             => 'Balaji Computech - Main Store & Service Center',
                'address_line1'     => 'Shop No. 12, Mainashree Complex',
                'address_line2'     => 'Near Netram, AB Road',
                'city'              => 'Dewas',
                'state'             => 'Madhya Pradesh',
                'pincode'           => '455001',
                'phone'             => '+91 98260 12345',
                'alternate_phone'   => '+91 72720 00000',
                'email'             => 'info@balajicomputech.com',
                'landmark'          => 'Near Netram Hotel, Main AB Road',
                'google_maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d14705.89069151219!2d76.0465!3d22.9654!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39631745456789%3A0x123456789abcdef!2sMainashree%20Complex%2C%20AB%20Road%2C%20Dewas%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1600000000000!5m2!1sen!2sin" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>',
                'google_maps_link'  => 'https://maps.google.com/?q=Mainashree+Complex+Dewas',
                'opening_hours'     => 'Mon - Sat: 10:00 AM - 08:30 PM | Sun: 11:00 AM - 04:00 PM',
                'is_primary'        => 1,
                'created_at'        => $now,
                'updated_at'        => $now,
            ],
        ];

        foreach ($locations as $loc) {
            $existing = $this->db->table('presence_locations')->where('id', $loc['id'])->get()->getFirstRow();
            if (!$existing) {
                $this->db->table('presence_locations')->insert($loc);
            }
        }
    }
}
