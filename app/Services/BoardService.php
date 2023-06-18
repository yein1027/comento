<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\Models\BoardQuestion\Category;
use App\Enums\Models\User\UserForm;
use App\Repositories\BoardAnswerRepository;
use App\Repositories\BoardQuestionRepository;
use App\Repositories\UserRepository;
use http\Encoding\Stream\Inflate;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class BoardService
{
    private BoardQuestionRepository $boardQuestionRepository;
    private BoardAnswerRepository $boardAnswerRepository;
    private UserRepository $userRepository;

    /**
     * @param BoardQuestionRepository $boardQuestionRepository
     * @param BoardAnswerRepository $boardAnswerRepository
     * @param UserRepository $userRepository
     */
    public function __construct(
        BoardQuestionRepository $boardQuestionRepository,
        BoardAnswerRepository $boardAnswerRepository,
        UserRepository          $userRepository
    )
    {
        $this->boardQuestionRepository = $boardQuestionRepository;
        $this->boardAnswerRepository = $boardAnswerRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * 질문 리스트 가져 오기
     * @return LengthAwarePaginator
     */
    public function getBoardQuestionsWithUsers(): LengthAwarePaginator
    {
        $boardQuestionsWithUsers = $this->boardQuestionRepository->getBoardQuestionsWithUsers();

        foreach ($boardQuestionsWithUsers as $boardQuestionsWithUser) {

            if ($boardQuestionsWithUser->crt_user_sn === $boardQuestionsWithUser['users'][0]->user_sn) {
                $boardQuestionsWithUser["cat_breed"] = $boardQuestionsWithUser['users'][0]->cat_breed;
                $boardQuestionsWithUser["content"] = Str::limit($boardQuestionsWithUser["content"], 40);
            }
        }

        $boardQuestionsWithUsers->transform(function ($i) {
            unset($i->crt_user_sn);
            unset($i['users']);
            return $i;
        });

        return $boardQuestionsWithUsers;
    }

    /**
     * 질문 등록
     * @param string $subject
     * @param string $content
     * @param Category $category
     * @param int $crt_user_sn
     * @return void
     */
    public function storeBoardQuestion(string $subject, string $content, Category $category, int $crt_user_sn): void
    {
        $this->boardQuestionRepository->storeBoardQuestion($subject, $content, $category, $crt_user_sn);
    }

    /** 답변 작성
     * @param string $content
     * @param int $board_q_sn
     * @param int $crt_user_sn
     * @return bool
     */
    public function storeBoardAnswer(string $content, int $board_q_sn, int $crt_user_sn): bool
    {

        // User가 멘토인지 멘티인지 확인
        $user = $this->userRepository->getUserByUserSn($crt_user_sn);
        if ($user->user_form->value === UserForm::MENTI->value) {
            return false;
        }

        // 답변이 3개 이상 달렸는지 확인
        $boardAnswers = $this->boardAnswerRepository->getBoardAnswersByBoardSN($board_q_sn);
        if (count($boardAnswers) >= 3) {
            return false;
        }

        $this->boardAnswerRepository->storeBoardAnswer($content, $board_q_sn, $crt_user_sn);

        return true;
    }

    /**
     * 답변 삭제
     * @param int $boardAnswerId
     * @return bool
     */
    public function destroyBoardAnswerById(int $boardAnswerId): bool
    {
        // 답변 채택 여부
        $boardAnswer = $this->boardAnswerRepository->getBoardAnswerById($boardAnswerId);
        if ($boardAnswer->choose_yn){
            return false;
        }

        $this->boardAnswerRepository->destroyBoardAnswerById($boardAnswerId);
        return true;
    }
}
