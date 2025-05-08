<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreateResidentAPIRequest;
use App\Http\Requests\API\UpdateResidentAPIRequest;
use App\Models\Resident;
use App\Repositories\ResidentRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Class ResidentController
 */
class ResidentAPIController extends AppBaseController
{
    private ResidentRepository $residentRepository;

    public function __construct(ResidentRepository $residentRepo)
    {
        $this->residentRepository = $residentRepo;
    }

    /**
     * @OA\Get(
     *      path="/residents",
     *      summary="getResidentList",
     *      tags={"Resident"},
     *      description="Get all Residents",
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
     *                  @OA\Items(ref="#/components/schemas/Resident")
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
        $residents = $this->residentRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($residents->toArray(), 'Residents retrieved successfully');
    }

    /**
     * @OA\Post(
     *      path="/residents",
     *      summary="createResident",
     *      tags={"Resident"},
     *      description="Create Resident",
     *
     *      @OA\RequestBody(
     *        required=true,
     *
     *        @OA\JsonContent(ref="#/components/schemas/Resident")
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
     *                  ref="#/components/schemas/Resident"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function store(CreateResidentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $resident = $this->residentRepository->create($input);

        return $this->sendResponse($resident->toArray(), 'Resident saved successfully');
    }

    /**
     * @OA\Get(
     *      path="/residents/{id}",
     *      summary="getResidentItem",
     *      tags={"Resident"},
     *      description="Get Resident",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Resident",
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
     *                  ref="#/components/schemas/Resident"
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
        /** @var Resident $resident */
        $resident = $this->residentRepository->find($id);

        if (empty($resident)) {
            return $this->sendError('Resident not found');
        }

        return $this->sendResponse($resident->toArray(), 'Resident retrieved successfully');
    }

    /**
     * @OA\Put(
     *      path="/residents/{id}",
     *      summary="updateResident",
     *      tags={"Resident"},
     *      description="Update Resident",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Resident",
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
     *        @OA\JsonContent(ref="#/components/schemas/Resident")
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
     *                  ref="#/components/schemas/Resident"
     *              ),
     *              @OA\Property(
     *                  property="message",
     *                  type="string"
     *              )
     *          )
     *      )
     * )
     */
    public function update($id, UpdateResidentAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Resident $resident */
        $resident = $this->residentRepository->find($id);

        if (empty($resident)) {
            return $this->sendError('Resident not found');
        }

        $resident = $this->residentRepository->update($input, $id);

        return $this->sendResponse($resident->toArray(), 'Resident updated successfully');
    }

    /**
     * @OA\Delete(
     *      path="/residents/{id}",
     *      summary="deleteResident",
     *      tags={"Resident"},
     *      description="Delete Resident",
     *
     *      @OA\Parameter(
     *          name="id",
     *          description="id of Resident",
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
        /** @var Resident $resident */
        $resident = $this->residentRepository->find($id);

        if (empty($resident)) {
            return $this->sendError('Resident not found');
        }

        $resident->delete();

        return $this->sendSuccess('Resident deleted successfully');
    }
}
