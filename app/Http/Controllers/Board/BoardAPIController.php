<?php

namespace App\Http\Controllers\Board;

use App\Enums\Models\BoardQuestion\Category;
use App\Http\Controllers\Controller;
use App\Services\BoardService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BoardAPIController extends Controller
{
    private BoardService $boardService;

    /**
     * @param BoardService $boardService
     */
    public function __construct(BoardService $boardService)
    {
        $this->boardService = $boardService;
    }

    /**
     * 질문 가져오기
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try {
            $boardQuestions = $this->boardService->getBoardQuestionsWithUsers();

            return $this->sendResponse($boardQuestions, '질문 리스트 가져오기 성공');

        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * 질문 등록
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subject' => ['required'],
            'content' => ['required'],
            'category' => ['required', 'in:' . Category::valuesImploded()],
            'crt_user_sn' => ['required'],
        ]);
        if ($validator->fails()) {
            Log::warning('BoardAPIController.store: ' . $validator->messages());

            return response()->json([
                'success' => false,
                'message' => $validator->messages()]);
        }

        $category = Category::from($request->category);

        try {
            $this->boardService->storeBoardQuestion($request->subject, $request->content, $category, $request->crt_user_sn);

            return response()->json([
                'success' => true,
                'message' => 'BoardAPIController.store 저장 성공']);

        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * 답변 작성
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeAnswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => ['required'],
            'board_q_sn' => ['required'],
            'crt_user_sn' => ['required'],
        ]);
        if ($validator->fails()) {
            Log::warning('BoardAPIController.storeAnswer: ' . $validator->messages());

            return response()->json([
                'success' => false,
                'message' => $validator->messages()]);
        }

        try {

            $stored = $this->boardService->storeBoardAnswer($request->content, $request->board_q_sn, $request->crt_user_sn);

            if ($stored === false){
                return response()->json([
                    'success' => false,
                    'message' => 'BoardAPIController.store 저장 실패']);
            }

            return response()->json([
                'success' => true,
                'message' => 'BoardAPIController.store 저장 성공']);

        } catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
            return $this->sendError($e->getMessage(), 200);
        }
    }

    /**
     * 답변 삭제
     * @param Request $request
     * @param $boardAnswerId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, $boardAnswerId)
    {
        $validator = Validator::make(compact('boardAnswerId'), [
            'boardAnswerId' => ['required'],
        ]);
        if ($validator->fails()) {
            Log::warning('BoardAPIController.destroy: ' . $validator->messages());

            return response()->json([
                'success' => false,
                'message' => $validator->messages()]);
        }

        try {
            $destoryed = $this->boardService->destroyBoardAnswerById((int) $boardAnswerId);

            if ($destoryed === false){
                return response()->json([
                    'success' => false,
                    'message' => 'BoardAPIController.destory 삭제 실패']);
            }

            return response()->json([
                'success' => true,
                'message' => 'BoardAPIController.destory 삭제 성공']);
        }    catch (\Exception $e) {
            Log::channel('api')->error($e->getMessage());
            return $this->sendError($e->getMessage(), 200);
        }
    }
}
