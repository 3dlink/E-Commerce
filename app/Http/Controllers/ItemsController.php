<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Item;
use App\Category;

class ItemsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$items = Item::paginate(10);
		return view('admin.items.index')->with('items', $items);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$categories = Category::all();

		return view('admin.items.create')->with('categories', $categories);
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
			'name'  =>         'required',
			'price' =>  'required|numeric|min:1'
			]);

		$item = new Item();
		$item -> name = $request -> name;
		$item -> price = $request -> price;
		$item -> description = $request -> description;
		$item -> img1 = $request -> img1;
		$item -> img2 = $request -> img2;
		$item -> img3 = $request -> img3;
		$item -> img4 = $request -> img4;
		$item -> save();

		$c = Category::all();
		$qc = count($c);
		$categories = [];

		foreach ($c as $ct) {
			if ($request->input($ct->name) != null) {
				array_push($categories, $request->input($ct->name));
			}
		}

		if (count($categories)>0) {
			$item -> categories()->attach($categories);
		}

		return redirect() -> route('items.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$item = Item::find($id);
		$categories = $item->categories;

		return view('admin.items.show')->with('item', $item)->with('categories', $categories);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		$item = Item::find($id);
		$categories = Category::all();
		$objC = $item->categories;

		return view('admin.items.edit')->with('categories', $categories)->with('item', $item)->with('objC', $objC);
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
			'name'  =>         'required',
			'price' =>  'required|numeric|min:1'
			]);

		$item = Item::find($id);
		$item -> name = $request -> name;
		$item -> price = $request -> price;
		$item -> description = $request -> description;
		if ($request->img1 != null) {
			$item -> img1 = $request -> img1;
		}
		if ($request->img2 != null) {
			$item -> img2 = $request -> img2;
		}
		if ($request->img3 != null) {
			$item -> img3 = $request -> img3;
		}
		if ($request->img4 != null) {
			$item -> img4 = $request -> img4;
		}

		$item -> save();

		$item->categories()->detach();

		$c = Category::all();
		$qc = count($c);
		$categories = [];

		foreach ($c as $ct) {
			if ($request->input($ct->name) != null) {
				array_push($categories, $request->input($ct->name));
			}
		}

		if (count($categories)>0) {
			$item -> categories()->attach($categories);
		}

		return redirect() -> route('items.index');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$item = Item::find($id);
		$item->categories()->detach();

		$item -> delete();

		return redirect() -> route('items.index');
	}
}
