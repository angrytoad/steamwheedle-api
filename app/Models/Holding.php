<?php namespace App\Models;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/01/19
 * Time: 10:30
 */

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Holding extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $fillable = [
        'item_id',
        'name',
        'flavor',
        'zone',
        'image',
        'required_level',
        'cost',
        'rent_interval',
        'rent_upgrades_enabled',
        'discount_upgrades_enabled',
        'xp_upgrades_enabled'
    ];

}