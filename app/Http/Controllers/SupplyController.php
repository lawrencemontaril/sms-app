<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupplyRequest;
use App\Http\Requests\UpdateSupplyRequest;
use App\Http\Resources\SupplyResource;
use App\Models\Supply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class SupplyController extends Controller
{
    /*
    | -------------------
    |  List of supplies.
    | -------------------
    */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Supply::class);

        $query = Supply::query();

        if ($request->filled('search')) {
            $query->search($request->input('search'));
        }

        if ($request->filled('stock_status')) {
            match ($request->input('stock_status')) {
                'all' => null,
                'no' => $query->noStock(),
                'low' => $query->lowStock(),
                'sufficient' => $query->sufficientStock(),
                default => null,
            };
        }

        $supplies = $query->paginate(10)->withQueryString();

        return Inertia::render('supplies/SupplyList', [
            'supplies' => SupplyResource::collection($supplies),
            'filters' => $request->only(['search', 'stock_status']),
        ]);
    }

    /*
    | ----------------------
    |  Search for supplies.
    | ----------------------
    */
    public function search()
    {
        Gate::authorize('viewAny', Supply::class);

        $keyword = request('q');

        $supplies = Supply::search($keyword)
            ->limit(30)
            ->get();

        return SupplyResource::collection($supplies);
    }

    /*
    | -----------------------
    |  Supply creation form.
    | -----------------------
    */
    public function create()
    {
        Gate::authorize('create', Supply::class);

        return Inertia::render('supplies/SupplyCreate');
    }

    /*
    | -----------------------------------
    |  Store the supply in the database.
    | -----------------------------------
    */
    public function store(StoreSupplyRequest $request)
    {
        $supply = Supply::create($request->validated());

        return redirect()
            ->route('supplies.index')
            ->with('success', "Supply '$supply->name' created successfully.");
    }

    /*
    | ---------------------------
    |  Show a particular supply.
    | ---------------------------
    */
    public function show(Supply $supply)
    {
        Gate::authorize('view', $supply);
    }

    /*
    | -------------------------
    |  Supply modification form.
    | -------------------------
    */
    public function edit(Supply $supply)
    {
        Gate::authorize('update', $supply);

        return Inertia::render('supplies/SupplyEdit', [
            'supply' => SupplyResource::make($supply)
        ]);
    }

    /*
    | -----------------------------
    |  Update a particular supply.
    | -----------------------------
    */
    public function update(UpdateSupplyRequest $request, Supply $supply)
    {
        $supply->update($request->validated());

        return redirect()
            ->route('supplies.index')
            ->with('success', "Supply '$supply->name' supply successfully.");
    }

    /*
    | ------------------
    |  Delete a supply.
    | ------------------
    */
    public function destroy(Supply $supply)
    {
        Gate::authorize('delete', $supply);
    }
}
