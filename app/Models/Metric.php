<?php namespace App\Models;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 09/01/19
 * Time: 14:08
 */

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $fillable = [
        'players',
        'salesInPeriod',
        'purchasesInPeriod',
        'wealth'
    ];

}