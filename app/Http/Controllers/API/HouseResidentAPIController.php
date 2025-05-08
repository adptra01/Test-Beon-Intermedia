<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateHouseResidentAPIRequest;
use App\Http\Requests\API\UpdateHouseResidentAPIRequest;
use App\Models\HouseResident;
use App\Repositories\HouseResidentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class HouseResidentController
 */
class HouseResidentAPIController extends AppBaseController
{
    private HouseResidentRepository $houseResidentRepository;

    public function __construct(HouseResidentRepository $houseResidentRepo)
    {
        $this->houseResidentRepository = $houseResidentRepo;
    }

    /**
     * @OA\Get(
     *      path="/house-residents",
     *      summary="getHouseResidentList",
     *      tags={"HouseResident"},
     *      description="Get all HouseResidents",
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
     *                  @OA\Items(ref="#/components/schemas/HouseResident")
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
        $houseResidents = $this->houseResidentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($houseResidents->toArray(), 'House Residents retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/house-residents",
     *      summary="createHouseResident",
     *      tags={"HouseResident"},
     *      description="Create HouseResident",
     *
     *      @OA\RequestBody(
     *        required=true,
     *
     *        @OA\JsonContent(ref="#/components/schemas/HouseResident")
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
     *                  ref="#/components/schemas/HouseResident"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateHouseResidentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $houseResident = $this->houseResidentRepository->create($input);

        return $this->sendResponse($houseResident->toArray(), 'House Resident saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/house-residents/{id}",
     *      summary="getHouseResidentItem",
     *      tags={"HouseResident"},
     *      description="Get HouseResident",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of HouseResident",
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
     *                  ref="#/components/schemas/HouseResident"
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
        /** @var HouseResident $houseResident */
        $houseResident = $this->houseResidentRepository->find($id);

        if (empty($houseResident)) {
            return $this->sendError('House Resident not found');
        }

        return $this->sendResponse($houseResident->toArray(), 'House Resident retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/house-residents/{id}",
     *      summary="updateHouseResident",
     *      tags={"HouseResident"},
     *      description="Update HouseResident",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of HouseResident",
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
     *        @OA\JsonContent(ref="#/components/schemas/HouseResident")
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
     *                  ref="#/components/schemas/HouseResident"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateHouseResidentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var HouseResident $houseResident */
        $houseResident = $this->houseResidentRepository->find($id);

        if (empty($houseResident)) {
            return $this->sendError('House Resident not found');
        }

        $houseResident = $this->houseResidentRepository->update($input, $id);

        return $this->sendResponse($houseResident->toArray(), 'HouseResident updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/house-residents/{id}",
     *      summary="deleteHouseResident",
     *      tags={"HouseResident"},
     *      description="Delete HouseResident",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of HouseResident",
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
        /** @var HouseResident $houseResident */
        $houseResident = $this->houseResidentRepository->find($id);

        if (empty($houseResident)) {
            return $this->sendError('House Resident not found');
        }

        $houseResident->delete();

        return $this->sendSuccess('House Resident deleted successfully');
    }
}
