@extends('layouts.app')

@section('content')
<div class="container my-4">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold mb-0">
            Budget Tracker
            <span class="text-muted fs-5">— {{ now()->format('F Y') }}</span>
        </h1>

        <a href="{{ route('budgets.create') }}" class="btn btn-primary">
            + Create Budget
        </a>
    </div>

    @forelse($budgets as $budget)
        <div class="card budget-card mb-3">
            <div class="card-body">

                {{-- Title + actions --}}
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="mb-0 fw-semibold">
                        {{ $budget->category->name }}
                    </h5>

                    <div class="d-flex gap-2">
                        <a href="{{ route('budgets.edit', $budget) }}"
                           class="btn btn-sm btn-outline-secondary">
                            Edit
                        </a>

                        <form action="{{ route('budgets.destroy', $budget) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this budget?');">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                Delete
                            </button>
                        </form>
                    </div>
                </div>

                {{-- Numbers --}}
                <div class="row text-sm mb-3">
                    <div class="col-md-4">
                        <div class="text-muted">Budget</div>
                        <div class="fw-semibold">
                            Rp {{ number_format($budget->amount, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted">Spent</div>
                        <div class="{{ $budget->spent > $budget->amount ? 'text-danger' : 'text-success' }} fw-semibold">
                            Rp {{ number_format($budget->spent, 0, ',', '.') }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="text-muted">Remaining</div>
                        <div class="fw-semibold">
                            Rp {{ number_format(max($budget->amount - $budget->spent, 0), 0, ',', '.') }}
                        </div>
                    </div>
                </div>

                {{-- Progress --}}
                <div class="progress budget-progress">
                    <div class="progress-bar
                        {{ $budget->progress_percentage >= 100
                            ? 'bg-danger'
                            : ($budget->progress_percentage >= 80
                                ? 'bg-warning'
                                : 'bg-success') }}"
                        style="width: {{ min($budget->progress_percentage, 100) }}%">
                        {{ number_format($budget->progress_percentage, 1) }}%
                    </div>
                </div>

                {{-- Warning --}}
                @if($budget->spent > $budget->amount)
                    <div class="alert alert-danger mt-3 mb-0 small">
                        Over budget by
                        <strong>
                            Rp {{ number_format($budget->spent - $budget->amount, 0, ',', '.') }}
                        </strong>
                    </div>
                @endif

            </div>
        </div>
    @empty
        <div class="alert alert-info">
            No budgets set for this month.
            <a href="{{ route('budgets.create') }}" class="fw-semibold">
                Create one now
            </a>.
        </div>
    @endforelse

</div>
@endsection