<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class Test extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        // Users table
        $this->table('users')
            ->addColumn('uuid', 'uuid', ['default' => null])
            ->addColumn('username', 'string', ['limit' => 50])
            ->addColumn('email', 'string', ['limit' => 100])
            ->addColumn('password', 'string')
            ->addColumn('profile', 'text', ['default' => null, 'null' => true])
            ->addColumn('age', 'integer', ['default' => null, 'null' => true])
            ->addColumn('rating', 'float', ['default' => 0.0])
            ->addColumn('is_active', 'boolean', ['default' => true])
            ->addColumn('balance', 'decimal', ['precision' => 10, 'scale' => 2, 'default' => 0.00])
            ->addColumn('created_at', 'datetime')
            ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('settings', 'json', ['null' => true])
            ->addColumn('avatar', 'binary', ['null' => true])
            ->create();

        // Posts table
        $this->table('posts')
            ->addColumn('user_id', 'integer')
            ->addColumn('title', 'string')
            ->addColumn('body', 'text')
            ->addColumn('published', 'boolean', ['default' => false])
            ->addColumn('published_at', 'datetime', ['null' => true])
            ->addForeignKey('user_id', 'users', 'id')
            ->create();

        // Comments table (hasMany for posts, belongsTo users)
        $this->table('comments')
            ->addColumn('post_id', 'integer')
            ->addColumn('user_id', 'integer')
            ->addColumn('content', 'text')
            ->addColumn('created_at', 'datetime')
            ->addForeignKey('post_id', 'posts', 'id')
            ->addForeignKey('user_id', 'users', 'id')
            ->create();

        // Profiles table (hasOne for users)
        $this->table('profiles')
            ->addColumn('user_id', 'integer')
            ->addColumn('bio', 'text', ['null' => true])
            ->addColumn('website', 'string', ['null' => true])
            ->addForeignKey('user_id', 'users', 'id')
            ->create();

        // Tags table
        $this->table('tags')
            ->addColumn('name', 'string')
            ->create();

        // Join table for posts <-> tags (belongsToMany)
        $this->table('posts_tags')
            ->addColumn('post_id', 'integer')
            ->addColumn('tag_id', 'integer')
            ->addForeignKey('post_id', 'posts', 'id')
            ->addForeignKey('tag_id', 'tags', 'id')
            ->addIndex(['post_id', 'tag_id'], ['unique' => true])
            ->create();
    }
}
