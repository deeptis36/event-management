<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TalkProposal;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function talkProposals()
    {
        return $this->belongsToMany(TalkProposal::class, 'talk_proposal_tag');
    }
}

