<?php

namespace Tests\Feature;

use Tests\TestCase;

class DashboardTest extends TestCase
{
    /**
     * Test that the customer dashboard loads successfully.
     */
    public function test_customer_dashboard_screen_can_be_rendered(): void
    {
        $response = $this->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('SoraCargo');
        $response->assertSee('Portal Customer');
        $response->assertSee('Trafik Aktifitas 7 Hari');
        $response->assertSee('Riwayat Pengiriman 7 Hari');
        $response->assertSee('Daftar Cargo Sedang Jalan');
        $response->assertSee('Chat dengan AI');
    }
}

