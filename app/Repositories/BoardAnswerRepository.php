<?php

namespace App\Repositories;

use App\Models\Board\BoardAnswer;
use Illuminate\Database\Eloquent\Collection;

class BoardAnswerRepository
{
    /**
     *
     * @param int $board_q_sn
     * @return Collection|null
     */
    public function getBoardAnswersByBoardSN(int $board_q_sn): ?Collection
    {
        $boardAnswers = BoardAnswer::where('board_q_sn', $board_q_sn)->get();

        return $boardAnswers;
    }

    /**
     * @param string $content
     * @param int $board_q_sn
     * @param int $crt_user_sn
     * @return void
     */
    public function storeBoardAnswer(string $content, int $board_q_sn, int $crt_user_sn):void
    {
        BoardAnswer::create([
            'content' => $content,
            'board_q_sn' => $board_q_sn,
            'crt_user_sn' => $crt_user_sn,
        ]);
    }

    /**
     * @param int $boardAnswerId
     * @return BoardAnswer
     */
    public function getBoardAnswerById(int $boardAnswerId): BoardAnswer
    {
        $boardAnswer = BoardAnswer::where('board_a_sn', $boardAnswerId)->first();

        return $boardAnswer;
    }

    /**
     * @param int $boardAnswerId
     * @return void
     */
    public function destroyBoardAnswerById(int $boardAnswerId): void
    {
        BoardAnswer::where('board_a_sn', $boardAnswerId)
            ->limit(1)
            ->delete();
    }
}
