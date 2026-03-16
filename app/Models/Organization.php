<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Organization extends Model
{
    protected $fillable = [
        "major",
        "name",
        "logo",
        "ordering",
        "is_open",
    ];

    protected function casts()
    {
        return [
            "is_open" => "boolean",
        ];
    }

    public function firstGroup($year, $major)
    {
        return $this->votingGroupsOrdered()
            ->first();
    }

    public function votingGroupsOrdered(): Collection
    {
        return $this->groups()
            ->get()
            ->sortBy(fn(Group $group) => $this->groupVoteRank($group->name))
            ->values();
    }

    private function groupVoteRank(string $name): int
    {
        $normalized = strtolower(trim(preg_replace('/\s+/', ' ', $name)));

        if (str_contains($normalized, 'blm informatika')) {
            return 1;
        }

        if (
            str_contains($normalized, 'blm sistem informasi') ||
            str_contains($normalized, 'blm si')
        ) {
            return 2;
        }

        if (
            str_contains($normalized, 'blm sains data') ||
            str_contains($normalized, 'blm sd')
        ) {
            return 3;
        }

        if (
            str_contains($normalized, 'blm bisnis digital') ||
            str_contains($normalized, 'blm bisinis digital') ||
            str_contains($normalized, 'blm bisdig') ||
            str_contains($normalized, 'bisdig')
        ) {
            return 4;
        }

        if (
            str_contains($normalized, 'ketua') &&
            str_contains($normalized, 'bem') &&
            str_contains($normalized, 'wakil')
        ) {
            return 5;
        }

        if (str_contains($normalized, 'bem fasilkom')) {
            return 5;
        }

        return 999;
    }

    public function groups()
    {
        return $this->hasMany(Group::class)->orderBy("ordering");
    }

    public function candidates()
    {
        return $this->hasMany(Candidate::class);
    }

    public function ballots()
    {
        return $this->hasMany(Ballot::class);
    }

    public function ballotDetails()
    {
        return $this->hasMany(BallotDetail::class);
    }

    public function verifiedBallots()
    {
        return $this->ballots->where("is_verified", true);
    }
}
