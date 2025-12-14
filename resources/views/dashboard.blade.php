@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Dashboard</h1>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Transactions</h5>
                    <p class="card-text display-6">{{ $totalTransactions }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Total Amount</h5>
                    <p class="card-text display-6">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Transaction History (Last 7 Days)</h5>
                </div>
                <div class="card-body">
                    <canvas id="transactionChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Activity</h5>
                </div>
                <ul class="list-group list-group-flush">
                    @forelse($recentTransactions as $transaction)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold">{{ $transaction->category->name ?? 'Transaction' }}</span>
                                <br>
                                <small class="text-muted">{{ $transaction->created_at->diffForHumans() }}</small>
                            </div>
                            <span class="text-success fw-bold">
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">No transactions yet.</li>
                    @endforelse
                </ul>
                <div class="card-footer bg-white text-center">
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('transactionChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartLabels) !!},
            datasets: [{
                label: 'Amount (Rp)',
                data: {!! json_encode($chartValues) !!},
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
</script>
@endsection