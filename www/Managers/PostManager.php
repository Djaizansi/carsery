<?php

namespace carsery\Managers;

use carsery\core\DB;
use carsery\core\Builder\QueryBuilder;
use carsery\models\Post;

class PostManager extends DB
{

    public function __construct()
    {
        parent::__construct(Post::class, 'post');
    }

    public function getUserPost(int $id)
    {
        return (new QueryBuilder())
            ->select('p.*, u.*')
            ->from('ymnw_posts','p')
            ->join('ymnw_users','u')
            ->where('p.author = :iduser')
            ->setParameter('iduser',$id)
            ->getQuery()
            ->getArrayResult(Post::class)
            ;
    }
}