@extends('layouts.app')

@section('title', 'Full Inventory - Admin')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1><i class="bi bi-file-earmark-spreadsheet me-2"></i>Full Inventory Report</h1>
        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>Back to Reports
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>SKU</th>
                            <th>Description</th>
                            <th class="text-end">Price</th>
                            <th class="text-end">Qty</th>
                            <th class="text-end">Value</th>
                            <th>Status</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $totalValue = 0; @endphp
                        @foreach($toys as $index => $toy)
                            @php $itemValue = $toy->price * $toy->quantity; $totalValue += $itemValue; @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td class="fw-medium">{{ $toy->name }}</td>
                                <td><code>{{ $toy->sku }}</code></td>
                                <td class="small text-muted">{{ Str::limit($toy->description, 50) }}</td>
                                <td class="text-end">${{ number_format($toy->price, 2) }}</td>
                                <td class="text-end">
                                    @if($toy->quantity <= 0)
                                        <span class="text-danger fw-bold">{{ $toy->quantity }}</span>
                                    @elseif($toy->quantity <= 10)
                                        <span class="text-warning fw-bold">{{ $toy->quantity }}</span>
                                    @else
                                        {{ $toy->quantity }}
                                    @endif
                                </td>
                                <td class="text-end">${{ number_format($itemValue, 2) }}</td>
                                <td>
                                    @php
                                        $statusClass = match($toy->status) {
                                            'in stock' => 'success',
                                            'low on stock' => 'warning',
                                            'out of stock' => 'danger',
                                            default => 'secondary'
                                        };
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $toy->status }}</span>
                                </td>
                                <td>{{ $toy->location ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="table-light">
                        <tr class="fw-bold">
                            <td colspan="5" class="text-end">Total:</td>
                            <td class="text-end">{{ number_format($toys->sum('quantity')) }}</td>
                            <td class="text-end">${{ number_format($totalValue, 2) }}</td>
                            <td colspan="2"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="text-muted small mt-3">
        <i class="bi bi-info-circle me-1"></i>
        Generated on {{ now()->format('F j, Y \a\t g:i A') }} | Total {{ $toys->count() }} items
    </div>
</div>
@endsection
