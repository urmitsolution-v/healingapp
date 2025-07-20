@extends('layout.admin')

@section('content')
<div class="app-container">
    <div class="app-hero-header d-flex align-items-center">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <i class="ri-home-8-line lh-1 pe-3 me-3 border-end"></i>
                <a href="/dashboard">Home</a>
            </li>
            <li class="breadcrumb-item text-primary" aria-current="page">View Bids</li>
        </ol>
    </div>

    <div class="app-body">
        <div class="row gx-3">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="card-title mb-0">Healing Request Bids</h5>
                    </div>

                    <div class="card-body">
                        <p><strong>Request Time:</strong> {{ \Carbon\Carbon::parse($healingRequest->date . ' ' . $healingRequest->time)->format('D, M j Y \a\t g:i A') }}</p>
                        <p><strong>Requirement:</strong> {{ $healingRequest->healing_requirement ?? 'N/A' }}</p>

                        @if($healingRequest->bids->count())
                            @php
                                // Move assigned healer bid to top
                                $bids = $healingRequest->bids->sortBy(function ($bid) use ($healingRequest) {
                                    return $bid->healer_id == $healingRequest->assigned_healer_id ? 0 : 1;
                                });
                            @endphp

                            

                            <div class="row">
                                @foreach($bids as $bid)
                                    <div class="col-md-4">
                                        <div class="card shadow-sm border {{ $bid->healer_id == $healingRequest->assigned_healer_id ? 'border-success' : 'border-light opacity-75' }} mb-4">
                                            <div class="card-body d-flex flex-column gap-2">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div>
                                                        <h5 class="mb-1 text-primary">
                                                            <i class="ri-user-heart-line me-1"></i> {{ $bid->healer->name ?? 'Unknown Healer' }}
                                                        </h5>
                                                        <p class="mb-0">
                                                            <i class="ri-phone-line me-1"></i> {{ $bid->healer->phone ?? 'N/A' }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        @if($bid->healer_id == $healingRequest->assigned_healer_id)
                                                            <span class="badge bg-success">Active</span>
                                                        @else
                                                            <span class="badge bg-danger">Not Assigned</span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="row text-center">
                                                    <div class="col">
                                                        <div class="border rounded p-2">
                                                            <div class="fw-semibold text-muted small">Credit</div>
                                                            <div class="fs-5 text-success">1500</div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="border rounded p-2">
                                                            <div class="fw-semibold text-muted small">Debit</div>
                                                            <div class="fs-5 text-danger">500</div>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="border rounded p-2">
                                                            <div class="fw-semibold text-muted small">Balance</div>
                                                            <div class="fs-5 text-primary">1000</div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <hr>

                                                <p class="mb-1"><strong>Remarks:</strong> {{ $bid->remarks ?? 'No remarks' }}</p>
                                                <p class="mb-0"><strong>Bid Time:</strong> {{ $bid->created_at->format('d M Y, h:i A') }}</p>

                                                {{-- Assign Button --}}
                                                @if($healingRequest->assigned_healer_id == $bid->healer_id)
                                                    <div class="alert alert-success text-center mt-3 mb-0 p-2">
                                                        <i class="ri-check-line me-1"></i> Already Assigned
                                                    </div>
                                                @elseif($healingRequest->assigned_healer_id)
                                                    <button class="btn btn-secondary w-100 mt-3" disabled>
                                                        <i class="ri-check-double-line me-1"></i> Healer Already Assigned
                                                    </button>
                                                @else

                                                @if($healingRequest->status !== "cancelled")

                                                    <form action="{{ route('assign.healer') }}" method="POST" class="mt-3">
                                                        @csrf
                                                        <input type="hidden" name="healing_request_id" value="{{ $healingRequest->id }}">
                                                        <input type="hidden" name="bid_id" value="{{ $bid->id }}">
                                                        <button type="submit" class="btn btn-primary w-100">
                                                            <i class="ri-check-double-line me-1"></i> Assign This Healer
                                                        </button>
                                                    </form>

                                                    @else

                                                    <p class="alert alert-danger">Cancelled Already This Request</p>

                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-inbox fa-2x mb-2"></i><br>
                                <strong>No bids found for this request.</strong>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
