<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CommonFunction;

class Channel extends Model
{
    use SoftDeletes;
    use CommonFunction;
    protected $fillable = ['channel','channel_term_slug','logo','is_active'];
    protected $dates = ['deleted_at'];

    public function getLogoAttribute() {
        if($this->attributes['logo'] != null){
            return $this->projectUrl().$this->attributes['logo'];
        }
        return $this->attributes['logo'];
    }
}
