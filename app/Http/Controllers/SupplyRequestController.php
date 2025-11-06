<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Gate;
use App\Models\SupplyRequest;
use Inertia\Inertia;
use App\Http\Resources\SupplyRequestResource;
use App\Http\Requests\StoreSupplyRequestRequest;
use App\Services\SupplyRequestService;
use Illuminate\Http\Request;

class SupplyRequestController extends Controller
{
    /*
    | ------------------------
    |  List of storage items.
    | ------------------------
    */
    public function index()
    {
        Gate::authorize('viewAny', SupplyRequest::class);

        if (auth()->user()->hasRole('procurement')) {
            $query = SupplyRequest::with(['user', 'department']);
        } else {
            $query = auth()->user()->supplyRequests()->with(['user', 'department']);
        }

        $supply_requests = $query->paginate(10)->withQueryString();

        return Inertia::render('supply-requests/SupplyRequestList', [
            'supply_requests' => SupplyRequestResource::collection($supply_requests)
        ]);
    }

    /*
    | -----------------------------
    |  Storage item creation form.
    | -----------------------------
    */
    public function create()
    {
        Gate::authorize('create', SupplyRequest::class);

        return Inertia::render('supply-requests/SupplyRequestCreate');
    }

    /*
    | -----------------------------------------
    |  Store the storage item in the database.
    | -----------------------------------------
    */
    public function store(StoreSupplyRequestRequest $request, SupplyRequestService $supplyRequestService)
    {
        Gate::authorize('create', SupplyRequest::class);

        $data = $request->validated();

        $supplyRequestService->store(
            $data['subject'],
            $data['message'],
            $data['supply_request_items']
        );

        return redirect()
            ->route('supply-requests.index')
            ->with('success', 'Supply request created successfully.');
    }

    /*
    | ---------------------------------
    |  Show a particular storage item.
    | ---------------------------------
    */
    public function show(SupplyRequest $supplyRequest)
    {
        Gate::authorize('view', $supplyRequest);

        $supplyRequest->load(['user', 'supplyRequestItems.supply']);

        return Inertia::render('supply-requests/SupplyRequestShow', [
            'supply_request' => new SupplyRequestResource($supplyRequest)
        ]);
    }

    /*
    | ---------------------------------
    |  Storage item modification form.
    | ---------------------------------
    */
    public function edit(SupplyRequest $supplyRequest)
    {
        Gate::authorize('update', $supplyRequest);
    }


    /*
    | -----------------------------------
    |  Update a particular storage item.
    | -----------------------------------
    */
    public function update(Request $request, SupplyRequest $supplyRequest)
    {
        Gate::authorize('update', $supplyRequest);
    }

    public function approve(SupplyRequest $supplyRequest, SupplyRequestService $supplyRequestService)
    {
        Gate::authorize('update', $supplyRequest);

        $supplyRequestService->approve($supplyRequest);

        return back()->with('success', 'Supply request approved!');
    }

    public function reject(SupplyRequest $supplyRequest, SupplyRequestService $supplyRequestService)
    {
        Gate::authorize('update', $supplyRequest);

        $supplyRequestService->reject($supplyRequest);

        return back()->with('success', 'Supply request rejected!');
    }

    /*
    | ------------------------
    |  Delete a storage item.
    | ------------------------
    |
    | NOTE: No one should be able to delete a storage item resource
    |       to preserve historical data and auditing abilities.
    |
    */
    public function destroy(SupplyRequest $supplyRequest)
    {
        Gate::authorize('delete', $supplyRequest);
    }
}
