<?php

namespace App\Http\Controllers;

use App\Models\BallotDetail;
use App\Models\Group;
use App\Models\Organization;
use Illuminate\Http\Request;
use Inertia\Inertia;

class VoteController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $user->load("verification");

        $organizations = Organization::query()
            ->where("is_open", true)
            ->get()
            ->sortBy(fn(Organization $organization) => $this->organizationRank($organization->name))
            ->values();

        return Inertia::render("vote/index", [
            "verification" => $user->verification,
            "organizations" => $organizations,
        ]);
    }

    private function organizationRank(string $name): int
    {
        $normalized = strtolower(trim(preg_replace('/\s+/', ' ', $name)));

        if (
            str_contains($normalized, 'blm informatika') ||
            ($normalized === 'informatika')
        ) {
            return 1;
        }

        if (
            str_contains($normalized, 'blm sistem informasi') ||
            str_contains($normalized, 'sistem informasi') ||
            str_contains($normalized, 'blm si')
        ) {
            return 2;
        }

        if (
            str_contains($normalized, 'blm sains data') ||
            str_contains($normalized, 'sains data') ||
            str_contains($normalized, 'blm sd')
        ) {
            return 3;
        }

        if (
            str_contains($normalized, 'blm bisnis digital') ||
            str_contains($normalized, 'blm bisinis digital') ||
            str_contains($normalized, 'bisnis digital') ||
            str_contains($normalized, 'bisinis digital') ||
            str_contains($normalized, 'blm bisdig') ||
            str_contains($normalized, 'bisdig')
        ) {
            return 4;
        }

        if (
            str_contains($normalized, 'bem fasilkom') ||
            (str_contains($normalized, 'bem') && str_contains($normalized, 'fasilkom'))
        ) {
            return 5;
        }

        return 999;
    }

    public function organization(Request $request, Organization $organization)
    {
        $user = $request->user();
        $ballot = $user->ballot()
            ->where("organization_id", $organization->id)
            ->first();

        if (!$ballot) {
            $user->ballot()->create([
                "organization_id" => $organization->id,
            ]);
        }

        $first = $organization->firstGroup($user->year, $user->major);

        if (!$first) {
            return redirect()->route("index")
                ->with("flash.message", "Oops! sepertinya kamu tidak bisa ikut serta pemilihan organisasi ini 😅")
                ->with("flash.type", "destructive");
        }

        return redirect()->route("vote.group", [
            "organization" => $organization->id,
            "group" => $first->id
        ]);
    }

    public function group(
        Organization $organization,
        Group $group,
        Request $request
    ) {
        $user = $request->user();
        $ballot = $user->ballot()
            ->where("organization_id", $organization->id)
            ->first();
        $ballotDetails = $ballot->details()
            ->where("group_id", $group->id)
            ->get();

        return Inertia::render("vote/group", [
            "organization" => $organization,
            "group" => $group,
            "candidates" => $group->candidates,
            "ballotDetails" => $ballotDetails,
        ]);
    }

    public function groupPrevious(
        Organization $organization,
        Group $group,
        Request $request
    ) {
        $user = $request->user();
        $previousGroup = $group->prev($user->year, $user->major);
        if ($previousGroup) {
            return redirect()->route("vote.group", [
                "organization" => $organization->id,
                "group" => $previousGroup->id,
            ]);
        }

        return redirect()->route("index");
    }

    public function storeGroup(
        Request $request,
        Organization $organization,
        Group $group
    ) {
        $group->loadCount("candidates");

        if ($group->candidates_count > 0) {
            $request->validate([
                "candidate_ids" => "required|array",
                "candidate_ids.*" => "exists:candidates,id",
            ]);
        }

        $candidateIds = $request->input("candidate_ids", []);
        if (!is_array($candidateIds)) {
            $candidateIds = [$candidateIds];
        }

        if (count($candidateIds) < $group->min_candidates && $group->candidates_count >= $group->min_candidates) {
            return redirect()
                ->back()
                ->withErrors([
                    "candidate_ids" => "Pilih minimal {$group->min_candidates} kandidat",
                ])
                ->withInput();
        }

        $user = $request->user();
        $ballot = $user->ballot()
            ->where("organization_id", $organization->id)
            ->first();

        $ballot->details()
            ->where("group_id", $group->id)
            ->delete();

        foreach ($candidateIds as $candidateId) {
            $ballot->details()->create([
                "organization_id" => $organization->id,
                "group_id" => $group->id,
                "candidate_id" => $candidateId,
            ]);
        }

        $nextGroup = $group->next($user->year, $user->major);

        if (!$nextGroup) {
            return redirect()->route("vote.result", [
                "organization" => $organization->id,
            ]);
        }

        return redirect()->route("vote.group", [
            "organization" => $organization->id,
            "group" => $nextGroup,
        ]);
    }

    public function result(Organization $organization, Request $request)
    {
        $user = $request->user();
        $ballot = $user->ballot()
            ->where("organization_id", $organization->id)
            ->first();
        $details = $ballot->details()
            ->with("group", "candidate")
            ->get();

        return Inertia::render("vote/result", [
            "organization" => $organization,
            "details" => $details
        ]);
    }

    public function confirmResult(Request $request, Organization $organization)
    {
        $user = $request->user();
        $ballot = $user->ballot()
            ->where("organization_id", $organization->id)
            ->first();

        $ballot->update([
            "is_confirmed" => 1,
            "confirmed_at" => now(),
        ]);

        return redirect()
            ->route("index")
            ->with("flash.message", "Terima kasih telah berpartisipasi! 🤩");
    }
}
