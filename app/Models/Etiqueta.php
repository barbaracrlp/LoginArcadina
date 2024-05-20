<?php

namespace App\Models;

use App\Scopes\EtiquetaScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etiqueta extends Model
{
    use HasFactory;

    protected $table='contenido';

    const UPDATED_AT ='f_modi';

    protected $fillable= [
        'titulo',
        'contenido',
        'tipo',
        'f_modi',
        'publicado',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new EtiquetaScope);
    }

    public function tag_contents():HasMany{
        return $this->hasMany(Tag_content::class);
    }
    
      // Definir la relación con los pedidos a través de Tag_content
      public function pedidos()
      {
          return $this->hasManyThrough(Pedido::class, Tag_content::class, 'tag_id', 'id', 'id', 'content_id')
              ->where('tabla', 'pedidos');
      }

        // Definir la relación con los pedidos a través de Tag_content
        public function clientes()
        {
            return $this->hasManyThrough(Cliente::class, Tag_content::class, 'tag_id', 'id', 'id', 'content_id')
                ->where('tabla', 'clientes');
        }

        
        // Definir la relación con los pedidos a través de Tag_content
        public function albums()
        {
            return $this->hasManyThrough(Album::class, Tag_content::class, 'tag_id', 'id', 'id', 'content_id')
                ->where('tabla', 'albums');
        }

}
