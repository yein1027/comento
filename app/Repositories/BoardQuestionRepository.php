<?php

namespace App\Repositories;

use App\Enums\Models\BoardQuestion\Category;
use App\Models\Board\BoardQuestion;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;

class BoardQuestionRepository
{
    /**
     *
     * @return LengthAwarePaginator
     */
    public function getBoardQuestionsWithUsers(): LengthAwarePaginator
    {
        $boardQuestionsWithUsers = BoardQuestion::with(['users' => function($query) {
            $query->select('user_sn', 'cat_breed');
        }])
            ->has('users')
            ->select('subject', 'content', 'crt_dt', 'crt_user_sn')
            ->paginate(6);

        return $boardQuestionsWithUsers;
    }

    /**
     *
     * @param string $subject
     * @param string $content
     * @param Category $category
     * @param int $crt_user_sn
     * @return void
     */
    public function storeBoardQuestion(string $subject, string $content, Category $category, int $crt_user_sn): void
    {
        BoardQuestion::create([
            'subject' => $subject,
            'content' => $content,
            'category' => $category->value,
            'crt_user_sn' => $crt_user_sn,
        ]);
    }
}
