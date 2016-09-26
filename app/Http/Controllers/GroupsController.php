<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Category;
use App\Group;

class GroupsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$groups = Group::all();

		return view('admin.groups.index')->with('groups', $groups);


		// $g1 = new Group();
		// $g1-> name = 'g1';
		// $g1-> save();

		// $g2 = new Group();
		// $g2-> name = 'g2';
		// $g2-> save();


		// $g1 -> groups()->attach([1,2]);

		// $g2 -> groups()->attach([3,4]);


		// $g3 = new Group();
		// $g3->name = 'g3';
		// $g3->save();

		// $g3->groups()->attach([1,2]);
		// $g = Group::find(3);

		// foreach ($g->groups as $member) {
		// 	dd($member->groups);
		// 	print_r();
		// }


		// $g4 = Group::find(4);
		// $g4->groups()->detach();
		// $g4->groups()->attach(3);
		// $g4->groups()->attach(1);

		// $c = Category::find(3);

		// echo (json_encode($c->belongs));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$groups = Group::all();
		$categories = Category::all();
		return view('admin.groups.create')->with('groups', $groups)->with('categories', $categories);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$this -> validate($request,[
			'name'  =>         'required|unique:groups'
			]);

		$g = Group::all();
		$c = Category::all();
		$qg = count($g);
		$qc = count($c);

		$group = new Group();
		$group -> name = $request -> name;
		$group -> description = $request -> description;
		$group -> save();

		$groups = [];
		$categories = [];

		foreach ($g as $gr) {
			if ($request->input($gr->name) != null) {
				array_push($groups, $request->input($gr->name));
			}
		}

		foreach ($c as $ct) {
			if ($request->input($ct->name) != null) {
				array_push($categories, $request->input($ct->name));
			}
		}

		if (count($groups)>0) {
			$group -> groups()->attach($groups);
		}
		if (count($categories)>0) {
			$group -> categories()->attach($categories);
		}

		return redirect() -> route('groups.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$group = Group::find($id);
		$groups = $group->groups;
		$categories = $group->categories;

		return view('admin.groups.show')->with('group', $group)->with('groups', $groups)->with('categories',$categories);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$group = Group::find($id);
		$groups = Group::all();
		$categories = Category::all();
		$objC = $group->categories;
		$objG = $group->groups;

		return view('admin.groups.edit')->with('groups', $groups)->with('categories', $categories)->with('group', $group)->with('objG', $objG)->with('objC', $objC);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this -> validate($request,[
			'name'  =>         'required'
		]);

		$g = Group::all();
		$c = Category::all();
		$qg = count($g);
		$qc = count($c);

		$group = Group::find($id);
		$group -> name = $request -> name;
		$group -> description = $request -> description;
		$group -> save();

		$group->categories()->detach();
		$group->groups()->detach();

		$groups = [];
		$categories = [];

		foreach ($g as $gr) {
			if ($request->input($gr->name) != null) {
				array_push($groups, $request->input($gr->name));
			}
		}

		foreach ($c as $ct) {
			if ($request->input($ct->name) != null) {
				array_push($categories, $request->input($ct->name));
			}
		}

		if (count($groups)>0) {
			$group -> groups()->attach($groups);
		}
		if (count($categories)>0) {
			$group -> categories()->attach($categories);
		}

		return redirect() -> route('groups.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$group = Group::find($id);

		$group->belongs()->detach();
		$group->groups()->detach();
		$group->categories()->detach();

		$group -> delete();

		return redirect() -> route('groups.index');
	}

	public function get_tree($id)
	{
		$child = (object) [];

		if (isset($_GET['type'])){
			$if = $_GET["type"];
		}else{
			$if = 'group';
		}
		
		if ($if == 'group') {
			$group = Group::find($id);

			$child->id = $id;
			$child->name = $group->name;
			$child->groups = $group->groups;
			$child->categories = $group->categories;
			$child->parents = json_decode($this->get_parents($id));

			for ($i=0; $i < count($child->groups); $i++) { 
				$child->groups[$i] = json_decode($this->get_tree($child->groups[$i]->id));
			}
		} else {
			$category = Category::find($id);

			$child->id = $id;
			$child->parents = json_decode($this->get_parents($id, 'category'));

		}

		return json_encode($child);
	}

	public function get_parents($id, $type = 'group'){
		if ($type == 'group') {
			$groups = Group::find($id)->belongs;
		} elseif ($type == 'category') {
			$groups = Category::find($id)->belongs;
		}

		$result = [];

		foreach ($groups as $g) {
			array_push($result, $g->name);
			$result = array_merge($result, json_decode($this->get_parents($g->id)));
		}
		
		return json_encode($result);
	}
}