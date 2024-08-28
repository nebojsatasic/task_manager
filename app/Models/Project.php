<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use App\Observers\ProjectObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

#[ObservedBy([ProjectObserver::class])]
class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        /**
         * Filtering all queries by the member  of the project who must be logged in.
         */
        static::addGlobalScope('member', function(Builder $builder) {
            //$builder->where('creator_id', auth()->id());
            $builder->whereRelation('members', 'user_id', auth()->id());
        });
    }

    /**
     * Get the user who created the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Get the tasks that belongs to the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Get the users who are the members of the project.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'member');
    }
}
