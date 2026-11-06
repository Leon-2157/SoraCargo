<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OperatorManagement\OperatorInvitationController;
use App\Http\Controllers\Operations\IncidentEscalationController;
use App\Http\Controllers\Operations\CargoBookingController;
use App\Http\Controllers\Operations\FleetTrackingController;
use App\Http\Controllers\Customers\CorporateCustomerController;
use App\Http\Controllers\Customers\RetailCustomerController;
use App\Http\Controllers\Finance\EscrowController;
use App\Http\Controllers\Finance\InvoiceController;
use App\Http\Controllers\Finance\FinancialReportController;
use App\Http\Controllers\Logistics\TariffRouteController;
use App\Http\Controllers\Logistics\PortTransitController;
use App\Http\Controllers\Logistics\HsCodeController;
use App\Http\Controllers\System\AuditTrailController;
use App\Http\Controllers\System\StaffManagementController;
use App\Http\Controllers\System\GatewayController;
use App\Http\Controllers\System\AiServiceController;

// 1. DASBOR
Route::get('/', [DashboardController::class, 'index'])
    ->name('admin.dashboard');

Route::get('/admin', [DashboardController::class, 'index']);

Route::post('/admin/routes/weather-hold', [DashboardController::class, 'applyWeatherHold'])
    ->name('admin.routes.weather_hold');

// 2. OPERASIONAL
Route::get('/admin/bookings', [CargoBookingController::class, 'index'])
    ->name('admin.bookings.index');

Route::post('/admin/bookings', [CargoBookingController::class, 'store'])
    ->name('admin.bookings.store');

Route::post('/admin/bookings/{id}/status', [CargoBookingController::class, 'updateStatus'])
    ->name('admin.bookings.status');

Route::get('/admin/bookings/{id}/tracking', [CargoBookingController::class, 'getTracking'])
    ->name('admin.bookings.tracking.get');

Route::post('/admin/bookings/{id}/tracking', [CargoBookingController::class, 'storeTracking'])
    ->name('admin.bookings.tracking.store');

Route::get('/admin/fleets', [FleetTrackingController::class, 'index'])
    ->name('admin.fleets.index');

Route::post('/admin/fleets', [FleetTrackingController::class, 'store'])
    ->name('admin.fleets.store');

Route::post('/admin/fleets/{id}/status', [FleetTrackingController::class, 'updateStatus'])
    ->name('admin.fleets.status');

Route::post('/admin/fleets/{id}/attach', [FleetTrackingController::class, 'attachContainer'])
    ->name('admin.fleets.attach');

Route::get('/admin/fleets/{id}/containers', [FleetTrackingController::class, 'getContainers'])
    ->name('admin.fleets.containers.get');

Route::get('/admin/operators', [OperatorInvitationController::class, 'index'])
    ->name('admin.operators.index');

Route::post('/admin/operators/invite', [OperatorInvitationController::class, 'invite'])
    ->name('admin.operators.invite');

Route::post('/admin/operators/{id}/resend', [OperatorInvitationController::class, 'resendInvite'])
    ->name('admin.operators.resend');

Route::post('/admin/operators/{id}/toggle', [OperatorInvitationController::class, 'toggleStatus'])
    ->name('admin.operators.toggle');

Route::post('/admin/operators/{id}/duty', [OperatorInvitationController::class, 'toggleDuty'])
    ->name('admin.operators.duty');

Route::get('/admin/escalations', [IncidentEscalationController::class, 'index'])
    ->name('admin.escalations.index');

Route::post('/admin/escalations/{id}/approve', [IncidentEscalationController::class, 'approve'])
    ->name('admin.escalations.approve');

Route::post('/admin/escalations/{id}/reject', [IncidentEscalationController::class, 'reject'])
    ->name('admin.escalations.reject');

Route::post('/admin/escalations/{id}/insurance', [IncidentEscalationController::class, 'escalateInsurance'])
    ->name('admin.escalations.insurance');

Route::post('/admin/escalations/weather-hold', [IncidentEscalationController::class, 'toggleWeatherHold'])
    ->name('admin.escalations.weather_hold');

// 3. PELANGGAN
Route::get('/admin/customers/retail', [RetailCustomerController::class, 'index'])
    ->name('admin.customers.retail.index');

Route::get('/admin/customers/retail/export', [RetailCustomerController::class, 'export'])
    ->name('admin.customers.retail.export');

Route::get('/admin/customers/retail/{id}', [RetailCustomerController::class, 'show'])
    ->name('admin.customers.retail.show');

Route::post('/admin/customers/retail/{id}/verify-aml', [RetailCustomerController::class, 'verifyAml'])
    ->name('admin.customers.retail.verify_aml');

Route::post('/admin/customers/retail/{id}/status', [RetailCustomerController::class, 'updateStatus'])
    ->name('admin.customers.retail.status');

Route::get('/admin/customers/corporate', [CorporateCustomerController::class, 'index'])
    ->name('admin.customers.corporate');

Route::get('/admin/customers/corporate/export', [CorporateCustomerController::class, 'export'])
    ->name('admin.customers.corporate.export');

Route::get('/admin/customers/corporate/{id}', [CorporateCustomerController::class, 'show'])
    ->name('admin.customers.corporate.show');

Route::post('/admin/customers/corporate/{id}/verify-legality', [CorporateCustomerController::class, 'verifyLegality'])
    ->name('admin.customers.corporate.verify_legality');

Route::post('/admin/customers/corporate/{id}/approve-credit', [CorporateCustomerController::class, 'approveCredit'])
    ->name('admin.customers.corporate.approve_credit');

Route::post('/admin/customers/corporate/{id}/lock', [CorporateCustomerController::class, 'toggleLockBooking'])
    ->name('admin.customers.corporate.lock');

Route::post('/admin/customers/corporate/{id}/send-warning', [CorporateCustomerController::class, 'sendWarning'])
    ->name('admin.customers.corporate.send_warning');

// 4. KEUANGAN
Route::get('/admin/finance/escrow', [EscrowController::class, 'index'])
    ->name('admin.finance.escrow');

Route::post('/admin/finance/escrow/{id}/release', [EscrowController::class, 'forceRelease'])
    ->name('admin.finance.escrow.release');

Route::post('/admin/finance/escrow/{id}/freeze', [EscrowController::class, 'toggleFreeze'])
    ->name('admin.finance.escrow.freeze');

Route::post('/admin/finance/escrow/{id}/resolve', [EscrowController::class, 'resolveDispute'])
    ->name('admin.finance.escrow.resolve');

Route::get('/admin/finance/invoices', [InvoiceController::class, 'index'])
    ->name('admin.finance.invoices');

Route::post('/admin/finance/invoices/{id}/reconcile', [InvoiceController::class, 'reconcile'])
    ->name('admin.finance.invoices.reconcile');

Route::post('/admin/finance/invoices/{id}/remind', [InvoiceController::class, 'sendReminder'])
    ->name('admin.finance.invoices.remind');

Route::post('/admin/finance/invoices/{id}/lock', [InvoiceController::class, 'toggleBookingLock'])
    ->name('admin.finance.invoices.lock');

Route::get('/admin/finance/reports', [FinancialReportController::class, 'index'])
    ->name('admin.finance.reports');

Route::get('/admin/finance/reports/export', [FinancialReportController::class, 'export'])
    ->name('admin.finance.reports.export');

// 5. LOGISTIK & MASTER DATA
Route::get('/admin/logistics/tariffs', [TariffRouteController::class, 'index'])
    ->name('admin.logistics.tariffs');

Route::post('/admin/logistics/tariffs', [TariffRouteController::class, 'store'])
    ->name('admin.logistics.tariffs.store');

Route::post('/admin/logistics/tariffs/{id}', [TariffRouteController::class, 'update'])
    ->name('admin.logistics.tariffs.update');

Route::post('/admin/logistics/tariffs/{id}/weather-hold', [TariffRouteController::class, 'toggleWeatherHold'])
    ->name('admin.logistics.tariffs.weather_hold');

Route::get('/admin/logistics/ports', [PortTransitController::class, 'index'])
    ->name('admin.logistics.ports');

Route::post('/admin/logistics/ports', [PortTransitController::class, 'store'])
    ->name('admin.logistics.ports.store');

Route::post('/admin/logistics/ports/{id}', [PortTransitController::class, 'update'])
    ->name('admin.logistics.ports.update');

Route::get('/admin/logistics/hscode', [HsCodeController::class, 'index'])
    ->name('admin.logistics.hscode');

Route::post('/admin/logistics/hscode', [HsCodeController::class, 'store'])
    ->name('admin.logistics.hscode.store');

Route::post('/admin/logistics/hscode/{code}', [HsCodeController::class, 'update'])
    ->name('admin.logistics.hscode.update');

// 6. SISTEM & INFRASTRUKTUR
Route::get('/admin/staff', [StaffManagementController::class, 'index'])
    ->name('admin.staff');

Route::post('/admin/staff', [StaffManagementController::class, 'store'])
    ->name('admin.staff.store');

Route::post('/admin/staff/{id}/toggle', [StaffManagementController::class, 'toggleStatus'])
    ->name('admin.staff.toggle');

Route::get('/admin/gateways', [GatewayController::class, 'index'])
    ->name('admin.gateways');

Route::post('/admin/gateways/wa/reconnect', [GatewayController::class, 'reconnectWa'])
    ->name('admin.gateways.wa.reconnect');

Route::post('/admin/gateways/smtp/update', [GatewayController::class, 'updateSmtp'])
    ->name('admin.gateways.smtp.update');

Route::get('/admin/ai-service', [AiServiceController::class, 'index'])
    ->name('admin.ai-service');

Route::post('/admin/ai-service/update', [AiServiceController::class, 'update'])
    ->name('admin.ai-service.update');

Route::post('/admin/ai-service/simulate', [AiServiceController::class, 'simulate'])
    ->name('admin.ai-service.simulate');

Route::post('/admin/ai-service/test-connection', [AiServiceController::class, 'testConnection'])
    ->name('admin.ai-service.test');

Route::post('/admin/ai-service/models', [AiServiceController::class, 'storeModel'])
    ->name('admin.ai-service.models.store');

Route::post('/admin/ai-service/models/delete', [AiServiceController::class, 'deleteModel'])
    ->name('admin.ai-service.models.delete');

Route::post('/admin/ai-copilot/chat', [AiServiceController::class, 'chat'])
    ->name('admin.ai-copilot.chat');

Route::get('/admin/audit', [AuditTrailController::class, 'index'])
    ->name('admin.audit');

Route::get('/admin/audit/{id}', [AuditTrailController::class, 'show'])
    ->name('admin.audit.show');
