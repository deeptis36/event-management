<?php



namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TalkProposal;
use Illuminate\Support\Str;
class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name','slug'];

    public function talkProposals()
    {
        return $this->belongsToMany(TalkProposal::class, 'talk_proposal_tag');
    }
     public static function generateSlug(string $name): string
    {
        // Generate a base slug using Laravel's Str::slug
        $slug = Str::slug($name); // e.g., "Web Development" -> "web-development"

        // Check for existing slugs to ensure uniqueness
        $originalSlug = $slug;
        $count = 1;

        while (self::where('slug', $slug)->exists()) {
            // Append a number if the slug already exists (e.g., "web-development-2")
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }
}

