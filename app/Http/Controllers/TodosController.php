<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use Validator;

class TodosController extends Controller
{
    public function index()
    {
        $todos = Todo::all();

        return response()->json([
            'todos' => $todos
        ]);
    }

    public function show(Request $request, $id)
    {
        $todo = Todo::where('id', $id)->first();

        if ($todo === null)
        {
            return response()->json([
                'msg' => 'not found'
            ], 404);
        }

        return response()->json([
            'todo' => $todo
        ]);
    }

    public function create(Request $request)
    {
        $user = $request->user();
        $input = array_merge($request->only(['text']), ['user_id' => $user->id]);

        $validator = Validator::make($input, [
            'user_id' => 'required|exists:users,id',
            'text' => 'required|max:500'
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $todo = (new Todo())->fill($input);
        $todo->save();
        $todo->refresh();

        return response()->json([
            'msg' => 'done',
            'todo' => $todo
        ]);
    }

    public function update(Request $request, $id)
    {
        $todo = Todo::where('id', $id)->first();

        if ($todo === null)
        {
            return response()->json([
                'msg' => 'not found'
            ], 404);
        }

        $user = $request->user();
        $input = array_merge($request->only(['text']), ['user_id' => $user->id]);

        $validator = Validator::make($input, [
            'user_id' => 'required|exists:users,id',
            'text' => 'required|max:500'
        ]);

        if ($validator->fails())
        {
            return response()->json($validator->errors(), 400);
        }

        $todo->update($input);

        return response()->json([
            'msg' => 'done',
            'todo' => $todo
        ]);
    }

    public function complete(Request $request, $id)
    {
        $todo = Todo::where('id', $id)->first();

        if ($todo === null)
        {
            return response()->json([
                'msg' => 'not found'
            ], 404);
        }

        $todo->markComplete();

        return response()->json([
            'msg' => 'done',
            'todo' => $todo
        ]);
    }

    public function incomplete(Request $request, $id)
    {
        $todo = Todo::where('id', $id)->first();

        if ($todo === null)
        {
            return response()->json([
                'msg' => 'not found'
            ], 404);
        }

        $todo->markIncomplete();

        return response()->json([
            'msg' => 'done',
            'todo' => $todo
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $todo = Todo::where('id', $id)->first();

        if ($todo === null)
        {
            return response()->json([
                'msg' => 'not found'
            ], 404);
        }

        $todo->delete();

        return response()->json([
            'msg' => 'done'
        ]);
    }
}
