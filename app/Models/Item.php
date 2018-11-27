<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use App\Models\Risk;

class Item extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'risk_id',
        'current_price',
        'maximum_price',
        'minimum_price'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    // Relations

    public function risk()
    {
        return $this->belongsTo(Risk::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function rarity()
    {
        return $this->belongsTo(ItemRarity::class);
    }

    public function holdings()
    {
        return $this->hasMany(Holding::class);
    }

    // Methods

    public function safe()
    {
        unset($this->maximum_price);
        unset($this->minimum_price);
        unset($this->category_id);
        unset($this->rarity_id);
        unset($this->risk_id);

        if ($this->risk instanceof Risk) {
            unset($this->risk->swing);
            unset($this->risk->risk_id);
        }

        if ($this->rarity instanceof Rarity) {
            unset($this->rarity->rarity_id);
        }

        $this->scrubDates([$this, $this->risk, $this->category, $this->rarity]);
        return $this;
    }

    private function scrubDates(array $objs)
    {
        foreach ($objs as $obj) {
            unset($obj->created_at);
            unset($obj->updated_at);
        }
    }

}
