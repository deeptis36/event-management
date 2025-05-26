<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\TalkProposal;
use App\Models\TalkProposalRevision;
use Illuminate\Http\Request;

class TalkProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Example list of proposals by the authenticated speaker
        $speaker = auth()->user()->speaker ?? abort(403);
        $proposals = $speaker->talkProposals()->with('tags')->latest()->get();

        return view('talk_proposals.index', compact('proposals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('talk_proposals.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'presentation_pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB max
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
        ]);

        $speaker = auth()->user()->speaker ?? abort(403);

        $talkProposal = new TalkProposal($request->only('title', 'description'));
        $talkProposal->speaker()->associate($speaker);

        if ($request->hasFile('presentation_pdf')) {
            $path = $request->file('presentation_pdf')->store('presentation_pdfs', 'public');
            $talkProposal->presentation_pdf = $path;
        }

        $talkProposal->save();

        // Attach tags
        if ($request->filled('tags')) {
            $tagIds = [];
            foreach ($request->tags as $tagName) {
                $tagName = trim(strtolower($tagName));
                $tag = Tag::firstOrCreate(['name' => $tagName]);
                $tagIds[] = $tag->id;
            }
            $talkProposal->tags()->sync($tagIds);
        }

        // Log initial revision
        TalkProposalRevision::create([
            'talk_proposal_id' => $talkProposal->id,
            'user_id' => auth()->id(),
            'changes' => json_encode(['created' => $talkProposal->toArray()]),
        ]);

        return redirect()->route('talk-proposals.show', $talkProposal)->with('success', 'Talk proposal submitted successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $talkProposal = TalkProposal::with(['tags', 'revisions', 'reviews'])->findOrFail($id);
        return view('talk_proposals.show', compact('talkProposal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $talkProposal = TalkProposal::findOrFail($id);
        return view('talk_proposals.edit', compact('talkProposal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Implement update logic with revision tracking
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proposal = TalkProposal::findOrFail($id);
        $this->authorize('delete', $proposal);
        $proposal->delete();

        return redirect()->route('talk-proposals.index')->with('success', 'Talk proposal deleted.');
    }
}
