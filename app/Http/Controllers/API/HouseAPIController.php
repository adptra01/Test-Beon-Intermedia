<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateHouseAPIRequest;
use App\Http\Requests\API\UpdateHouseAPIRequest;
use App\Models\House;
use App\Repositories\HouseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class HouseController
 */
class HouseAPIController extends AppBaseController
{
    private HouseRepository $houseRepository;

    public function __construct(HouseRepository $houseRepo)
    {
        $this->houseRepository = $houseRepo;
    }

    /**
     * @OA\Get(
     *      path="/houses",
     *      summary="getHouseList",
     *      tags={"House"},
     *      description="Get all Houses",
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
     *                  @OA\Items(ref="#/components/schemas/House")
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
        $houses = $this->houseRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($houses->toArray(), 'Houses retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/houses",
     *      summary="createHouse",
     *      tags={"House"},
     *      description="Create House",
     *
     *      @OA\RequestBody(
     *        required=true,
     *
     *        @OA\JsonContent(ref="#/components/schemas/House")
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
     *                  ref="#/components/schemas/House"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateHouseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $house = $this->houseRepository->create($input);

        return $this->sendResponse($house->toArray(), 'House saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/houses/{id}",
     *      summary="getHouseItem",
     *      tags={"House"},
     *      description="Get House",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of House",
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
     *                  ref="#/components/schemas/House"
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
        /** @var House $house */
        $house = $this->houseRepository->find($id);

        if (empty($house)) {
            return $this->sendError('House not found');
        }

        return $this->sendResponse($house->toArray(), 'House retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/houses/{id}",
     *      summary="updateHouse",
     *      tags={"House"},
     *      description="Update House",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of House",
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
     *        @OA\JsonContent(ref="#/components/schemas/House")
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
     *                  ref="#/components/schemas/House"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateHouseAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var House $house */
        $house = $this->houseRepository->find($id);

        if (empty($house)) {
            return $this->sendError('House not found');
        }

        $house = $this->houseRepository->update($input, $id);

        return $this->sendResponse($house->toArray(), 'House updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/houses/{id}",
     *      summary="deleteHouse",
     *      tags={"House"},
     *      description="Delete House",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of House",
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
        /** @var House $house */
        $house = $this->houseRepository->find($id);

        if (empty($house)) {
            return $this->sendError('House not found');
        }

        $house->delete();

        return $this->sendSuccess('House deleted successfully');
    }
}
