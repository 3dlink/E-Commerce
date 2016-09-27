<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Group;
use App\Category;
use App\Item;

class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$user = Auth::user();

		if (!$user->is_admin){
			echo "AQUI VA LA REDIRECCION AL INDEX + ALERT DE QUE NO ESTA PERMITIDO A ESE LUGAR";
		} else{
			return view('home');    
		}
	}

	public function upload(Request $request) {
		$time = strtotime("now");
		$file = $request->file('file');

		$filename="img".$time.$this->__randomStr ( 3 ).'.'.$file->getClientOriginalExtension();

		$file->move(base_path().'/public/files/', $filename);

		return json_encode ($filename);
	}

	function __randomStr($length) {
		$str = '';
		$chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";

		$size = strlen ( $chars );
		for($i = 0; $i < $length; $i ++) {
			$str .= $chars [rand ( 0, $size - 1 )];
		}

		return $str;
	}

	public function welcome()
	{
		$groups = Group::all();

		if (!session()->has("tree")) {
			$roots = [];

			foreach ($groups as $g) {
				if (count($g->belongs) == 0) {
					array_push($roots, ["id" => $g->id, "name" => $g->name, "type" => "group", "childs" => $this->category_tree($g->id) ] );
				}
			}
			
			session(['tree' => $roots]);
		}

		$items = $this->get_items();

		return view('welcome')->with('items', $items);
	}

	public function category_tree($id)
	{
		$group = Group::find($id);
		$groups = $group->groups;
		$categories = $group->categories;

		$childs = [];

		if(count($groups)>0){
			foreach ($groups as $g) {
				array_push($childs, ["id" => $g->id, "name" => $g->name, "type" => "group", "childs" => $this->category_tree($g->id) ] );
			}
		}

		if (count($categories)>0) {
			foreach ($categories as $c) {
				array_push($childs, ["id" => $c->id, "name" => $c->name, "type" => "category"]);
			}
		}

		return $childs;
	}

	public function get_category($array, $id)
	{
		$group = Group::find($id);
		$groups = $group->groups;
		$categories = $group->categories;

		if(count($groups)>0){
			foreach ($groups as $g) {
				array_push($array, $this->get_category($array ,$g->id));
			}
		}

		if (count($categories)>0) {
			foreach ($categories as $c) {
				array_push($array, $c->id);
			}
		}

		return $array;
	}

	public function get_items($order = 'recent', $category = null, $type = "group")
	{
		$attr = "";
		$by = "";

		if (isset($_GET["order"])) {
			$order = $_GET["order"];
			session(["order" => $order]);
		} else {
			session(["order" => $order]);
		}

		if (isset($_GET['type'])) {
			$type = $_GET["type"];
			session(["type" => $type]);
		}

		switch ($order) {
			case 'recent':
				$attr = "created_at";
				$by = "desc";
				break;
			case 'buyed':
				$attr = "created_at";
				$by = "asc";
				// A CAMBIAR CUANDO TENGA EL CARRITO
				break;
			case 'pricelh':
				$attr = "price";
				$by = "asc";
				break;
			case 'pricehl':
				$attr = "price";
				$by = "desc";
				break;
			case 'name':
				$attr = "name";
				$by = "asc";
				break;
		}


		if (isset($_GET["category"])) {
			$category = $_GET["category"];

			if ($type == "cat") {
				$cat= DB::table("categories")->where("name", $category)->first();
				$items = Category::find($cat->id)->items->toArray();
				$items = array_column($items, "id");
				$items = DB::table("items")->whereIn("id",$items)->orderBy($attr,$by)->paginate(12);
			} elseif ($type == "gr") {
				$gr = DB::table("groups")->where("name", $category)->first();
				$cat = $this->get_category([], $gr->id);
				$items = DB::table('category_item')->whereIn('category_id', $cat)->select("item_id")->groupBy('item_id')->get();
				$items = explode(",", $items->implode('item_id', ', '));
				$items = DB::table("items")->whereIn("id",$items)->orderBy($attr,$by)->paginate(12);
			}
		} elseif (isset($_GET["search"])) {
			$search = $_GET["search"];
			$items = DB::table("items")->where("name", "like", "%".$search."%")->orderBy($attr, $by)->paginate(12);
		} else {
			$items = DB::table('items')->orderBy($attr, $by)->paginate(12);
		}

		return $items;
	}

}