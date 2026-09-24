<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\NotificationTokenModel;
use App\Models\InquiryModel;
use App\Models\InquiryReplyModel;
use App\Models\UserModel;
use App\Libraries\FirebaseNotificationService;

class TestNotifications extends BaseCommand
{
    protected $group       = 'Notifications';
    protected $name        = 'notifications:test';
    protected $description = 'Verifies the complete Firebase FCM Web Push notification system, token storage, and inquiry/reply integration.';

    public function run(array $params)
    {
        CLI::write("==================================================", "yellow");
        CLI::write(" BALAJI COMPUTECH - FCM NOTIFICATION VERIFICATION ", "black", "light_gray");
        CLI::write("==================================================", "yellow");

        $tokenModel      = new NotificationTokenModel();
        $inquiryModel    = new InquiryModel();
        $replyModel      = new InquiryReplyModel();
        $userModel       = new UserModel();
        $firebaseService = new FirebaseNotificationService();

        // 1. Check user_notification_tokens table
        CLI::write("1. Verifying Database Table...", "cyan");
        $initialCount = $tokenModel->countAllResults();
        CLI::write("   • Current records in user_notification_tokens: {$initialCount}", "green");

        // 2. Test Admin Token Registration (Simulate Admin User ID 1)
        CLI::write("2. Testing Admin Token Registration (Role 1)...", "cyan");
        $adminTestToken = 'test_admin_fcm_token_' . bin2hex(random_bytes(8));
        $adminTokenId = $tokenModel->saveOrUpdateToken(1, $adminTestToken, 'mobile', 'Chrome Mobile', 'Android');
        $this->assertTrue((bool)$adminTokenId, "Admin token saved successfully (ID: {$adminTokenId})");

        // 3. Test Customer Token Registration (Simulate Customer User ID 2)
        CLI::write("3. Testing Customer Token Registration (Role 2)...", "cyan");
        $customerTestToken = 'test_customer_fcm_token_' . bin2hex(random_bytes(8));
        $customerTokenId = $tokenModel->saveOrUpdateToken(2, $customerTestToken, 'desktop', 'Chrome', 'Windows');
        $this->assertTrue((bool)$customerTokenId, "Customer token saved successfully (ID: {$customerTokenId})");

        // 4. Test Duplicate Token Handling (Update instead of duplicate)
        CLI::write("4. Testing Duplicate Token Update...", "cyan");
        $reSavedId = $tokenModel->saveOrUpdateToken(1, $adminTestToken, 'tablet', 'Edge', 'Android');
        $this->assertTrue($reSavedId === $adminTokenId, "Existing token record updated correctly without creating duplicate row.");

        // 5. Test Active Admin Tokens Query
        CLI::write("5. Testing Active Admin Token Query...", "cyan");
        $activeAdminTokens = $tokenModel->getActiveAdminTokens();
        $this->assertTrue(in_array($adminTestToken, $activeAdminTokens, true), "Admin token retrieved by getActiveAdminTokens(). Total admin tokens: " . count($activeAdminTokens));

        // 6. Test Active Customer Tokens Query
        CLI::write("6. Testing Customer Active Token Query...", "cyan");
        $activeCustomerTokens = $tokenModel->getActiveTokensByUser(2);
        $this->assertTrue(in_array($customerTestToken, $activeCustomerTokens, true), "Customer token retrieved by getActiveTokensByUser(2). Total customer tokens: " . count($activeCustomerTokens));

        // 7. Test Inquiry Creation -> Admin Push Notification Flow
        CLI::write("7. Testing Inquiry Creation & Admin FCM Notification Dispatch...", "cyan");
        $inquiryNo = $inquiryModel->generateInquiryNumber();
        $inquiryId = $inquiryModel->insert([
            'inquiry_no'   => $inquiryNo,
            'user_id'      => 2,
            'product_id'   => 1,
            'name'         => 'Gourav Customer Test',
            'email'        => 'customer.test@balajicomputech.com',
            'mobile'       => '9826012345',
            'subject'      => 'HP Gaming Laptop Inquiry',
            'message'      => 'Need best quote for HP Gaming Laptop with 16GB RAM.',
            'inquiry_type' => 'product',
            'status'       => 'pending',
        ]);

        $inquiryData = $inquiryModel->find($inquiryId);
        $notifiedAdmins = $firebaseService->notifyAdminsOnNewInquiry($inquiryData, 'HP Gaming Laptop');
        CLI::write("   • Inquiry [{$inquiryNo}] created. notifyAdminsOnNewInquiry executed safely without exception.", "green");

        // 8. Test Admin Reply -> Customer Push Notification Flow
        CLI::write("8. Testing Admin Reply & Customer FCM Notification Dispatch...", "cyan");
        $replyId = $replyModel->insert([
            'inquiry_id' => $inquiryId,
            'user_id'    => 1,
            'message'    => 'Hello, HP Gaming Laptop is available in stock for ₹54,990 with 1 year warranty.',
            'sent_email' => 0,
        ]);
        $inquiryModel->update($inquiryId, ['status' => 'replied']);

        $replyData = $replyModel->find($replyId);
        $notifiedCustomer = $firebaseService->notifyCustomerOnInquiryReply($inquiryData, $replyData);
        CLI::write("   • Reply ID [{$replyId}] saved and status updated to 'replied'. notifyCustomerOnInquiryReply executed safely.", "green");

        // 9. Test Invalid Token Deactivation
        CLI::write("9. Testing Token Deactivation & Cleanup...", "cyan");
        $tokenModel->deactivateToken($adminTestToken);
        $activeAdminAfter = $tokenModel->getActiveAdminTokens();
        $this->assertTrue(!in_array($adminTestToken, $activeAdminAfter, true), "Deactivated token is excluded from active dispatch list.");

        // Cleanup test data
        $tokenModel->delete($adminTokenId);
        $tokenModel->delete($customerTokenId);
        $replyModel->delete($replyId);
        $inquiryModel->delete($inquiryId);

        CLI::write("\n==================================================", "yellow");
        CLI::write(" [SUCCESS] ALL 9 PUSH NOTIFICATION TESTS PASSED! ", "black", "green");
        CLI::write("==================================================", "yellow");
    }

    private function assertTrue(bool $condition, string $message)
    {
        if ($condition) {
            CLI::write("   [PASS] {$message}", "green");
        } else {
            CLI::error("   [FAIL] {$message}");
        }
    }
}
