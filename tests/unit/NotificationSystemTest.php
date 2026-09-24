<?php

namespace Tests\Unit;

use CodeIgniter\Test\CIUnitTestCase;
use App\Models\NotificationTokenModel;
use App\Libraries\FirebaseNotificationService;
use Config\Firebase as FirebaseConfig;

/**
 * @internal
 */
final class NotificationSystemTest extends CIUnitTestCase
{
    protected NotificationTokenModel $tokenModel;

    protected function setUp(): void
    {
        parent::setUp();
        $this->tokenModel = new NotificationTokenModel();
    }

    public function testTokenSaveAndRetrieval()
    {
        $testUserId = 1;
        $testToken = 'test_fcm_token_unit_' . uniqid();

        // 1. Save Token
        $id = $this->tokenModel->saveOrUpdateToken($testUserId, $testToken, 'desktop', 'Chrome', 'Windows');
        $this->assertNotEmpty($id);

        // 2. Retrieve Active Tokens
        $tokens = $this->tokenModel->getActiveTokensByUser($testUserId);
        $this->assertContains($testToken, $tokens);

        // 3. Count
        $count = $this->tokenModel->getActiveTokensCount($testUserId);
        $this->assertGreaterThanOrEqual(1, $count);

        // 4. Update Token (avoid duplication)
        $updateId = $this->tokenModel->saveOrUpdateToken($testUserId, $testToken, 'mobile', 'Chrome Mobile', 'Android');
        $this->assertSame($id, $updateId);

        // 5. Deactivate
        $deactivated = $this->tokenModel->deactivateToken($testToken);
        $this->assertTrue($deactivated);

        $tokensAfter = $this->tokenModel->getActiveTokensByUser($testUserId);
        $this->assertNotContains($testToken, $tokensAfter);

        // Cleanup test record
        $this->tokenModel->delete($id);
    }

    public function testFirebaseServiceInstantiation()
    {
        $config = new FirebaseConfig();
        $service = new FirebaseNotificationService($config);
        $this->assertInstanceOf(FirebaseNotificationService::class, $service);
    }
}
