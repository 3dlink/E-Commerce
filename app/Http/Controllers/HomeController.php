<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
