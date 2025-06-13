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
        $proposals = TalkProposal::with('speaker', 'tags')->paginate(10);

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
            'tags' => 'nullable',
        ]);

        // $speaker = auth()->user()->speaker ?? abort(403);
        $speaker = auth()->user();
        // dd($speaker);
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

            $tags = explode(',', $request->tags);
            // dd($tags);
            foreach ($tags as $tagName) {
                $tagName = trim(strtolower($tagName));
                $tag = Tag::firstOrCreate(['name' => $tagName, 'slug' => Tag::generateSlug($tagName)]);
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
        // dd($talkProposal);
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
        $talkProposal = TalkProposal::with('tags')->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'presentation_pdf' => 'nullable|file|mimes:pdf|max:10240',
            'tags' => 'nullable'
        ]);

        // Track old data for revision
        $oldData = $talkProposal->only(['title', 'description']);

        $update = [ 'title' => $validated['title'],
            'description' => $validated['description']];
        // File upload handling
        if ($request->hasFile('presentation_pdf')) {
            if ($talkProposal->presentation_pdf) {
                Storage::delete('public/' . $talkProposal->presentation_pdf);
            }
            $validated['presentation_pdf'] = $request->file('presentation_pdf')->store('presentations', 'public');
            $update['presentation_pdf'] = $validated['presentation_pdf'];
        }

        // dd($validated,$talkProposal);
        // Update model
        $talkProposal->update($update);

        // Track new data for revision
        $newData = $talkProposal->only(['title', 'description']);
        $changes = array_diff_assoc($newData, $oldData);

        // Store revision if any field changed
        if (!empty($changes)) {
            $talkProposal->revisions()->create([
                'user_id' => auth()->id(),
                'changes' => $changes,
            ]);
        }

        // Sync tags
        $tagNames = explode(',', $request->tags);

        $exisitingTags = Tag::get()->pluck('name');
            // dd($tagNames);
        if (!empty($tagNames) ) {
            $tagIds = [];

            foreach ($tagNames as $tagName) {
                $tagName = trim(strtolower($tagName));
                if (in_array($tagName, $exisitingTags)) {
                    continue;
                }
                $tag = Tag::create(['name' => $tagName, 'slug' => Tag::generateSlug($tagName)]);
                $tagIds[] = $tag->id;
            }
            $talkProposal->tags()->sync($tagIds);
        }

         // Log initial revision
        TalkProposalRevision::create([
            'talk_proposal_id' => $talkProposal->id,
            'user_id' => auth()->id(),
            'changes' => json_encode(['UPDATED' => $talkProposal->toArray()]),
        ]);

        return redirect()->route('proposals.show', $talkProposal)->with('success', 'Talk Proposal updated successfully.');
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
