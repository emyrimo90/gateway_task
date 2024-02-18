<?php

namespace App\Models;

use App\Traits\ModelTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use ModelTrait;

    protected $fillable = ["name", "ext", "url", "type", "width", "height", "mime",
        "fileable_type", "fileable_id", "duration", "user_id", "custom_name", 'notes'];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Get the owning fileable model.
     */

    protected static function boot(): void
    {
        parent::boot();
        static::addGlobalScope('all', static function (Builder $builder) {
            $builder->orderBy('id','Desc');
        });
        static::deleting(static function ($file) {
            if(isset($file->url) && Storage::exists($file->url)) {
                Storage::delete($file->url);
            }
        });
    }

    public function fileable(): MorphTo
    {
        return $this->morphTo();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

}
