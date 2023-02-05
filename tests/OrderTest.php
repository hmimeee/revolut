<?php

use Hmimeee\Revolut\TestCase;

class OrderTest extends TestCase
{
    /**
     * Test creation of an order
     * 
     * @group RevolutTest
     */
    public function test_create_order()
    {
        $response = $this->revolut->createOrder([
            'amount' => 1200,
            'currency' => 'GBP',
            'name' => 'Imran Hossen',
            'email' => 'hmimeee@gmail.com',
            'description' => 'An order to test the gateway'
        ]);

        $this->assertTrue($response['status']);
    }
}
