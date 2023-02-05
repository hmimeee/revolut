<?php

use Hmimeee\Revolut\TestCase;

class WebhookTest extends TestCase
{
    /**
     * Test add a new webhook endpoint
     * 
     * @group RevolutTest
     */
    public function test_add_webhook()
    {
        $response = $this->revolut->setWebhook('https://example.com/webhook');

        $this->assertTrue($response['status']);
    }

    /**
     * Test get all webhook endpoints list
     * 
     * @group RevolutTest
     */
    public function test_get_webhooks()
    {
        $response = $this->revolut->retrieveWebhooks();

        $this->assertTrue($response['status']);
    }

    /**
     * Test delete a webhook endpoint
     * 
     * @group RevolutTest
     */
    public function test_delete_webhook()
    {
        $response = $this->revolut->retrieveWebhooks();
        $webhooks = $response['data'];

        $response = $this->revolut->deleteWebhook(reset($webhooks)->id);

        $this->assertTrue($response['status']);
    }
}
