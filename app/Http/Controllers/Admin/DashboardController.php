<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TalkProposal;
use App\Models\TalkProposalRevision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $totalTalkProposals = TalkProposal::count();
        $totalTalkProposalsPending = TalkProposal::where('status', 'pending')->count();
        $totalTalkProposalsApproved = TalkProposal::where('status', 'approved')->count();
        $totalTalkProposalsRejected = TalkProposal::where('status', 'rejected')->count();

        //revisions
        $totalRevisions = TalkProposalRevision::count();


        $data = [
            'totalTalkProposals' => $totalTalkProposals,
            'totalTalkProposalsPending' => $totalTalkProposalsPending,
            'totalTalkProposalsApproved' => $totalTalkProposalsApproved,
            'totalTalkProposalsRejected' => $totalTalkProposalsRejected,
            'totalRevisions' => $totalRevisions,
        ];

        return view('dashboards.admin', compact('data'));
    }
    public function admin()
    {
        $user = Auth::user();
        return view('dashboards.admin', compact('user'));
    }

    public function speaker()
    {
        $user = Auth::user();
        return view('dashboards.speaker', compact('user'));
    }

    public function reviewer(Request $request)
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

        return view('dashboards.reviewer', compact('talkProposals'));
    }
}

