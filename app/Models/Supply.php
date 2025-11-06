<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use App\Observers\SupplyObserver;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;

#[ObservedBy([SupplyObserver::class])]
class Supply extends Model
{
    /*
    | ------------
    |  Properties
    | ------------
    */
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
        'reorder_level',
    ];

    /*
    | ------------
    |  Properties
    | ------------
    */
    public function requisitionItems(): HasMany
    {
        return $this->hasMany(RequisitionItem::class);
    }

    public function purhcaseOrderItems(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /*
    | --------
    |  Scopes
    | --------
    */
    #[Scope]
    protected function search(Builder $query, string $keyword = '')
    {
        $query->where('name', 'like', '%' . $keyword . '%');
    }

    #[Scope]
    protected function noStock(Builder $query)
    {
        $query->where('quantity', 0);
    }

    #[Scope]
    protected function lowStock(Builder $query)
    {
        $query->whereColumn('quantity', '<=', 'reorder_level');
    }

    #[Scope]
    protected function sufficientStock(Builder $query)
    {
        $query->whereColumn('quantity', '>', 'reorder_level');
    }

    /*
    | -----------
    |  Accessors
    | -----------
    */
    protected function totalCost(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity * $this->price
        );
    }

    protected function isLowStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity <= $this->reorder_level && !$this->is_no_stock
        );
    }

    protected function isNoStock(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->quantity === 0
        );
    }
}
