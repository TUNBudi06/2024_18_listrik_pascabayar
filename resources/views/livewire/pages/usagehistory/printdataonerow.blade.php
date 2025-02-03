<?php

use Livewire\Attributes\On;
use Livewire\Volt\Component;
use Livewire\Attributes\Computed;

new class extends Component {
    public $data = [];

    #[On("modalInvoice")]
    public function passingData($data)
    {
        $this->data = $data;
        // Debugbar::info($this->data); // Remove in production
    }

    #[Computed]
    public function invoiceHash()
    {
        $base = ($this->data['bulan'] ?? '')
            . ($this->data['tahun'] ?? '')
            . ($this->data['jumlah_meter'] ?? '');
        return strtoupper(substr(hash('sha256', $base ?: 'hash'), 0, 8));
    }

    #[Computed]
    public function tariffString()
    {
        $tariff = $this->data['pelanggan_k_w_h']['get_tarif'] ?? [];
        return ($tariff['daya'] ?? 900) . " VA/Rp. "
            . number_format($tariff['tarif_perkwh'] ?? 1320, 0, ',', '.');
    }

    private function formatCurrency($value)
    {
        return 'Rp. ' . number_format($value ?? 0, 0, ',', '.');
    }

    #[On("PrintPageAreaClass")]
    public function printPage()
    {
        $this->dispatch('PrintPageArea');
    }
};
?>

<div>
    <div class="card card-body printableArea">
        <h3 class="d-flex justify-content-between align-items-center mb-4">
            <b>INVOICE</b>
            <span class="badge bg-primary">#{{ $this->invoiceHash }}</span>
        </h3>
        <hr>

        <div class="row g-4">
            <div class="col-12">
                <div class="row g-3">
                    <!-- Customer Info -->
                    <div class="col-md-6">
                        <div class="customer-info">
                            <h4 class="text-danger fw-bold mb-3">
                                {{ $data['pelanggan_k_w_h']['nama_pelanggan'] ?? 'Default Customer' }}
                            </h4>
                            <p class="text-muted">
                                @php
                                    $address = $data['pelanggan_k_w_h']['alamat'] ?? 'Lorem ipsum dolor sit amet...';
                                    echo wordwrap($address, 36, "<br>\n", true);
                                @endphp
                            </p>
                        </div>
                    </div>

                    <!-- Invoice Dates -->
                    <div class="col-md-6 text-md-end">
                        <div class="invoice-dates">
                            <p class="mb-2">
                                <b>Invoice Date:</b>
                                <i class="fas fa-calendar-alt ms-2"></i>
                                {{ $data['pembayaran_k_w_h']['created_at'] ?? now()->format('Y-m-d') }}
                            </p>
                            <p>
                                <b>Pay Date:</b>
                                <i class="fas fa-calendar-check ms-2"></i>
                                {{ $data['pembayaran_k_w_h']['tanggal_pembayaran'] ?? now()->format('Y-m-d') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Price</th>
                            <th>Total Kwh</th>
                            <th class="text-end">Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="text-center">{{ $this->invoiceHash }}</td>
                            <td>{{ $this->tariffString }}</td>
                            <td>{{ $data['jumlah_meter'] ?? 0 }} Kwh</td>
                            <td class="text-end">
                                {{ $this->formatCurrency($data['pembayaran_k_w_h']['total_tagihan'] ?? 0) }}
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Totals -->
            <div class="col-12">
                <div class="total-section text-end">
                    <div class="d-inline-block text-start">
                        <p class="mb-1">Total
                            Amount: {{ $this->formatCurrency($data['pembayaran_k_w_h']['total_bayar'] ?? 0) }}</p>
                        <p class="mb-1">Sub
                            Total: {{ $this->formatCurrency($data['pembayaran_k_w_h']['total_tagihan'] ?? 0) }}</p>
                        <p class="mb-3">VAT
                            (10%): {{ $this->formatCurrency($data['pembayaran_k_w_h']['biaya_admin'] ?? 0) }}</p>
                        <hr>
                        <h3 class="fw-bold">
                            Total Money Return: {{ $this->formatCurrency(
                            ($data['pembayaran_k_w_h']['total_bayar'] ?? 0) -
                            (($data['pembayaran_k_w_h']['biaya_admin'] ?? 0) +
                            ($data['pembayaran_k_w_h']['total_tagihan'] ?? 0))
                        ) }}
                        </h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        $(document).ready(() => {
            $wire.on('PrintPageArea', () => {
                $('.printableArea').printArea({
                    mode: 'iframe',
                    popClose: false,
                    retainAttr: ['class', 'id', 'style'],
                    printDelay: 500
                });
            });
        });
    </script>
    @endscript

    <style>
        .printableArea {
            background: white;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }

        .customer-info h4 {
            font-size: 1.5rem;
        }

        .table th {
            font-weight: 600;
            background-color: #f8f9fa;
        }

        .total-section {
            background-color: #f8f9fa;
            padding: 1.5rem;
            border-radius: 0.5rem;
        }

        .fas {
            margin-right: 0.5rem;
        }
    </style>
</div>
