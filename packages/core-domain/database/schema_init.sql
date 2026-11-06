-- =========================================================================
-- SoraCargo Enterprise — Master Database Schema Initialization
-- Multi-Schema Architecture: public, ops, admin
-- Compatible with PostgreSQL 16
-- =========================================================================

-- Enable UUID extension
CREATE EXTENSION IF NOT EXISTS "uuid-ossp";

-- Create Schemas
CREATE SCHEMA IF NOT EXISTS ops;
CREATE SCHEMA IF NOT EXISTS admin;

-- =========================================================================
-- 1. SCHEMA: public (Shared Master & Identity Data)
-- =========================================================================

-- Table 1: public.users
CREATE TABLE IF NOT EXISTS public.users (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(50),
    user_type VARCHAR(50) NOT NULL DEFAULT 'RETAIL_CUSTOMER', -- RETAIL_CUSTOMER, CORPORATE_USER, OPERATOR_USER, ADMIN_USER
    admin_role VARCHAR(50) NULL, -- SUPER_ADMIN, FINANCE_ADMIN, DISPATCH_ADMIN, COMPLIANCE_ADMIN
    status VARCHAR(50) NOT NULL DEFAULT 'ACTIVE', -- ACTIVE, BOOKING_LOCKED, BLACKLISTED, SUSPENDED
    two_factor_secret VARCHAR(255) NULL,
    two_factor_enabled_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 2: public.companies
CREATE TABLE IF NOT EXISTS public.companies (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    user_id UUID NOT NULL REFERENCES public.users(id) ON DELETE CASCADE,
    company_name VARCHAR(255) NOT NULL,
    nib VARCHAR(50) UNIQUE NOT NULL,
    npwp VARCHAR(50) UNIQUE NOT NULL,
    company_address TEXT NOT NULL,
    pic_name VARCHAR(255) NOT NULL,
    pic_phone VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 3: public.ports
CREATE TABLE IF NOT EXISTS public.ports (
    id VARCHAR(10) PRIMARY KEY, -- e.g. IDJKT, IDSUB, IDBTM, SGSIN
    name VARCHAR(255) NOT NULL,
    city VARCHAR(100) NOT NULL,
    country_code VARCHAR(5) NOT NULL DEFAULT 'ID',
    port_type VARCHAR(50) NOT NULL DEFAULT 'SEAPORT', -- SEAPORT, AIRPORT, LAND_HUB
    latitude DECIMAL(10, 7) NOT NULL,
    longitude DECIMAL(10, 7) NOT NULL,
    terminal_cy_capacity_teus INT NOT NULL DEFAULT 5000,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 4: public.routes
CREATE TABLE IF NOT EXISTS public.routes (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    origin_port_id VARCHAR(10) NOT NULL REFERENCES public.ports(id),
    destination_port_id VARCHAR(10) NOT NULL REFERENCES public.ports(id),
    transport_mode VARCHAR(50) NOT NULL DEFAULT 'SEA_CONTAINER', -- SEA_RORO, SEA_CONTAINER, LAND_TRUCK, AIR_CARGO
    base_rate_per_kg DECIMAL(12, 2) NOT NULL,
    base_rate_per_cbm DECIMAL(12, 2) NOT NULL,
    estimated_transit_hours INT NOT NULL,
    is_weather_hold BOOLEAN NOT NULL DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 5: public.hs_codes
CREATE TABLE IF NOT EXISTS public.hs_codes (
    code VARCHAR(15) PRIMARY KEY, -- 8-digit e.g. 0901.11.10
    description_id TEXT NOT NULL,
    description_en TEXT NULL,
    import_duty_pct DECIMAL(5, 2) NOT NULL DEFAULT 0.00,
    vat_pct DECIMAL(5, 2) NOT NULL DEFAULT 11.00,
    income_tax_pct DECIMAL(5, 2) NOT NULL DEFAULT 2.50,
    has_lartas_restriction BOOLEAN NOT NULL DEFAULT FALSE,
    required_permit_agency VARCHAR(100) NULL, -- BPOM, Kemenperin, Kementan
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 6: public.exchange_rates
CREATE TABLE IF NOT EXISTS public.exchange_rates (
    id BIGSERIAL PRIMARY KEY,
    currency_pair VARCHAR(10) NOT NULL, -- USD/IDR, SGD/IDR, MYR/IDR
    rate DECIMAL(14, 4) NOT NULL,
    locked_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    expires_at TIMESTAMP NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================================================
-- 2. SCHEMA: ops (Logistics, Fleet & Field Operations)
-- =========================================================================

-- Table 7: ops.operator_profiles
CREATE TABLE IF NOT EXISTS ops.operator_profiles (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    user_id UUID NOT NULL REFERENCES public.users(id) ON DELETE CASCADE,
    employee_id VARCHAR(50) UNIQUE NOT NULL, -- OPS-JKT-042
    assigned_hub_id VARCHAR(10) NOT NULL REFERENCES public.ports(id),
    role_tier VARCHAR(50) NOT NULL DEFAULT 'OPERATOR_DOMESTIC', -- OPERATOR_DOMESTIC, OPERATOR_INTERNATIONAL
    wireguard_pubkey VARCHAR(255) NULL,
    device_fingerprint VARCHAR(255) NULL,
    kpi_rating DECIMAL(3, 2) NOT NULL DEFAULT 5.00,
    is_on_duty BOOLEAN NOT NULL DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 8: ops.cargo_bookings
CREATE TABLE IF NOT EXISTS ops.cargo_bookings (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    tracking_number VARCHAR(50) UNIQUE NOT NULL, -- RPN-20261106-001
    shipper_id UUID NOT NULL REFERENCES public.users(id),
    company_id UUID NULL REFERENCES public.companies(id),
    route_id UUID NOT NULL REFERENCES public.routes(id),
    hs_code VARCHAR(15) NULL REFERENCES public.hs_codes(code),
    booking_type VARCHAR(50) NOT NULL DEFAULT 'RETAIL_LCL', -- RETAIL_LCL, CORPORATE_FCL, CHARTER_TRUCK
    cargo_type VARCHAR(50) NOT NULL DEFAULT 'GENERAL_CARGO', -- GENERAL_CARGO, DANGEROUS_GOODS, REEFER_PERISHABLE
    total_weight_kg DECIMAL(10, 2) NOT NULL,
    total_volume_cbm DECIMAL(10, 2) NOT NULL,
    declared_goods_value DECIMAL(16, 2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'IDR',
    cargo_status VARCHAR(50) NOT NULL DEFAULT 'BOOKED', -- DRAFT, BOOKED, GATE_IN, CUSTOMS_INSPECTION, SAILING, DELIVERED, WEATHER_HOLD, CLAIM_HOLD, CANCELLED
    customs_channel VARCHAR(20) NULL, -- GREEN_CHANNEL, YELLOW_CHANNEL, RED_CHANNEL
    assigned_operator_id UUID NULL REFERENCES ops.operator_profiles(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 9: ops.manifests
CREATE TABLE IF NOT EXISTS ops.manifests (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    manifest_number VARCHAR(50) UNIQUE NOT NULL, -- MMK-JKT-SUB-20261106
    origin_port_id VARCHAR(10) NOT NULL REFERENCES public.ports(id),
    destination_port_id VARCHAR(10) NOT NULL REFERENCES public.ports(id),
    vessel_or_vehicle_name VARCHAR(255) NOT NULL, -- KM Sora Bahari 08
    voyage_number VARCHAR(50) NOT NULL,
    departure_eta TIMESTAMP NOT NULL,
    arrival_eta TIMESTAMP NOT NULL,
    status VARCHAR(50) NOT NULL DEFAULT 'PREPARING', -- PREPARING, LOCKED_SEALED, SAILING, ARRIVED, UNLOADED
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 10: ops.manifest_items
CREATE TABLE IF NOT EXISTS ops.manifest_items (
    id BIGSERIAL PRIMARY KEY,
    manifest_id UUID NOT NULL REFERENCES ops.manifests(id) ON DELETE CASCADE,
    cargo_booking_id UUID NOT NULL REFERENCES ops.cargo_bookings(id),
    container_serial_number VARCHAR(20) NOT NULL, -- SRAU-728192-0 (ISO 6346)
    container_type VARCHAR(50) NOT NULL DEFAULT 'DRY_20FT', -- DRY_20FT, DRY_40FT, REEFER_40HC
    seal_number VARCHAR(50) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 11: ops.tracking_events
CREATE TABLE IF NOT EXISTS ops.tracking_events (
    id BIGSERIAL PRIMARY KEY,
    cargo_booking_id UUID NOT NULL REFERENCES ops.cargo_bookings(id) ON DELETE CASCADE,
    event_name VARCHAR(255) NOT NULL,
    current_status VARCHAR(50) NOT NULL,
    latitude DECIMAL(10, 7) NOT NULL,
    longitude DECIMAL(10, 7) NOT NULL,
    operator_id UUID NULL REFERENCES ops.operator_profiles(id),
    event_timestamp TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 12: ops.incident_escalations
CREATE TABLE IF NOT EXISTS ops.incident_escalations (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    incident_ticket_no VARCHAR(50) UNIQUE NOT NULL, -- ESC-20261106-004
    cargo_booking_id UUID NOT NULL REFERENCES ops.cargo_bookings(id),
    reporter_operator_id UUID NOT NULL REFERENCES ops.operator_profiles(id),
    incident_type VARCHAR(50) NOT NULL, -- FIELD_COST, DAMAGE_CLAIM, SLA_BREACH, WEATHER_HOLD
    requested_amount DECIMAL(14, 2) NULL,
    bap_document_path VARCHAR(255) NULL,
    approval_status VARCHAR(50) NOT NULL DEFAULT 'PENDING_REVIEW', -- PENDING_REVIEW, APPROVED_BY_ADMIN, REJECTED, INSURANCE_PROCESSED
    admin_notes TEXT NULL,
    sla_response_minutes INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =========================================================================
-- 3. SCHEMA: admin (Financial Ledger, Governance & Security)
-- =========================================================================

-- Table 13: admin.corporate_credits
CREATE TABLE IF NOT EXISTS admin.corporate_credits (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    company_id UUID UNIQUE NOT NULL REFERENCES public.companies(id) ON DELETE CASCADE,
    credit_limit_amount DECIMAL(16, 2) NOT NULL DEFAULT 0.00,
    used_credit_amount DECIMAL(16, 2) NOT NULL DEFAULT 0.00,
    top_days INT NOT NULL DEFAULT 30, -- 30, 45, 60 hari
    kyc_status VARCHAR(50) NOT NULL DEFAULT 'PENDING_VERIFICATION', -- PENDING_VERIFICATION, VERIFIED_APPROVED, REJECTED
    bank_guarantee_ref VARCHAR(100) NULL,
    debt_enforcement_stage VARCHAR(50) NOT NULL DEFAULT 'HEALTHY', -- HEALTHY, SP1_ISSUED, SP2_LOCKED, SP3_LEGAL_COLLECTION
    verified_by_admin_id UUID NULL REFERENCES public.users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 14: admin.escrow_ledgers
CREATE TABLE IF NOT EXISTS admin.escrow_ledgers (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    cargo_booking_id UUID UNIQUE NOT NULL REFERENCES ops.cargo_bookings(id) ON DELETE CASCADE,
    total_paid_amount DECIMAL(16, 2) NOT NULL,
    milestone_1_pickup_amount DECIMAL(16, 2) NOT NULL, -- 30%
    milestone_1_released_at TIMESTAMP NULL,
    milestone_2_sailing_amount DECIMAL(16, 2) NOT NULL, -- 40%
    milestone_2_released_at TIMESTAMP NULL,
    milestone_3_delivered_amount DECIMAL(16, 2) NOT NULL, -- 30%
    milestone_3_released_at TIMESTAMP NULL,
    escrow_status VARCHAR(50) NOT NULL DEFAULT 'HELD_IN_ESCROW', -- HELD_IN_ESCROW, PARTIALLY_RELEASED, FULLY_SETTLED, DISPUTE_FROZEN
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 15: admin.revenue_splits
CREATE TABLE IF NOT EXISTS admin.revenue_splits (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    cargo_booking_id UUID NOT NULL REFERENCES ops.cargo_bookings(id) ON DELETE CASCADE,
    platform_fee_amount DECIMAL(14, 2) NOT NULL, -- 10-15%
    operator_share_amount DECIMAL(14, 2) NOT NULL, -- 60-80%
    tax_and_port_dues DECIMAL(14, 2) NOT NULL,
    net_platform_profit DECIMAL(14, 2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 16: admin.invoices
CREATE TABLE IF NOT EXISTS admin.invoices (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    invoice_number VARCHAR(50) UNIQUE NOT NULL, -- INV-B2B-20261106-008
    company_id UUID NOT NULL REFERENCES public.companies(id),
    cargo_booking_id UUID NULL REFERENCES ops.cargo_bookings(id),
    total_invoice_amount DECIMAL(16, 2) NOT NULL,
    currency VARCHAR(10) NOT NULL DEFAULT 'IDR',
    exchange_rate_locked DECIMAL(14, 4) NOT NULL DEFAULT 1.0000,
    due_date DATE NOT NULL,
    payment_status VARCHAR(50) NOT NULL DEFAULT 'UNPAID', -- UNPAID, PARTIALLY_PAID, OVERDUE, PAID_SETTLED
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 17: admin.operator_invitations
CREATE TABLE IF NOT EXISTS admin.operator_invitations (
    id UUID PRIMARY KEY DEFAULT uuid_generate_v4(),
    invitation_token VARCHAR(64) UNIQUE NOT NULL,
    email VARCHAR(255) NOT NULL,
    phone VARCHAR(50) NOT NULL,
    assigned_hub_id VARCHAR(10) NOT NULL REFERENCES public.ports(id),
    assigned_role VARCHAR(50) NOT NULL DEFAULT 'OPERATOR_DOMESTIC', -- OPERATOR_DOMESTIC, OPERATOR_INTERNATIONAL
    expires_at TIMESTAMP NOT NULL, -- 24 jam
    is_claimed BOOLEAN NOT NULL DEFAULT FALSE,
    invited_by_admin_id UUID NOT NULL REFERENCES public.users(id),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 18: admin.gateway_sessions
CREATE TABLE IF NOT EXISTS admin.gateway_sessions (
    id VARCHAR(50) PRIMARY KEY, -- wa_gateway_session_01
    channel_type VARCHAR(50) NOT NULL, -- WHATSAPP_BAILEYS, EMAIL_SMTP
    connection_status VARCHAR(50) NOT NULL DEFAULT 'DISCONNECTED', -- CONNECTED, PAIRING_REQUIRED, DISCONNECTED, RATE_LIMITED
    paired_phone_number VARCHAR(50) NULL,
    remaining_quota_daily INT NOT NULL DEFAULT 5000,
    last_ping_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 19: admin.system_settings
CREATE TABLE IF NOT EXISTS admin.system_settings (
    key VARCHAR(100) PRIMARY KEY,
    value TEXT NOT NULL,
    group_name VARCHAR(50) NOT NULL, -- ai_engine, gateways, financial, system
    description TEXT NULL,
    updated_by UUID NULL REFERENCES public.users(id),
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table 20: admin.immutable_audit_trails
CREATE TABLE IF NOT EXISTS admin.immutable_audit_trails (
    id BIGSERIAL PRIMARY KEY,
    admin_user_id UUID NOT NULL REFERENCES public.users(id),
    action_type VARCHAR(100) NOT NULL, -- APPROVE_KYC, RELEASE_ESCROW_M2, TRIGGER_WEATHER_HOLD
    target_schema VARCHAR(50) NOT NULL, -- public, ops, admin
    target_table VARCHAR(100) NOT NULL,
    record_id VARCHAR(100) NOT NULL,
    before_state_json JSONB NULL,
    after_state_json JSONB NULL,
    ip_address VARCHAR(50) NOT NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Create Indexes for High-Traffic Queries
CREATE INDEX IF NOT EXISTS idx_cargo_bookings_tracking ON ops.cargo_bookings(tracking_number);
CREATE INDEX IF NOT EXISTS idx_cargo_bookings_status ON ops.cargo_bookings(cargo_status);
CREATE INDEX IF NOT EXISTS idx_manifest_items_container ON ops.manifest_items(container_serial_number);
CREATE INDEX IF NOT EXISTS idx_invoices_due ON admin.invoices(due_date, payment_status);
CREATE INDEX IF NOT EXISTS idx_audit_trails_time ON admin.immutable_audit_trails(created_at);

