<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function index()
    {
        $todo_list = auth()->user()->todoList;
        return view('todo.show', compact('todo_list'));
    }

    public function store(Request $request)
    {
        if ($request->has('todo_list_id')) {
            $todo_list = TodoList::find($request->todo_list_id);
            $todo_list->update([
                'content' => $request->todo_content,
            ]);
        } else {
            TodoList::create([
                'user_id'   => auth()->id(),
                'content'   => $request->todo_content,
            ]);
        }

        return back();
    }
}
