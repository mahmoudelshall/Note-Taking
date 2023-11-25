<?php

namespace Tests\Feature;

use App\Models\Note;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NoteControllerTest extends TestCase
{
    use RefreshDatabase;
    protected $user;
    protected function setUp(): void
    {
        parent::setUp();

        // Create a user for testing
        $this->user = User::factory()->create();

        // Set the user as the authenticated user
        $this->actingAs($this->user, 'api');
    }

    public function test_can_get_list_of_notes_api()
    {

        $response = $this->getJson('/api/notes');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'notes' => [
                    '*' => ['id', 'title', 'content', 'user_id', 'created_at', 'updated_at'],
                ],
            ]);
    }

    public function test_can_create_note_api()
    {
        $noteData = [
            'title' => 'Test Note',
            'content' => 'This is a test note.',
        ];

        $response = $this->postJson('/api/notes', $noteData);

        $response->assertStatus(201)
            ->assertJson([
                'note' => $noteData,
            ]);

        $this->assertDatabaseHas('notes', $noteData + ['user_id' => $this->user->id]);
    }
    
    public function test_can_update_note_api()
    {
        $note =  Note::create([
            'title' => 'title',
            'content' => 'content',
            'user_id' => $this->user->id
        ]);

        $response = $this->putJson('/api/notes/'.$note->id,[
            'title' => 'Updated Title',
            'content' => 'Updated Content',
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'note' => [
                    'title' => 'Updated Title',
                    'content' => 'Updated Content',
                ],
            ]);
    }

   
    public function test_can_delete_note_api()
    {
        $note = Note::create([
            'title' => 'title',
            'content' => 'content',
            'user_id' => $this->user->id
        ]);

        $response = $this->deleteJson('/api/notes/'.$note->id);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Note deleted successfully.',
            ]);

        $this->assertDatabaseMissing('notes', ['id' => $note->id]);
    }

}
