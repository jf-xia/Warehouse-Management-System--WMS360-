<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChannelItemTerm extends Model
{
    protected $fillable = ['channel','master_term_id','channel_term','channel_term_slug','is_active'];
}
