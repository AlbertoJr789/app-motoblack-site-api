<?php

namespace App\Http\Controllers\API;

use App\Enum\AgenteStatus;
use App\Http\Requests\API\CreateAgenteAPIRequest;
use App\Http\Requests\API\UpdateAgenteAPIRequest;
use App\Models\Agente;
use App\Repositories\AgenteRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Barryvdh\Snappy\Facades\SnappyImage;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

/**
 * Class AgenteAPIController
 */
class AgenteAPIController extends AppBaseController
{
    private AgenteRepository $agenteRepository;

    public function __construct(AgenteRepository $agenteRepo)
    {
        $this->agenteRepository = $agenteRepo;
    }

    /**
     * Display a listing of the Agentes.
     * GET|HEAD /agentes
     */
    public function index(Request $request): JsonResponse
    {
        $agentes = $this->agenteRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($agentes->toArray(), 'Agentes retrieved successfully');
    }

    /**
     * Store a newly created Agente in storage.
     * POST /agentes
     */
    public function store(CreateAgenteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        $agente = $this->agenteRepository->create($input);

        return $this->sendResponse($agente->toArray(), 'Agente saved successfully');
    }

    /**
     * Display the specified Agente.
     * GET|HEAD /agentes/{id}
     */
    public function show($id): JsonResponse
    {
        /** @var Agente $agente */
        $agente = $this->agenteRepository->find($id);

        if (empty($agente)) {
            return $this->sendError('Agente not found');
        }

        return $this->sendResponse($agente->toArray(), 'Agente retrieved successfully');
    }

    /**
     * Update the specified Agente in storage.
     * PUT/PATCH /agentes/{id}
     */
    public function update($id, UpdateAgenteAPIRequest $request): JsonResponse
    {
        $input = $request->all();

        /** @var Agente $agente */
        $agente = $this->agenteRepository->find($id);

        if (empty($agente)) {
            return $this->sendError('Agente not found');
        }

        $agente = $this->agenteRepository->update($input, $id);

        return $this->sendResponse($agente->toArray(), 'Agente updated successfully');
    }

    /**
     * Remove the specified Agente from storage.
     * DELETE /agentes/{id}
     *
     * @throws \Exception
     */
    public function destroy($id): JsonResponse
    {
        /** @var Agente $agente */
        $agente = $this->agenteRepository->find($id);

        if (empty($agente)) {
            return $this->sendError('Agente not found');
        }

        $agente->delete();

        return $this->sendSuccess('Agente deleted successfully');
    }

    public function getOnline(): JsonResponse
    {

        try {
            $agente = Auth::user();

            if($agente instanceof Agente){
                if($agente->uuid && self::isRegistered($agente)){
                    return $this->sendSuccess($agente->uuid);
                }
                $uuid = Http::post(config('app.firebase_url').'/availableAgents/.json',[
                    'id' => $agente->id,
                    'latitude' => 0,
                    'longitude' => 0,
                    'type' => $agente->tipo->value,
                ])->throw()->json()['name'];
                
                $agente->update([
                    'uuid' => $uuid,
                    'status' => AgenteStatus::Available->value
                ]);
            }else{
                throw new Exception(__('Invalid user'));
            }
        } catch (\Throwable $th) {
            return $this->sendError(__('Error while getting online: '. $th->getMessage()));
        }

        return $this->sendSuccess($agente->uuid);
    }

    public function getOffline(): JsonResponse
    {
        try {
            $agente = Auth::user();
            if($agente instanceof Agente){
                if(!$agente->uuid){
                    return $this->sendSuccess(__('Agent offline'));
                }
                Http::delete(config('app.firebase_url')."/availableAgents/$agente->uuid/.json")->throw();
                $agente->update(['uuid' => null,'status' => AgenteStatus::Unavailable->value]);
            }else{
                throw new Exception(__('Invalid user'));
            }
        } catch (\Throwable $th) {
            return $this->sendError(__('Error while getting offline: '. $th->getMessage()));
        }

        return $this->sendSuccess(__('Agent offline'));
    }


    public static function isRegistered(Agente $agente): bool
    {
        $response = Http::get(config('app.firebase_url')."/availableAgents/$agente->uuid/.json")->throw()->json();
        return $response !== null;
    }

}
