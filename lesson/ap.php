<?php
use App\Blog\Name;
use App\Blog\User;
use App\Blog\Post;
use App\Blog\Comment;


include __DIR__ . '/vendor/autoload.php';

$faker = Faker\Factory::create('ru_RU');
$name = new Name(
    $faker->firstName('female'),
    $faker->lastName('female')
);
$user = new User(
    $faker->randomDigitNotNull(), 
    $name, 
    $faker->sentence(1)
);

$rout = $argv[1] ?? null;

switch ($rout) {
    case 'user':
        echo $user;
        break;
    case 'post':
        $post = new Post(
            $faker->randomDigitNotNull(),
            $user,
            $faker->realText(rand(50, 100))
        );
        echo $post;
        break;
    case 'comment':
        $post = new Post(
            $faker->randomDigitNotNull(),
            $user,
            $faker->realText(rand(50, 100))
        );
        $comment = new Comment(
            $faker->randomDigitNotNull(),
            $user,
            $post,
            $faker->realText(rand(50, 100))
        );
        echo $comment;
        break;
    default:
        echo 'error try user post comment parametr';
}
