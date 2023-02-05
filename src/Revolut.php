<?php

namespace Hmimeee\Revolut;

class Revolut extends RevolutClient
{
    /**
     * Get the revolut instance return
     * 
     * @return \Hmimeee\Revolut
     */
    public static function instance()
    {
        return new self;
    }

    /**
     * Create an order to charge the customer
     * 
     * @param array $options Options to be passed such as
     * `[
     *  'amount' => 1210, The amount must be the smallest currency unit like (from $12.10 to 1210),
     *  'currency' => "USD", Currency type such as "GBP", "USD", etc.
     *  'name' => "John", Can skip it as it's optional.
     *  'email' => "john@gmail.com", Can skip it as it's optional.
     *  'description' => "An example order", Can skip it as it's optional.
     * ]`
     * @return mixed
     */
    public function createOrder(array $options)
    {
        $data = array_merge(
            [
                'amount' => 0,
                'currency' => 'GBP',
                'name' => null,
                'email' => null,
                'description' => null,
            ],
            $options
        );

        $response = $this->request("orders", $data, 'POST');

        return $response;
    }

    /**
     * Set new webhook along with events
     * 
     * @param string $url
     * @param array $events
     * @return array
     */
    public function setWebhook(string $url, array $events = ['ORDER_COMPLETED', 'ORDER_AUTHORISED']): array
    {
        $data = $this->request('webhooks', [
            'url' => $url,
            'events' => $events
        ], 'POST');

        return $data;
    }

    /**
     * Get the list of all webhooks
     * 
     * @return array
     */
    public function retrieveWebhooks(): array
    {
        $data = $this->request('webhooks');

        return $data;
    }

    /**
     * Delete a webhook data
     * 
     * @param string $id
     * @return array
     */
    public function deleteWebhook(string $id): array
    {
        $data = $this->request("webhooks/$id", null, 'DELETE');

        return $data;
    }
}
