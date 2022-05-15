<?php

namespace Tests\Feature;

use App\Models\Article;
use Carbon\Factory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testArticleCreatedSuccessfully(){

        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $articleData = [
            "title" => "title test",
            'content' => 'content test',
            'image' => 'imageTest',
            'user_id' => '1',
            'category_id' => '1',
        ];

        $this->json('POST', 'api/v1/article', ['Accept' => 'application/json'])
        ->assertStatus(201)
        ->assertJson([
            "article" => [
                "title" => "title test",
                'content' => 'content test',
                'image' => 'imageTest',
                'user_id' => '1',
                'category_id' => '1',
            ],
            "message" => "success"
        ]);

    }

    public function testArticleListedSuccessfully(){
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        factory(Article::class)->create([
            "title" => "title test 2",
            'content' => 'content test 2',
            'image' => 'imageTest 2',
            'user_id' => '1',
            'category_id' => '1',
        ]);

        factory(Article::class)->create([
            "title" => "title test 3",
            'content' => 'content test 3',
            'image' => 'imageTest 3',
            'user_id' => '1',
            'category_id' => '1',
        ]);

        $this->json('GET', 'api/v1/article', ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJson([
            "articles" => [
                [
                    "title" => "title test 2",
                    'content' => 'content test 2',
                    'image' => 'imageTest 2',
                    'user_id' => '1',
                    'category_id' => '1',
                ],
                [
                    "title" => "title test 3",
                    'content' => 'content test 3',
                    'image' => 'imageTest 3',
                    'user_id' => '1',
                    'category_id' => '1',
                ]
                ],
                "message" => "Retrieved Succesfully"
        ]);
    }

    public function testRetrievedArticleSuccessfully(){
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $article = factory(Article::class)->create([
            "title" => "title test 4",
            'content' => 'content test 4',
            'image' => 'imageTest 4',
            'user_id' => '1',
            'category_id' => '1',
        ]);

        $this->json('GET', 'api/v1/article/'. $article->id, [],['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJson([
            "article" => [
            "title" => "title test 3",
            'content' => 'content test 3',
            'image' => 'imageTest 3',
            'user_id' => '1',
            'category_id' => '1',
            ],"message" => "Retrived successfully"
        ]);
    }

    public function testArticleUpdatedSuccessfully(){
        $user = factory((User::class))->create();
        $this->actingAs($user, 'api');

        $article = factory(Article::class)->create([
            "title" => "title test 5",
            'content' => 'content test 5',
            'image' => 'imageTest 5',
            'user_id' => '1',
            'category_id' => '1',
        ]);

        $payload =[
            "title" => "title test 5 update",
            'content' => 'content test 5 update',
            'image' => 'imageTest 5',
            'user_id' => '1',
            'category_id' => '1',
        ];

        $this->json('PATCH', 'api/v1/articles/'. $article->id, $payload, ['Accept' => 'application/json'])
        ->assertStatus(200)
        ->assertJson([
            "article" => [
                "title" => "title test 5 update",
                'content' => 'content test 5 update',
                'image' => 'imageTest 5',
                'user_id' => '1',
                'category_id' => '1',
            ]
        ]);
    }

    public function testDeleteArticle()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user, 'api');

        $article = factory(Article::class)->create([
            "title" => "title test 5 update",
            'content' => 'content test 5 update',
            'image' => 'imageTest 5',
            'user_id' => '1',
            'category_id' => '1',
        ]);

        $this->json('DELETE', 'api/v1/article/' . $article->id, [], ['Accept' => 'application/json'])
            ->assertStatus(204);
    }
}
