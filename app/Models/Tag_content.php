<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tag_content extends Model
{
    use HasFactory;

    protected $table='tags_contents';

    protected $fillable=[
        'tag_id',
        'content_id',
        'tabla',
    ];

    public function etiqueta():BelongsTo{
        return $this->belongsTo(Etiqueta::class,'tag_id');
    }
}
