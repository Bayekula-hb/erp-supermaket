<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Establishment;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    
    public function auth(Request $request)
    {
        try {
            $userFind = User::where('userName', $request->userName)->first();
            
            if($userFind){
                if (Hash::check($request->password, $userFind->password)) {

                    $userRoles = UserRole::where('user_id', $userFind->id)->get();
            
                    $userRoleTab = [];
                    foreach($userRoles as $role){
                        $userRole = Role::where('id', $role->role_id)->first();
                        if($userRole){
                            $userRoleObject = (object) [
                                'nameRole' => $userRole->nameRole,
                                'id' => $userRole->id,
                            ];
                            array_push($userRoleTab, $userRoleObject );
                        }
                    }
                    $token = $userFind->createToken($userFind->id);

                    return response()->json([
                        'error'=>false,
                        'message'=> 'User is logging successful', 
                        'data'=>[
                           'lastName' => $userFind->lastName,
                           'middleName' => $userFind->middleName,
                           'firstName' => $userFind->firstName,
                           'gender' => $userFind->gender,
                           'email' => $userFind->email,
                           'phoneNumber' => $userFind->phoneNumber,
                           'id' => $userFind->id,
                           'token' => $token->plainTextToken,
                           'userRoles' => $userRoleTab,
                        ], 
                    ], 200);
                } else {
                    return response()->json([
                        'error'=>true,
                        'message'=> 'The password is incorrect', 
                    ], 400);
                }
            }else{
                return response()->json([
                    'error'=>true,
                    'message'=> 'This user is not found : '.$request->userName, 
                ], 400);
            }
        } catch (\Throwable $e) {
            return response()->json([
                'error'=>true,
                'message'=> 'Something went wrong, please try again',
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function singup(Request $request)
    {
        try {
                DB::beginTransaction();
                
                $user = User::create([
                    'firstName' => $request->firstName,
                    'middleName' => $request->middleName,
                    'lastName' => $request->lastName,
                    'userName' => $request->userName,
                    'email' => $request->email,
                    'phoneNumber' => $request->phoneNumber,
                    'password' => Hash::make($request->password),
                    'gender' => $request->gender,
                ]);

                $userRoleTab = UserRole::create([
                    'user_id' => $user->id,
                    'role_id' => 2,
                ]);
                
                $establishment = Establishment::create([
                    'nameEtablishment' => $request->nameEtablishment,
                    'latitudeEtablishment' => $request->latitudeEtablishment,
                    'longitudeEtablishment' => $request->longitudeEtablishment,
                    'address' => $request->address,
                    'user_id' => $user->id,
                    'workers' => json_encode([$user->id]),
                    'workingDays' => $request->workingDays ? json_encode($request->workingDays) : json_encode(['Lundi', 'Mardi', 'Mercredi', 'Jeudi','Vendredi', 'Samedi', 'Dimanche']),
                ]);

                $token = $user->createToken($user->id);

                $userRoles = UserRole::where('user_id', $user->id)->get();
                $userRoleTab = [];

                foreach($userRoles as $role){
                    $userRole = userRole::where('id', $role->role_id)->first();
                    if($userRole){
                        $userRoleObject = (object) [
                            'nameRole' => $userRole->nameRole,
                            'id' => $userRole->id,
                        ];
                        array_push($userRoleTab, $userRoleObject );
                    }
                };
                DB::commit();
                return response()->json([
                    'error'=>false,
                    'message'=> 'User created & establishment are created with successfully', 
                    'data' => [
                        "user" => $user,
                        "establishment" => $establishment,
                        "token" => $token->plainTextToken,
                        "userRoles" => $userRoleTab,
                    ]
                ], 200); 
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'error'=>true,
                'message' => 'Request failed, please try again',
                'data' => $th,
            ], 400);     
        }
    }
}
