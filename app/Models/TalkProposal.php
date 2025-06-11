<?php

namespace App\Models;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TalkProposal extends Model
{
    use HasFactory;

    protected $fillable = ['speaker_id', 'title', 'description', 'status', 'presentation_pdf'];

    /*public function speaker()
    {
        return $this->belongsTo(Speaker::class);
    }*/
    public function speaker()
    {
        return $this->belongsTo(User::class, 'speaker_id');
    }

    public function revisions()
    {
        return $this->hasMany(TalkProposalRevision::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'talk_proposal_tag');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
