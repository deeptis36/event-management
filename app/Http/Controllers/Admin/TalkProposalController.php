<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TalkProposal;
use App\Models\TalkProposalRevision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TalkProposalController extends Controller
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

}

