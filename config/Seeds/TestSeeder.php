<?php
declare(strict_types=1);

use Cake\Chronos\Chronos;
use Cake\Utility\Text;
use Faker\Factory;
use Migrations\BaseSeed;

class TestSeeder extends BaseSeed
{
    /**
     * Run Method.
     *
     * Use this method to run your seed.
     *
     * @return void
     */
    public function run(): void
    {
        $faker = Factory::create();

        // Seed Users
        $users = [];
        for ($i = 1; $i <= 5; $i++) {
            $users[] = [
                'id' => $i,
                'uuid' => Text::uuid(),
                'username' => 'user' . $i,
                'email' => "user{$i}@example.com",
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'profile' => $faker->paragraph,
                'age' => rand(18, 60),
                'rating' => $faker->randomFloat(1, 0, 5),
                'is_active' => $faker->boolean,
                'balance' => $faker->randomFloat(2, 0, 1000),
                'created_at' => Chronos::now()->toDateTimeString(),
                'updated_at' => Chronos::now()->toDateTimeString(),
                'settings' => json_encode(['theme' => 'dark']),
                'avatar' => null,
            ];
        }
        $this->table('users')->insert($users)->save();

        // Seed Profiles (hasOne)
        $profiles = [];
        foreach ($users as $user) {
            $profiles[] = [
                'user_id' => $user['id'],
                'bio' => $faker->sentence,
                'website' => $faker->url,
            ];
        }
        $this->table('profiles')->insert($profiles)->save();

        // Seed Posts
        $posts = [];
        for ($i = 1; $i <= 10; $i++) {
            $posts[] = [
                'id' => $i,
                'user_id' => rand(1, 5),
                'title' => $faker->sentence,
                'body' => $faker->paragraph(3),
                'published' => $faker->boolean,
                'published_at' => $faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            ];
        }
        $this->table('posts')->insert($posts)->save();

        // Seed Comments
        $comments = [];
        for ($i = 1; $i <= 20; $i++) {
            $comments[] = [
                'post_id' => rand(1, 10),
                'user_id' => rand(1, 5),
                'content' => $faker->sentence,
                'created_at' => Chronos::now()->toDateTimeString(),
            ];
        }
        $this->table('comments')->insert($comments)->save();

        // Seed Tags
        $tags = [];
        for ($i = 1; $i <= 5; $i++) {
            $tags[] = [
                'id' => $i,
                'name' => ucfirst($faker->word),
            ];
        }
        $this->table('tags')->insert($tags)->save();

        // Seed posts_tags (many-to-many)
        $postsTags = [];
        foreach ($posts as $post) {
            $tagCount = rand(1, 3);
            $selectedTags = array_rand(array_flip(range(1, 5)), $tagCount);
            foreach ((array)$selectedTags as $tagId) {
                $postsTags[] = [
                    'post_id' => $post['id'],
                    'tag_id' => $tagId,
                ];
            }
        }
        $this->table('posts_tags')->insert($postsTags)->save();
    }
}
