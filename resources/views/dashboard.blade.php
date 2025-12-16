@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container py-4">
    {{-- Add Transaction Button --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0">Dashboard</h1>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            + Add Transaction
        </a>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card dashboard-card card-income">
                <div class="card-body">
                    <h5 class="card-title">Income (This Month)</h5>
                    <p class="card-text display-6">
                        Rp {{ number_format($income, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card card-expense">
                <div class="card-body">
                    <h5 class="card-title">Expenses (This Month)</h5>
                    <p class="card-text display-6">
                        Rp {{ number_format($expenses, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card dashboard-card card-balance">
                <div class="card-body">
                    <h5 class="card-title">Balance</h5>
                    <p class="card-text display-6">
                        Rp {{ number_format($balance, 0, ',', '.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- CHART --}}
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Daily Income & Expenses</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-end mb-2">
                        <div class="btn-group btn-group-sm">
                            <button class="btn btn-outline-primary active" id="barBtn">Bar</button>
                            <button class="btn btn-outline-primary" id="lineBtn">Line</button>
                        </div>
                    </div>
                    <canvas id="transactionChart"></canvas>
                </div>
            </div>
        </div>

        {{-- RECENT TRANSACTIONS --}}
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Recent Transactions</h5>
                </div>

                <ul class="list-group list-group-flush">
                    @forelse($recentTransactions as $transaction)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <span class="fw-bold">
                                    {{ $transaction->category->name ?? 'Uncategorized' }}
                                </span>
                                <br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}
                                </small>
                            </div>

                            <span class="fw-bold {{ $transaction->type === 'income' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->type === 'income' ? '+' : '-' }}
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </span>
                        </li>
                    @empty
                        <li class="list-group-item text-center text-muted">
                            No transactions yet.
                        </li>
                    @endforelse
                </ul>

                <div class="card-footer bg-white text-center">
                    <a href="{{ route('transactions.index') }}" class="btn btn-sm btn-outline-primary">
                        View All
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CHART.JS --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = @json($dailyData);

    const labels = chartData.map(item => item.date);
    const incomeData = chartData.map(item => item.income);
    const expenseData = chartData.map(item => item.expense);

    const barBtn = document.getElementById('barBtn');
    const lineBtn = document.getElementById('lineBtn');


    const ctx = document.getElementById('transactionChart').getContext('2d');
    let chartType = 'bar';
    let chart;

    function renderChart(type) {
        if (chart) chart.destroy();

        chart = new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Income',
                        data: incomeData,
                        borderWidth: 2
                    },
                    {
                        label: 'Expenses',
                        data: expenseData,
                        borderWidth: 2
                    }
                ]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    renderChart(chartType);

    document.getElementById('barBtn').onclick = () => {
        chartType = 'bar';
        renderChart(chartType);
        barBtn.classList.add('active');
        lineBtn.classList.remove('active');
    };

    document.getElementById('lineBtn').onclick = () => {
        chartType = 'line';
        renderChart(chartType);
        lineBtn.classList.add('active');
        barBtn.classList.remove('active');
    };
</script>
@endsection