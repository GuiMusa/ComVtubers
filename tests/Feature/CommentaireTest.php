<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Article;
use App\Models\Commentaire;

class CommentaireTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_delete_their_own_comment()
    {
        // Create a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create an article
        $article = Article::factory()->create();

        // Create a comment by the user
        $comment = Commentaire::factory()->create([
            'user_id' => $user->id,
            'article_id' => $article->id
        ]);

        // Assert the comment exists in the database
        $this->assertDatabaseHas('commentaires', ['id' => $comment->id]);

        // Send a delete request to the destroy endpoint
        $response = $this->delete(route('commentaires.destroy', $comment));

        // Assert the user is redirected back
        $response->assertRedirect();

        // Assert the comment is deleted from the database
        $this->assertDatabaseMissing('commentaires', ['id' => $comment->id]);
    }

    /** @test */
    public function a_user_cannot_delete_another_users_comment()
    {
        // Create two users
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();
        
        $this->actingAs($user1);

        // Create an article
        $article = Article::factory()->create();

        // Create a comment by user2
        $comment = Commentaire::factory()->create([
            'user_id' => $user2->id,
            'article_id' => $article->id
        ]);

        // Assert the comment exists in the database
        $this->assertDatabaseHas('commentaires', ['id' => $comment->id]);

        // Send a delete request to the destroy endpoint
        $response = $this->delete(route('commentaires.destroy', $comment));

        // Assert the action is forbidden
        $response->assertStatus(403);

        // Assert the comment is not deleted from the database
        $this->assertDatabaseHas('commentaires', ['id' => $comment->id]);
    }
}
