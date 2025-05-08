<?php

namespace Tests\APIs;

use App\Models\Payment;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Tests\ApiTestTrait;
use Tests\TestCase;

class PaymentApiTest extends TestCase
{
    use ApiTestTrait, DatabaseTransactions, WithoutMiddleware;

    /**
     * @test
     */
    public function test_create_payment()
    {
        $payment = Payment::factory()->make()->toArray();

        $this->response = $this->json(
            'POST',
            '/api/payments', $payment
        );

        $this->assertApiResponse($payment);
    }

    /**
     * @test
     */
    public function test_read_payment()
    {
        $payment = Payment::factory()->create();

        $this->response = $this->json(
            'GET',
            '/api/payments/'.$payment->id
        );

        $this->assertApiResponse($payment->toArray());
    }

    /**
     * @test
     */
    public function test_update_payment()
    {
        $payment = Payment::factory()->create();
        $editedPayment = Payment::factory()->make()->toArray();

        $this->response = $this->json(
            'PUT',
            '/api/payments/'.$payment->id,
            $editedPayment
        );

        $this->assertApiResponse($editedPayment);
    }

    /**
     * @test
     */
    public function test_delete_payment()
    {
        $payment = Payment::factory()->create();

        $this->response = $this->json(
            'DELETE',
            '/api/payments/'.$payment->id
        );

        $this->assertApiSuccess();
        $this->response = $this->json(
            'GET',
            '/api/payments/'.$payment->id
        );

        $this->response->assertStatus(404);
    }
}
