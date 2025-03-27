<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    /**
     * Exibir a lista de colaboradores.
     */
    public function index()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }

    /**
     * Armazena um novo colaborador no banco de dados.
     */
    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'parent_name' => 'required|string|max:255',
            'cpf' => 'required|string|size:14|unique:employees,cpf',
            'birth_date' => 'required|date',
            'position' => 'required|string|max:100',
        ]);

        $employee = Employee::create($request->all());

        return response()->json([
            'message' => 'Colaborador cadastrado com sucesso!',
            'employee' => $employee
        ], 201);
    }

    /**
     * Exibir um colaborador específico.
     */
    public function show(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Colaborador não encontrado!'], 404);
        }

        return response()->json($employee);
    }

    /**
     * Atualizar um colaborador.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Colaborador não encontrado!'], 404);
        }

        $request->validate([
            'full_name' => 'sometimes|required|string|max:255',
            'nickname' => 'nullable|string|max:100',
            'parent_name' => 'sometimes|required|string|max:255',
            'cpf' => 'sometimes|required|string|size:14|unique:employees,cpf,' . $id,
            'birth_date' => 'sometimes|required|date',
            'position' => 'sometimes|required|string|max:100',
        ]);

        $employee->update($request->all());

        return response()->json([
            'message' => 'Colaborador atualizado com sucesso!',
            'employee' => $employee
        ]);
    }

    /**
     * Remover um colaborador.
     */
    public function destroy(string $id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Colaborador não encontrado!'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Colaborador excluído com sucesso!']);
    }
}
