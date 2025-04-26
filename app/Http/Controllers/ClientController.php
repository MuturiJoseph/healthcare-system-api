<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Program;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ClientController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/clients",
     *     summary="Register a new client",
     *     tags={"Clients"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="first_name", type="string", example="John"),
     *             @OA\Property(property="last_name", type="string", example="Doe"),
     *             @OA\Property(property="email", type="string", example="john.doe@example.com"),
     *             @OA\Property(property="date_of_birth", type="string", format="date", example="1990-01-01"),
     *             @OA\Property(property="gender", type="string", example="Male"),
     *             @OA\Property(property="phone", type="string", example="1234567890")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Client registered"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'required|email|unique:clients',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string',
            'phone' => 'nullable|string',
        ]);

        $client = Client::create($validated);

        return response()->json($client, 201);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/clients/{client}/enroll",
     *     summary="Enroll client in a program",
     *     tags={"Clients"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(name="client", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="program_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="Client enrolled"),
     *     @OA\Response(response=404, description="Client or program not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function enroll(Request $request, Client $client)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
        ]);

        $client->programs()->attach($validated['program_id']);

        return response()->json(['message' => 'Client enrolled'], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/clients/search",
     *     summary="Search for clients",
     *     tags={"Clients"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(name="query", in="query", @OA\Schema(type="string")),
     *     @OA\Response(response=200, description="List of clients"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function search(Request $request)
    {
        $query = $request->query('query');
        $clients = Client::where('first_name', 'like', "%$query%")
            ->orWhere('last_name', 'like', "%$query%")
            ->orWhere('email', 'like', "%$query%")
            ->paginate(10);

        return response()->json($clients);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/clients/{client}",
     *     summary="View client profile",
     *     tags={"Clients"},
     *     security={{"sanctum": {}}},
     *     @OA\Parameter(name="client", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Client profile"),
     *     @OA\Response(response=404, description="Client not found"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function show(Client $client)
    {
        return response()->json($client->load('programs'));
    }
}