<?php


namespace App\Repositories;


use App\User;

class TodoRepository
{
    public function forUser(User $user)
    {
        return $user->tasks()
            ->orderBy('created_at', 'asc')
            ->get();
    }

    public function categoryUser(User $user, string $category)
    {
        return $user->tasks()->where('category',$category)->orderBy('created_at', 'asc')
            ->get();
    }
}
