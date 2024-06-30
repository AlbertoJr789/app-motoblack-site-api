<?php

namespace App\Http\Controllers\API;

use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Models\Veiculo;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Http\Resources\ProfileResource;
use App\Models\Agente;
use App\Models\Passageiro;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

/**
 * Class ProfileAPIController
 */
class ProfileAPIController extends AppBaseController {

    public function getProfileData(){
        try { 
            return $this->sendResponse(
                ['result' => new ProfileResource(Auth::user()), 
            ],'Profile data retrieved successfully.'); 
        } catch (\Throwable $th) {
            Log::error('Error while getting profile data: '. $th->getMessage());
            return $this->sendError($th->getMessage(),422);
        }
    }

    public function updateProfileData(Request $request){
        $d = $request->all();
        try {

            DB::beginTransaction();

            $user = Auth::user(); 
            
            $user->pessoa->update([
                'nome' => $d['name']
            ]);

            (new UpdateUserProfileInformation)->update($user->user,$d);
            
            DB::commit();
            return $this->sendResponse('OK',__('Profile data updated sucessfully'));
        } catch(ValidationException $th) {
            DB::rollBack();
            return $this->sendError($th->getMessage(),422);
        } catch (\Throwable $th) {
            DB::rollBack();
            \Log::error('Erro while updating user profile data: '. $th->getMessage());
            return $this->sendError('Error while updating your profile data!');
        }
    }


}