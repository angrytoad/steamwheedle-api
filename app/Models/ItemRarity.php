<?php
/**
 * Created by PhpStorm.
 * User: Tom
 * Date: 26/11/2018
 * Time: 01:32
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class ItemRarity extends Model
{
    use Uuids;

    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'rarity_id',
        'name',
    ];
}
