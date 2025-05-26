<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\TalkProposal;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, TalkProposal $talkProposal)
    {
        $request->validate([
            'comments' => 'nullable|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Review::updateOrCreate(
            ['reviewer_id' => auth()->id(), 'talk_proposal_id' => $talkProposal->id],
            $request->only('comments', 'rating')
        );

        // Update status if needed, e.g. mark proposal as reviewed or approved based on rating
        if ($review->rating >= 4) {
            $talkProposal->status = 'approved';
        } else {
            $talkProposal->status = 'rejected';
        }
        $talkProposal->save();

        // Notify speaker by email (using Notification system)
        $talkProposal->speaker->user->notify(new ProposalReviewedNotification($talkProposal, $review));

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
}
