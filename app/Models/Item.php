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

    // Methods

    public function safe()
    {
        unset($this->maximum_price);
        unset($this->minimum_price);
        if ($this->risk instanceof Risk) {
            unset($this->risk->swing);
            unset($this->risk->risk_id);
        }
        $this->scrubDates([$this, $this->risk, $this->category, $this->rarity]);
        return $this;
    }

    public function addRelatedModels()
    {
        $this->risk = $this->risk;
        unset($this->risk_id);
        $this->rarity = $this->rarity;
        unset($this->rarity_id);
        $this->category = $this->category;
        unset($this->category_id);
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
