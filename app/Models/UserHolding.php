<?php namespace App\Models;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15/01/19
 * Time: 10:42
 */

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class UserHolding extends Model
{
    use Uuids;

    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'holding_id',
        'rent_level',
        'discount_level',
        'xp_level',
        'last_collected_rent',
        'copper_sank'
    ];

    protected $dates = [
        'last_collected_rent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function holding()
    {
        return $this->belongsTo(Holding::class);
    }
}