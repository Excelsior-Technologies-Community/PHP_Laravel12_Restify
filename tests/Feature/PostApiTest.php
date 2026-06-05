public function test_posts_can_be_listed()
{
    $response = $this->getJson('/api/restify/posts');
    $response->assertStatus(200);
}