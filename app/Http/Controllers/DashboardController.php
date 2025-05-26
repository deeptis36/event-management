<?php

namespace App\Http\Controllers;

use App\Models\TalkProposal;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $query = TalkProposal::with('speaker', 'tags');

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('name', $request->tag);
            });
        }

        if ($request->filled('speaker')) {
            $query->whereHas('speaker', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->speaker . '%');
            });
        }

        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $talkProposals = $query->paginate(10);

        return view('reviewer.dashboard', compact('talkProposals'));
    }
}
