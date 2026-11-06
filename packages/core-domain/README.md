# SoraCargo — Core Domain Package (`soracargo/core-domain`)

Paket pustaka Composer internal bersama yang bertindak sebagai **Single Source of Truth (SSOT)** untuk ketiga aplikasi Laravel (`apps/customer`, `apps/operator`, `apps/admin`).

---

## 1. Peran Arsitektur

Paket ini menjamin integritas data, konsistensi status bisnis, dan pencegahan duplikasi kode (*DRY - Don't Repeat Yourself*) di seluruh monorepo SoraCargo.

```text
                     apps/customer       apps/operator       apps/admin
                           │                   │                  │
                           └───────────────────┼──────────────────┘
                                               ▼
                                   packages/core-domain
                                               │
                         ┌─────────────────────┼─────────────────────┐
                         ▼                     ▼                     ▼
                  Schema 'public'         Schema 'ops'         Schema 'admin'
```

---

## 2. Struktur Multi-Schema Database PostgreSQL & Migrasi

Definisi migrasi tabel diatur ke dalam 3 namespace schema PostgreSQL yang terisolasi melalui 3 direktori terpisah:
```text
packages/core-domain/database/migrations/
├── public/   ──► Tabel Master: users, cargo_master, tracking_events, ports, tariffs, exchange_rates
├── ops/      ──► Tabel Operasional: manifests, driver_assignments, fleet_telemetry, inspections_bap, e_pod
└── admin/    ──► Tabel Governance: operator_invitations, escrow_ledgers, revenue_splits, corporate_credits
```

### A. Schema: `public` (Shared Master Data)
- **Model**: `User`, `CargoMaster`, `TrackingEvent`, `Port`, `TariffMatrix`, `ExchangeRate`.
- **Karakteristik**: Berisi entitas dasar yang dapat diakses oleh portal pelanggan publik dan dibaca oleh operator lapangan.

### B. Schema: `ops` (Operational & Fleet Data)
- **Model**: `Manifest`, `DriverAssignment`, `FleetTelemetry`, `InspectionBap`, `ElectronicPod`, `CustomsDeclaration`.
- **Karakteristik**: Berisi data dinamis operasional pelabuhan dan armada. Akses ditutup total dari pengguna internet publik.

### C. Schema: `admin` (Governance, Finance & Security)
- **Model**: `OperatorInvitation`, `EscrowLedger`, `RevenueSplit`, `CorporateCreditLimit`, `GatewaySession`, `AuditTrail`.
- **Karakteristik**: Berisi data paling rahasia platform. Akses diblokir ketat (*REVOKE ALL*) dari operator dan customer.

---

## 3. Enums Bersama (Single Source of Enums)

- `CargoStatus`: `DRAFT`, `BOOKED`, `GATE_IN_ORIGIN`, `CUSTOMS_INSPECTION`, `ON_BOARD_SAILING`, `ARRIVED_DESTINATION`, `DELIVERED`, `WEATHER_HOLD`, `CLAIM_HOLD`.
- `OperatorRole`: `OPERATOR_DOMESTIC`, `OPERATOR_INTERNATIONAL`, `OPERATOR_DUAL_ROLE`.
- `CustomsChannel`: `GREEN_CHANNEL`, `YELLOW_CHANNEL`, `RED_CHANNEL`.
- `EscalationTier`: `TIER_1_LOCAL_OPERATOR`, `TIER_2_BRANCH_LEAD`, `TIER_3_GLOBAL_SUPERADMIN`.
- `Incoterms`: `EXW`, `FOB`, `CFR`, `CIF`, `DDP`.

---

## 4. Cara Pemasangan di Aplikasi Laravel

Package ini dimuat menggunakan repositori path lokal pada masing-masing `composer.json` di `apps/*`:

```json
"repositories": [
    {
        "type": "path",
        "url": "../../packages/core-domain"
    }
],
"require": {
    "soracargo/core-domain": "@dev"
}
```
