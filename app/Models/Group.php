<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable = [
        "organization_id",
        "year",
        "major",
        "name",
        "ordering",
        "min_candidates",
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class);
    }

    public function verified()
    {
        return $this->ballots->where("is_verified", true);
    }

    public function next($year, $major)
    {
        $groups = $this->organization->votingGroupsOrdered();
        $currentIndex = $groups->search(fn(Group $group) => $group->id === $this->id);

        if ($currentIndex === false) {
            return null;
        }

        return $groups->get($currentIndex + 1);
    }

    public function prev($year, $major)
    {
        $groups = $this->organization->votingGroupsOrdered();
        $currentIndex = $groups->search(fn(Group $group) => $group->id === $this->id);

        if ($currentIndex === false || $currentIndex === 0) {
            return null;
        }

        return $groups->get($currentIndex - 1);
    }
}
