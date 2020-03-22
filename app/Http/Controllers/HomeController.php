<?php

namespace App\Http\Controllers;

use App\Repositories\TodoRepository;
use App\Todo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    protected $todos;

    public function __construct(TodoRepository $todos)
    {
        $this->middleware('auth');
        $this->todos = $todos;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $category = null)
    {

        if ($category) {
            return view('home', [
                'todos' => $this->todos->categoryUser($request->user(), $category)

            ]);
        } else {
            return view('home', [
                'todos' => $this->todos->forUser($request->user()),

            ]);
        }


    }



    public function addTodo(Request $req)
    {

        return $req->user()->tasks()->create([
            'purpose' => $req->purpose,
            'category' => $req->category,
            'description' => $req->description
        ]);

//        return response()->json($req);
    }

    public function get($id)
    {
        if ($todo = Todo::find($id)) {
            return response()->json([
                'purpose' => $todo->purpose,
                'description' => $todo->description,
                'category' => $todo->category,
                'id' => $todo->id
            ]);
        } else {
            return response()->json();
        }
    }

    public function destroy(Request $request, Todo $todo)
    {
        $this->authorize('destroy', $todo);

        $todo->delete();

    }


    public function update(Request $req, $id)
    {
        $todo = Todo::find($id);

        $todo->purpose = $req->input('purpose');
        $todo->category = $req->input('category');
        $todo->description = $req->input('description');

        $todo->save();
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $todos = DB::table('todos')->where('purpose', 'LIKE', '%' . $request->search . '%')->
            orWhere('category', 'LIKE', '%' . $request->search . '%')->
            orWhere('description', 'LIKE', '%' . $request->search . '%')->get();

            if ($todos) {
                foreach ($todos as $key => $todo) {
                    $output .= '<tr>' .
                        '<td>' . $todo->id . '</td>' .
                        '<td>' . $todo->purpose . '</td>' .
                        '<td>' . "<a href=\"home/category/$todo->category\">$todo->category</a>" . '</td>' .
                        '<td>' . $todo->description . '</td>' .
                        '<td>' .  "<button id=\"edit\" type=\"button\" class=\"btn btn-primary editBtn\">edit</button>
                            <button class=\"btn btn-danger deleteBtn\" data-id=\" $todo->id \">Delete</button>" . '</td>' .
                        '</tr>';
                }

                return response($output);
            }

        }

    }

    public function adminPageView()
    {
        $users = User::get();
        return view('admin', compact('users'));
    }

    public function deleteUser($id)
    {
        if($user = User::find($id)) {
            $user->delete();
        }

        return redirect('/home/admin');
    }


}
