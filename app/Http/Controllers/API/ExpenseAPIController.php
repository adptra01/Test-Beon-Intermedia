<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateExpenseAPIRequest;
use App\Http\Requests\API\UpdateExpenseAPIRequest;
use App\Models\Expense;
use App\Repositories\ExpenseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ExpenseController
 */
class ExpenseAPIController extends AppBaseController
{
    private ExpenseRepository $expenseRepository;

    public function __construct(ExpenseRepository $expenseRepo)
    {
        $this->expenseRepository = $expenseRepo;
    }

    /**
     * @OA\Get(
     *      path="/expenses",
     *      summary="getExpenseList",
     *      tags={"Expense"},
     *      description="Get all Expenses",
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="array",
     *
     *                  @OA\Items(ref="#/components/schemas/Expense")
     *              ),
     *
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function index(Request $request): JsonResponse
    {
        $expenses = $this->expenseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($expenses->toArray(), 'Expenses retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/expenses",
     *      summary="createExpense",
     *      tags={"Expense"},
     *      description="Create Expense",
     *
     *      @OA\RequestBody(
     *        required=true,
     *
     *        @OA\JsonContent(ref="#/components/schemas/Expense")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Expense"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateExpenseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $expense = $this->expenseRepository->create($input);

        return $this->sendResponse($expense->toArray(), 'Expense saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/expenses/{id}",
     *      summary="getExpenseItem",
     *      tags={"Expense"},
     *      description="Get Expense",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Expense",
     *
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Expense"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function show($id): JsonResponse
    {
        /** @var Expense $expense */
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            return $this->sendError('Expense not found');
        }

        return $this->sendResponse($expense->toArray(), 'Expense retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/expenses/{id}",
     *      summary="updateExpense",
     *      tags={"Expense"},
     *      description="Update Expense",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Expense",
     *
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *
     *      @OA\RequestBody(
     *        required=true,
     *
     *        @OA\JsonContent(ref="#/components/schemas/Expense")
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  ref="#/components/schemas/Expense"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateExpenseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Expense $expense */
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            return $this->sendError('Expense not found');
        }

        $expense = $this->expenseRepository->update($input, $id);

        return $this->sendResponse($expense->toArray(), 'Expense updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/expenses/{id}",
     *      summary="deleteExpense",
     *      tags={"Expense"},
     *      description="Delete Expense",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Expense",
     *
     *           @OA\Schema(
     *             type="integer"
     *          ),
     *          required=true,
     *          in="path"
     *      ),
     *
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *
     *          @OA\JsonContent(
     *              type="object",
     *
     *              @OA\Property(
     *                  property="success",
     *                  type="boolean"
     *              ),
     *              @OA\Property(
     *                  property="data",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function destroy($id): JsonResponse
    {
        /** @var Expense $expense */
        $expense = $this->expenseRepository->find($id);

        if (empty($expense)) {
            return $this->sendError('Expense not found');
        }

        $expense->delete();

        return $this->sendSuccess('Expense deleted successfully');
    }
}
