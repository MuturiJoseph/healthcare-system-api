<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class ProgramController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/v1/programs",
     *     summary="Create a new health program",
     *     tags={"Programs"},
     *     security={{"sanctum": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="TB"),
     *             @OA\Property(property="description", type="string", example="Tuberculosis treatment program")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Program created"),
     *     @OA\Response(response=422, description="Validation error"),
     *     @OA\Response(response=403, description="Forbidden")
     * )
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:programs',
            'description' => 'nullable|string',
        ]);

        $program = Program::create($validated);

        return response()->json($program, 201);
    }
}