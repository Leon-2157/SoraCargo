-- =========================================================================
-- SoraCargo Enterprise — Initial Seed Data
-- =========================================================================

-- 1. Users (Admin, Operators, Shippers)
INSERT INTO public.users (id, name, email, password, phone, user_type, admin_role, status, two_factor_enabled_at)
VALUES 
    -- Superadmin
    ('a0000000-0000-0000-0000-000000000001', 'Superadmin Valerie', 'valerie.admin@soracargo.com', '$2y$12$eA8b7w9OqR5kM7p4S3L9e.6l2hB4Z9oK8uJ2mN1xP0qW7vT6yY8u', '+628111222333', 'ADMIN_USER', 'SUPER_ADMIN', 'ACTIVE', CURRENT_TIMESTAMP),
    ('a0000000-0000-0000-0000-000000000002', 'Budi Santoso (Finance Lead)', 'finance.lead@soracargo.com', '$2y$12$eA8b7w9OqR5kM7p4S3L9e.6l2hB4Z9oK8uJ2mN1xP0qW7vT6yY8u', '+628111222334', 'ADMIN_USER', 'FINANCE_ADMIN', 'ACTIVE', CURRENT_TIMESTAMP),
    -- Operators
    ('b0000000-0000-0000-0000-000000000001', 'Bambang Haryanto', 'bambang.ops@soracargo.com', '$2y$12$eA8b7w9OqR5kM7p4S3L9e.6l2hB4Z9oK8uJ2mN1xP0qW7vT6yY8u', '+628123456781', 'OPERATOR_USER', NULL, 'ACTIVE', CURRENT_TIMESTAMP),
    ('b0000000-0000-0000-0000-000000000002', 'Siti Rahmawati', 'siti.ops@soracargo.com', '$2y$12$eA8b7w9OqR5kM7p4S3L9e.6l2hB4Z9oK8uJ2mN1xP0qW7vT6yY8u', '+628123456782', 'OPERATOR_USER', NULL, 'ACTIVE', CURRENT_TIMESTAMP),
    -- Retail Shipper
    ('c0000000-0000-0000-0000-000000000001', 'Ahmad Zaki (UMKM Kopi)', 'ahmad.zaki@gmail.com', '$2y$12$eA8b7w9OqR5kM7p4S3L9e.6l2hB4Z9oK8uJ2mN1xP0qW7vT6yY8u', '+6285711223344', 'RETAIL_CUSTOMER', NULL, 'ACTIVE', NULL),
    -- Corporate Shipper
    ('c0000000-0000-0000-0000-000000000002', 'Hendra Tan (PT Maju Logistik)', 'hendra@majulogistik.co.id', '$2y$12$eA8b7w9OqR5kM7p4S3L9e.6l2hB4Z9oK8uJ2mN1xP0qW7vT6yY8u', '+628118899001', 'CORPORATE_USER', NULL, 'ACTIVE', CURRENT_TIMESTAMP)
ON CONFLICT (id) DO NOTHING;

-- 2. Companies (B2B Corporate)
INSERT INTO public.companies (id, user_id, company_name, nib, npwp, company_address, pic_name, pic_phone)
VALUES 
    ('d0000000-0000-0000-0000-000000000001', 'c0000000-0000-0000-0000-000000000002', 'PT Maju Logistik Nusantara', '9120001234567', '01.234.567.8-012.000', 'Kawasan Industri MM2100 Blok C-4, Cikarang Barat, Bekasi', 'Hendra Tan', '+628118899001')
ON CONFLICT (id) DO NOTHING;

-- 3. Ports & Depots
INSERT INTO public.ports (id, name, city, country_code, port_type, latitude, longitude, terminal_cy_capacity_teus)
VALUES 
    ('IDJKT', 'Pelabuhan Tanjung Priok', 'Jakarta Utara', 'ID', 'SEAPORT', -6.103333, 106.882778, 15000),
    ('IDSUB', 'Pelabuhan Tanjung Perak', 'Surabaya', 'ID', 'SEAPORT', -7.202500, 112.730556, 12000),
    ('IDBTM', 'Pelabuhan Batu Ampar', 'Batam', 'ID', 'SEAPORT', 1.157500, 103.996111, 8000),
    ('SGSIN', 'Port of Singapore', 'Singapore', 'SG', 'SEAPORT', 1.264444, 103.840000, 35000)
ON CONFLICT (id) DO NOTHING;

-- 4. Routes
INSERT INTO public.routes (id, origin_port_id, destination_port_id, transport_mode, base_rate_per_kg, base_rate_per_cbm, estimated_transit_hours, is_weather_hold)
VALUES 
    ('e0000000-0000-0000-0000-000000000001', 'IDJKT', 'IDSUB', 'SEA_RORO', 2500.00, 650000.00, 36, FALSE),
    ('e0000000-0000-0000-0000-000000000002', 'IDJKT', 'IDBTM', 'SEA_CONTAINER', 3800.00, 950000.00, 48, FALSE),
    ('e0000000-0000-0000-0000-000000000003', 'IDBTM', 'SGSIN', 'SEA_CONTAINER', 4500.00, 1200000.00, 12, FALSE)
ON CONFLICT (id) DO NOTHING;

-- 5. HS Codes
INSERT INTO public.hs_codes (code, description_id, description_en, import_duty_pct, vat_pct, income_tax_pct, has_lartas_restriction, required_permit_agency)
VALUES 
    ('0901.11.10', 'Biji Kopi Robusta Tidak Digongseng', 'Coffee, not roasted, not decaffeinated, Robusta', 5.00, 11.00, 2.50, TRUE, 'Badan Karantina Indonesia'),
    ('8471.30.20', 'Laptop dan Mesin Pengolah Data Portabel', 'Portable automatic data processing machines', 0.00, 11.00, 2.50, TRUE, 'Kementerian Perindustrian (SDPPI)'),
    ('2905.11.00', 'Metanol (Metil Alkohol)', 'Methanol (methyl alcohol)', 5.00, 11.00, 2.50, TRUE, 'Kemenperin / Ditjen Bea Cukai (DG Class 3)')
ON CONFLICT (code) DO NOTHING;

-- 6. Exchange Rates
INSERT INTO public.exchange_rates (currency_pair, rate, locked_at, expires_at)
VALUES 
    ('USD/IDR', 15850.0000, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP + INTERVAL '24 hours'),
    ('SGD/IDR', 11920.0000, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP + INTERVAL '24 hours'),
    ('MYR/IDR', 3580.0000, CURRENT_TIMESTAMP, CURRENT_TIMESTAMP + INTERVAL '24 hours');

-- 7. Operator Profiles
INSERT INTO ops.operator_profiles (id, user_id, employee_id, assigned_hub_id, role_tier, kpi_rating, is_on_duty)
VALUES 
    ('f0000000-0000-0000-0000-000000000001', 'b0000000-0000-0000-0000-000000000001', 'OPS-JKT-042', 'IDJKT', 'OPERATOR_INTERNATIONAL', 4.95, TRUE),
    ('f0000000-0000-0000-0000-000000000002', 'b0000000-0000-0000-0000-000000000002', 'OPS-SUB-018', 'IDSUB', 'OPERATOR_DOMESTIC', 4.88, TRUE)
ON CONFLICT (id) DO NOTHING;

-- 8. Corporate Credit & Limits
INSERT INTO admin.corporate_credits (id, company_id, credit_limit_amount, used_credit_amount, top_days, kyc_status, bank_guarantee_ref, debt_enforcement_stage)
VALUES 
    ('10000000-0000-0000-0000-000000000001', 'd0000000-0000-0000-0000-000000000001', 500000000.00, 142000000.00, 45, 'VERIFIED_APPROVED', 'BG-BCA-2026-88912', 'HEALTHY')
ON CONFLICT (company_id) DO NOTHING;

-- 9. System Settings
INSERT INTO admin.system_settings (key, value, group_name, description)
VALUES 
    ('ai_model_name', 'gemini-1.5-pro', 'ai_engine', 'Model LLM aktif untuk bot asisten logistik'),
    ('ai_system_prompt', 'Anda adalah SoraBot, AI Copilot operasional logistik maritim SoraCargo...', 'ai_engine', 'System prompt acuan analisis manifes dan regulasi kepabeanan'),
    ('platform_fee_default_pct', '12.5', 'financial', 'Persentase margin platform standar untuk setiap transaksi kargo'),
    ('wa_daily_quota', '5000', 'gateways', 'Batas kuota pengiriman pesan harian WhatsApp Baileys Gateway')
ON CONFLICT (key) DO UPDATE SET value = EXCLUDED.value;

-- 10. Gateway Sessions
INSERT INTO admin.gateway_sessions (id, channel_type, connection_status, paired_phone_number, remaining_quota_daily, last_ping_at)
VALUES 
    ('wa_gateway_session_01', 'WHATSAPP_BAILEYS', 'CONNECTED', '+6281199887766', 4820, CURRENT_TIMESTAMP),
    ('smtp_gateway_session_01', 'EMAIL_SMTP', 'CONNECTED', 'notifications@soracargo.com', 9500, CURRENT_TIMESTAMP)
ON CONFLICT (id) DO NOTHING;

