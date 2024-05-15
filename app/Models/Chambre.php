<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Ramsey\Uuid\Uuid;

class Chambre extends Model
{
    use HasFactory;    
    use HasUuids;


    

    public $incrementing = false;
    
    /**
     * Generate a new UUID for the model.
     */
    public function newUniqueId(): string
    {
        return (string) Uuid::uuid4();
    }
    
    /**
     * Get the columns that should receive a unique identifier.
     *
     * @return array<int, string>
     */
    public function uniqueIds(): array
    {
        return ['id'];
    }

    
    public function place(): MorphOne
    {
        return $this->morphOne(Place::class, 'placeable');
    }

    
    public function chambreable(): MorphTo
    {
        return $this->morphTo();
    }
    
    
    public function papers(): MorphOne
    {
        return $this->morphOne(LegalPaper::class, 'paperable');
    }
    
    public function interior(): MorphOne
    {
        return $this->morphOne(Interior::class, 'interiors');
    }
    
    public function exterior(): MorphOne
    {
        return $this->morphOne(Exterior::class, 'exteriorsable');
    }
    
    public function comodities(): MorphOne
    {
        return $this->morphOne(Comodities::class, 'comoditiesable');
    }
}
