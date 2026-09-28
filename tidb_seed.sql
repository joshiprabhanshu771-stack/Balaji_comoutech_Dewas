-- ====================================================================
-- BALAJI COMPUTECH - TIDB CLOUD SEED DATA (SAFE INSERT)
-- Uses INSERT IGNORE to prevent duplicate errors on re-runs
-- ====================================================================

SET FOREIGN_KEY_CHECKS = 0;

-- 1. Roles
INSERT IGNORE INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NOW(), NOW()),
(2, 'customer', NOW(), NOW());

-- 2. Default Admin User (admin@balajicomputech.com / admin123) & Customer Demo
INSERT IGNORE INTO `users` (`id`, `role_id`, `name`, `email`, `mobile`, `password_hash`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 'Gourav Joshi (Admin)', 'admin@balajicomputech.com', '9826012345', '$2y$10$w6yR520h0d3rUls6oKx30eM59D96K6o0rOQp335tP4n4pB9q.g3qy', 'active', NOW(), NOW()),
(2, 2, 'Rahul Sharma (Customer)', 'customer@example.com', '9876543210', '$2y$10$w6yR520h0d3rUls6oKx30eM59D96K6o0rOQp335tP4n4pB9q.g3qy', 'active', NOW(), NOW());

-- 3. Categories
INSERT IGNORE INTO `categories` (`id`, `name`, `slug`, `description`, `icon`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Laptops & Notebooks', 'laptops', 'Premium business, student, and ultra-thin laptops with warranty.', 'bi bi-laptop', 1, 1, 1, NOW(), NOW()),
(2, 'Custom Gaming PCs', 'gaming-pcs', 'High-FPS custom assembled gaming rigs with RGB & liquid cooling.', 'bi bi-pc-display', 1, 1, 2, NOW(), NOW()),
(3, 'Desktop Computers', 'desktop-pcs', 'All-in-one PCs, office workstations, and commercial systems.', 'bi bi-display', 1, 1, 3, NOW(), NOW()),
(4, 'PC Components & Parts', 'pc-components', 'CPUs, GPUs, Motherboards, RAM, NVMe SSDs, and Power Supplies.', 'bi bi-cpu', 1, 1, 4, NOW(), NOW()),
(5, 'CCTV & Security Systems', 'cctv-security', 'HD & IP surveillance cameras, DVRs, NVRs, and home security.', 'bi bi-camera-video', 1, 1, 5, NOW(), NOW()),
(6, 'Printers & Cartridges', 'printers-scanners', 'Laser, InkTank, Thermal receipt printers and genuine ink.', 'bi bi-printer', 1, 1, 6, NOW(), NOW()),
(7, 'Monitors & Displays', 'monitors', 'Gaming 144Hz-240Hz monitors, 4K IPS panels, and curved screens.', 'bi bi-tv', 1, 1, 7, NOW(), NOW()),
(8, 'Peripherals & Accessories', 'accessories', 'Mechanical keyboards, wireless mice, headsets, routers, and cables.', 'bi bi-keyboard', 1, 1, 8, NOW(), NOW());

-- 4. Brands
INSERT IGNORE INTO `brands` (`id`, `name`, `slug`, `logo`, `description`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'HP', 'hp', 'hp.png', 'Official sales and genuine parts dealer for HP laptops and printers.', 1, 1, 1, NOW(), NOW()),
(2, 'Dell', 'dell', 'dell.png', 'Authorised Dell business laptops, Inspiron series, and monitors.', 1, 1, 2, NOW(), NOW()),
(3, 'ASUS', 'asus', 'asus.png', 'ASUS ROG gaming laptops, TUF series, and high-tier motherboards.', 1, 1, 3, NOW(), NOW()),
(4, 'Lenovo', 'lenovo', 'lenovo.png', 'ThinkPad, IdeaPad, and Legion performance gaming laptops.', 1, 1, 4, NOW(), NOW()),
(5, 'Intel', 'intel', 'intel.png', 'Intel Core i3, i5, i7, i9 12th/13th/14th Gen desktop processors.', 1, 1, 5, NOW(), NOW()),
(6, 'AMD', 'amd', 'amd.png', 'AMD Ryzen 5, 7, 9 CPUs and Radeon discrete graphics cards.', 1, 1, 6, NOW(), NOW()),
(7, 'Gigabyte', 'gigabyte', 'gigabyte.png', 'Motherboards, NVIDIA RTX GPUs, and PC components.', 1, 1, 7, NOW(), NOW()),
(8, 'MSI', 'msi', 'msi.png', 'Gaming hardware, motherboards, graphic cards, and laptops.', 1, 1, 8, NOW(), NOW()),
(9, 'CP PLUS', 'cp-plus', 'cpplus.png', 'Leading security surveillance cameras, DVRs, and NVR solutions.', 1, 1, 9, NOW(), NOW()),
(10, 'Hikvision', 'hikvision', 'hikvision.png', 'World-class IP cameras, CCTV kits, and access control systems.', 1, 1, 10, NOW(), NOW()),
(11, 'Kingston', 'kingston', 'kingston.png', 'High-speed DDR4/DDR5 RAM, Fury gaming memory, and NVMe SSDs.', 1, 1, 11, NOW(), NOW()),
(12, 'Logitech', 'logitech', 'logitech.png', 'Wireless mice, mechanical keyboards, webcams, and speakers.', 1, 1, 12, NOW(), NOW());

-- 5. Services
INSERT IGNORE INTO `services` (`id`, `name`, `slug`, `short_description`, `description`, `icon`, `starting_price`, `turnaround_time`, `is_featured`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Chip-Level Motherboard Repair', 'chip-level-laptop-motherboard-repair', 'Microscopic diagnostics, BGA chip rework, short-circuit troubleshooting for dead laptops.', 'Advanced laboratory repair using professional BGA rework stations and precision thermal cameras. We repair dead laptops, power issues, GPU reballing, and water damage.', 'bi bi-tools', 999.00, '24 - 48 Hours', 1, 1, 1, NOW(), NOW()),
(2, 'Custom PC Building & Gaming Assembly', 'custom-pc-build-gaming-assembly', 'Custom component matching, clean cable management, stress testing, and BIOS tuning.', 'From budget editing rigs to ultra-high-end 4K gaming PCs, we hand-assemble, route cables neatly, optimize thermal airflow, and install all drivers.', 'bi bi-gear-wide-connected', 499.00, 'Same Day (4 - 6 Hours)', 1, 1, 2, NOW(), NOW()),
(3, 'CCTV Security Installation & AMC', 'cctv-camera-installation-amc', 'Full HD & IP CCTV setup, smartphone remote live view configuration, and annual maintenance.', 'End-to-end surveillance for shops, homes, offices, and factories in Dewas. Professional cable routing, DVR/NVR setup, and mobile viewing app configuration.', 'bi bi-camera-video-fill', 1499.00, '1 - 2 Days', 1, 1, 3, NOW(), NOW()),
(4, 'Laptop Screen, Keyboard & Battery Replacement', 'laptop-screen-battery-keyboard-replacement', '100% original OEM displays (FHD/IPS/144Hz), responsive keyboards, and genuine battery packs.', 'Quick replacement of broken screens, dim displays, malfunctioning keys, and swollen or degraded batteries with brand warranty.', 'bi bi-laptop-fill', 450.00, '1 - 3 Hours', 1, 1, 4, NOW(), NOW()),
(5, 'High-Speed SSD & RAM Upgrades', 'ssd-ram-speed-upgrade', 'Transform slow laptops and desktop PCs with lightning-fast NVMe/SATA SSDs and dual-channel RAM.', 'Make your old computer 10x faster with genuine Kingston, Crucial, and WD SSDs. We clone your existing Windows, files, and programs with zero data loss.', 'bi bi-speedometer2', 299.00, '30 - 60 Mins', 1, 1, 5, NOW(), NOW()),
(6, 'Laser & InkTank Printer Repair & Cartridge Refill', 'printer-repair-cartridge-refilling', 'Paper jam fixing, print head cleaning, logic board repair, and high-yield laser toner refilling.', 'Complete servicing for HP, Canon, Epson, and Brother printers. High-density black and color toner refilling with crisp output.', 'bi bi-printer-fill', 199.00, 'Same Day', 1, 1, 6, NOW(), NOW());

-- 6. Products
INSERT IGNORE INTO `products` (`id`, `category_id`, `brand_id`, `name`, `slug`, `model_number`, `sku`, `short_description`, `price`, `discount_price`, `stock_status`, `is_featured`, `is_hot_deal`, `is_active`, `warranty_info`, `created_at`, `updated_at`) VALUES
(1, 1, 3, 'ASUS TUF Gaming F15 (Intel Core i5 12th Gen / 16GB / 512GB SSD / RTX 3050)', 'asus-tuf-gaming-f15-i5-12th-gen-rtx3050', 'FX506HC-HN083W', 'BC-LAP-001', 'High-durability gaming laptop with 144Hz Adaptive-Sync display and military-grade toughness.', 74990.00, 68990.00, 'in_stock', 1, 1, 1, '1 Year Onsite Manufacturer Warranty', NOW(), NOW()),
(2, 1, 1, 'HP 15s (Intel Core i5 12th Gen / 16GB RAM / 512GB SSD / FHD 15.6\")', 'hp-15s-core-i5-12th-gen-16gb-512gb', '15s-fq5111TU', 'BC-LAP-002', 'Slim and lightweight everyday laptop with micro-edge anti-glare display and fast charging.', 58990.00, 52990.00, 'in_stock', 1, 0, 1, '1 Year Brand Warranty', NOW(), NOW()),
(3, 2, 5, 'Balaji CyberPro Custom Gaming PC (Core i5 13400F / RTX 4060 8GB / 16GB DDR5 / 1TB NVMe)', 'balaji-cyberpro-gaming-pc-rtx4060', 'BC-DESK-PRO', 'BC-PC-001', 'Custom built powerhouse for 1080p/1440p ultra gaming, video editing, and 3D rendering.', 84990.00, 78490.00, 'in_stock', 1, 1, 1, '3 Years Component-Level Warranty', NOW(), NOW()),
(4, 4, 11, 'Kingston NV2 1TB M.2 2280 NVMe PCIe 4.0 SSD', 'kingston-nv2-1tb-nvme-pcie-4-ssd', 'SNV2S/1000G', 'BC-SSD-001', 'Next-gen PCIe 4.0 NVMe speeds up to 3500MB/s read. Ideal for laptops and slim PCs.', 6499.00, 5399.00, 'in_stock', 1, 0, 1, '3 Years Replacement Warranty', NOW(), NOW()),
(5, 5, 9, 'CP PLUS 4-Camera Full HD 1080p CCTV Security Kit with 1TB HDD & DVR', 'cp-plus-4-camera-hd-cctv-security-package', 'CP-UVR-0401E1', 'BC-CCTV-001', 'Complete security surveillance package with night vision, motion detection, and mobile live view.', 14990.00, 11990.00, 'in_stock', 1, 1, 1, '2 Years Brand Warranty on Cameras & DVR', NOW(), NOW()),
(6, 6, 1, 'HP LaserJet Pro M126nw Wireless Multi-Function Laser Printer', 'hp-laserjet-pro-m126nw-multi-function-laser-printer', 'CZ178A', 'BC-PRN-001', 'Reliable monochrome laser print, scan, copy with Wi-Fi, Ethernet, and USB connectivity.', 21990.00, 19490.00, 'in_stock', 1, 0, 1, '1 Year Onsite Warranty', NOW(), NOW()),
(7, 7, 2, 'Dell 24\" FHD IPS Ultra-Slim Bezel Monitor (75Hz / AMD FreeSync / HDMI)', 'dell-24-inch-fhd-ips-monitor-s2421hn', 'S2421HN', 'BC-MON-001', 'Modern, elegant design with subtle textured pattern and dual HDMI ports.', 12990.00, 10490.00, 'in_stock', 1, 0, 1, '3 Years Advanced Exchange Service', NOW(), NOW()),
(8, 8, 12, 'Logitech MK295 Silent Wireless Keyboard and Mouse Combo', 'logitech-mk295-silent-wireless-keyboard-mouse-combo', '920-009814', 'BC-ACC-001', 'SilentTouch technology eliminates over 90% of disruptive clicking and typing noises.', 2995.00, 2290.00, 'in_stock', 1, 0, 1, '3 Years Limited Hardware Warranty', NOW(), NOW());

-- 7. Offers
INSERT IGNORE INTO `offers` (`id`, `title`, `slug`, `discount_text`, `coupon_code`, `description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Fast SSD Laptop Upgrade Offer', 'ssd-upgrade-combo', '₹500 Flat Off', 'SPEED500', 'Get ₹500 off on 512GB / 1TB Kingston NVMe SSD upgrade with free Windows & data migration.', 1, NOW(), NOW()),
(2, 'CCTV Full Setup Combo Deal', 'cctv-full-security-deal', '15% Discount', 'SAFEHOME', 'Complete 4-Camera HD CCTV setup package with free installation and mobile phone viewing setup.', 1, NOW(), NOW()),
(3, 'Custom PC Build Discount Package', 'custom-gaming-pc-deal', 'Free RGB Gaming Mouse', 'GAMERX', 'Get a free Logitech Gaming Mouse and mousepad on any custom desktop build above ₹45,000.', 1, NOW(), NOW());

-- 8. Presence Locations
INSERT IGNORE INTO `presence_locations` (`id`, `title`, `address`, `phone`, `email`, `opening_hours`, `google_maps_embed`, `is_primary`, `created_at`, `updated_at`) VALUES
(1, 'Balaji Computech - Main Showroom & Repair Lab', 'Shop No. 12, Mainashree Complex, Near Netram, AB Road, Dewas, Madhya Pradesh - 455001', '+91 98260 12345', 'info@balajicomputech.com', 'Mon - Sat: 10:00 AM - 08:30 PM | Sun: 11:00 AM - 04:00 PM', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117565.41926694665!2d76.00287612739345!3d22.959955745164283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39631742468bb03b%3A0x6b8b0e797e55fae2!2sDewas%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin\" width=\"100%\" height=\"350\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 1, NOW(), NOW());

-- 9. FAQs
INSERT IGNORE INTO `faqs` (`id`, `question`, `answer`, `category`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Where is Balaji Computech located in Dewas?', 'We are conveniently located at Shop No. 12, Mainashree Complex, Near Netram, AB Road, Dewas, Madhya Pradesh. You can visit us directly or call +91 98260 12345.', 'general', 1, 1, NOW(), NOW()),
(2, 'Do you repair dead laptops and water-damaged motherboards?', 'Yes! We specialize in chip-level motherboard repairing using micro-soldering, BGA rework stations, and component testing for all laptop brands including HP, Dell, Asus, and Lenovo.', 'services', 2, 1, NOW(), NOW()),
(3, 'Can I customize a gaming or editing PC according to my budget?', 'Absolutely! We help you select the exact processor, graphic card, motherboard, RAM, and cabinet to match your budget with no bottle-necking. Assembly and BIOS optimization are included.', 'products', 3, 1, NOW(), NOW()),
(4, 'Do all your hardware products come with official brand warranty?', 'Yes, 100% of our products are brand new, original, and sourced through authorized distributors carrying official manufacturer warranties across India.', 'products', 4, 1, NOW(), NOW()),
(5, 'How do I submit an inquiry or get a price quote?', 'Simply click \"Inquire Price\" on any product or service card, or click the WhatsApp button to chat directly with our shopkeeper Gourav Joshi for instant quotation.', 'general', 5, 1, NOW(), NOW()),
(6, 'Do you provide CCTV installation services at home or office?', 'Yes, we provide complete CCTV surveillance installation, cable routing, DVR/NVR configuration, and live mobile viewing setup anywhere in Dewas and nearby regions.', 'services', 6, 1, NOW(), NOW());

-- 10. Settings
INSERT IGNORE INTO `settings` (`id`, `setting_key`, `setting_value`, `setting_group`, `created_at`, `updated_at`) VALUES
(1, 'site_name', 'Balaji Computech', 'general', NOW(), NOW()),
(2, 'owner_name', 'Gourav Joshi', 'general', NOW(), NOW()),
(3, 'site_tagline', 'Premier Computer Store & Chip-Level Repairing Hub in Dewas', 'general', NOW(), NOW()),
(4, 'opening_hours', 'Mon - Sat: 10:00 AM - 08:30 PM | Sun: 11:00 AM - 04:00 PM', 'general', NOW(), NOW()),
(5, 'contact_phone', '+91 98260 12345', 'contact', NOW(), NOW()),
(6, 'whatsapp_number', '919826012345', 'contact', NOW(), NOW()),
(7, 'contact_email', 'info@balajicomputech.com', 'contact', NOW(), NOW()),
(8, 'shop_address', 'Shop No. 12, Mainashree Complex, Near Netram, AB Road, Dewas, MP - 455001', 'contact', NOW(), NOW()),
(9, 'hero_title', 'High-Performance Computers & Precision Repair Hub', 'homepage', NOW(), NOW()),
(10, 'hero_subtitle', 'Dewas\'s premier computer store for top brand laptops, custom gaming PCs, CCTV security surveillance, and chip-level motherboard repairing with genuine warranties.', 'homepage', NOW(), NOW()),
(11, 'meta_title', 'Balaji Computech | Best Computer Shop & Laptop Repair Center in Dewas', 'seo', NOW(), NOW()),
(12, 'meta_description', 'Balaji Computech in Dewas offers branded laptops, custom gaming desktop builds, CCTV surveillance systems, chip-level laptop repairs, and authentic PC hardware by Gourav Joshi.', 'seo', NOW(), NOW()),
(13, 'google_maps_embed', '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d117565.41926694665!2d76.00287612739345!3d22.959955745164283!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39631742468bb03b%3A0x6b8b0e797e55fae2!2sDewas%2C%20Madhya%20Pradesh!5e0!3m2!1sen!2sin!4v1700000000000!5m2!1sen!2sin\" width=\"100%\" height=\"350\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', 'contact', NOW(), NOW());

-- 11. Static Pages
INSERT IGNORE INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'About Balaji Computech', 'about-us', '<h3>About Balaji Computech, Dewas</h3><p>Founded by <strong>Gourav Joshi</strong>, Balaji Computech is Dewas\'s most dependable computer hardware store and diagnostic lab. We provide authentic laptops, customized gaming desktop builds, enterprise CCTV security solutions, and chip-level motherboard repairing services.</p>', 'About Us | Balaji Computech Dewas', 'Learn about Balaji Computech, our founder Gourav Joshi, and our mission.', 1, NOW(), NOW()),
(2, 'Terms and Conditions', 'terms-and-conditions', '<h3>Terms and Conditions</h3><p>Welcome to Balaji Computech. All quotations, hardware sales, and warranty service terms are governed by manufacturer guidelines and local store policy.</p>', 'Terms and Conditions | Balaji Computech', 'Terms of service and policies.', 1, NOW(), NOW()),
(3, 'Privacy Policy', 'privacy-policy', '<h3>Privacy Policy</h3><p>Your privacy is important to us. Balaji Computech respects your customer inquiry information and never shares personal data with third parties.</p>', 'Privacy Policy | Balaji Computech', 'Privacy policy for website visitors and customers.', 1, NOW(), NOW()),
(4, 'Return and Inquiry Policy', 'return-and-inquiry-policy', '<h3>Return and Inquiry Policy</h3><p>All brand new hardware products carry official manufacturer warranties. For repairs and custom builds, testing is conducted prior to delivery.</p>', 'Return & Inquiry Policy | Balaji Computech', 'Return and customer service inquiry guidelines.', 1, NOW(), NOW()),
(5, 'Disclaimer', 'disclaimer', '<h3>Disclaimer</h3><p>All brand names, logos, and registered trademarks (HP, Dell, Asus, Lenovo, Intel, AMD, etc.) belong to their respective corporate owners.</p>', 'Disclaimer | Balaji Computech', 'Legal disclaimer for Balaji Computech website.', 1, NOW(), NOW());

SET FOREIGN_KEY_CHECKS = 1;
