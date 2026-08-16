@extends('layouts.app')
@section('title', 'Points - Di Hiền Building Materials')

@section('content')
<div class="container py-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('account.index') }}">Account</a></li>
            <li class="breadcrumb-item active">Points</li>
        </ol>
    </nav>

    <h2 class="fw-bold mb-4" style="color: var(--dark);"><i class="bi bi-star me-2"></i>Loyalty Points</h2>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="list-group">
                <a href="{{ route('account.index') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-person me-2"></i>Account
                </a>
                <a href="{{ route('account.orders') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-receipt me-2"></i>Orders
                </a>
                <a href="{{ route('account.addresses') }}" class="list-group-item list-group-item-action">
                    <i class="bi bi-geo-alt me-2"></i>Addresses
                </a>
                <a href="{{ route('account.points') }}" class="list-group-item list-group-item-action active">
                    <i class="bi bi-star me-2"></i>Points
                </a>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="points-display mb-4">
                <i class="bi bi-star-fill display-1 mb-3" style="opacity:0.3;"></i>
                <div class="points-number">{{ number_format($user->points ?? 0) }}</div>
                <p class="mb-0 mt-2 opacity-75">Available Points</p>
            </div>

            <div class="card mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Membership Level</h5>
                    @php
                        $totalSpent = $user->total_spent ?? 0;
                        $level = 'Bronze';
                        $nextLevel = 'Silver';
                        $progress = 0;
                        $thresholds = [
                            'Bronze' => 0,
                            'Silver' => 5000000,
                            'Gold' => 20000000,
                            'Platinum' => 50000000,
                        ];

                        if ($totalSpent >= 50000000) {
                            $level = 'Platinum';
                            $progress = 100;
                            $nextLevel = null;
                        } elseif ($totalSpent >= 20000000) {
                            $level = 'Gold';
                            $nextLevel = 'Platinum';
                            $progress = (($totalSpent - 20000000) / (50000000 - 20000000)) * 100;
                        } elseif ($totalSpent >= 5000000) {
                            $level = 'Silver';
                            $nextLevel = 'Gold';
                            $progress = (($totalSpent - 5000000) / (20000000 - 5000000)) * 100;
                        } else {
                            $level = 'Bronze';
                            $nextLevel = 'Silver';
                            $progress = ($totalSpent / 5000000) * 100;
                        }
                    @endphp

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <span class="badge bg-warning text-dark fs-6 px-3 py-2">
                                <i class="bi bi-award me-1"></i>{{ $level }}
                            </span>
                        </div>
                        @if($nextLevel)
                        <div class="text-end">
                            <small class="text-muted">Spend {{ number_format($thresholds[$nextLevel] - $totalSpent) }}đ more to reach {{ $nextLevel }}</small>
                        </div>
                        @endif
                    </div>

                    <div class="progress" style="height: 10px; border-radius: 5px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: {{ min($progress, 100) }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">Points Rules</h5>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Membership Level</th>
                                    <th>Total Spending</th>
                                    <th>Points Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><span class="badge bg-secondary">Bronze</span></td>
                                    <td>From 0đ</td>
                                    <td>0.1%</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-info">Silver</span></td>
                                    <td>From 5,000,000đ</td>
                                    <td>0.2%</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-warning text-dark">Gold</span></td>
                                    <td>From 20,000,000đ</td>
                                    <td>0.5%</td>
                                </tr>
                                <tr>
                                    <td><span class="badge bg-primary">Platinum</span></td>
                                    <td>From 50,000,000đ</td>
                                    <td>1%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <p class="text-muted mt-3 mb-0 small"><i class="bi bi-info-circle me-1"></i>1 point = 1,000đ when used for payment</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
