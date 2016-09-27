@extends('layouts.index')

@section('css')

<style type="text/css">

	#search {
		background: transparent;
		background: rgba(163, 135, 106, 0.15);
		background-clip: padding-box;

		border: none;
		border-radius:         26px;
		-moz-border-radius:    26px;
		-o-border-radius:      26px;
		-webkit-border-radius: 26px;

		box-shadow:         inset 0 0 5px rgba(0, 0, 0, 0.1), 
		0 1px 0 rgba(255, 255, 255, 0.5), 
		inset 0 1px 2px rgba(0, 0, 0, 0.3), 
		0 0 40px rgba(255, 255, 255, 0.3);
		-moz-box-shadow:    inset 0 0 5px rgba(0, 0, 0, 0.1), 
		0 1px 0 rgba(255, 255, 255, 0.5), 
		inset 0 1px 2px rgba(0, 0, 0, 0.3), 
		0 0 40px rgba(255, 255, 255, 0.3);
		-o-box-shadow:      inset 0 0 5px rgba(0, 0, 0, 0.1), 
		0 1px 0 rgba(255, 255, 255, 0.5), 
		inset 0 1px 2px rgba(0, 0, 0, 0.3), 
		0 0 40px rgba(255, 255, 255, 0.3);
		-webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.1), 
		0 1px 0 rgba(255, 255, 255, 0.5), 
		inset 0 1px 2px rgba(0, 0, 0, 0.3), 
		0 0 40px rgba(255, 255, 255, 0.3);

		color: #333;
		height: 26px;
		margin: 0px 80px 0 80px;
		outline: none;
		padding: 0 20px 0 35px;

		transition:         all .1s linear;
		-moz-transition:    all .1s linear;
		-o-transition:      all .1s linear;
		-webkit-transition: all .1s linear;

		width: 185px;
	}

	#search:focus {
		background: transparent;
		background: rgba(163, 135, 106, 0.2);

		box-shadow:         inset 0 0 5px rgba(0, 0, 0, 0.2), 
		0 1px 0 rgba(255, 255, 255, 0.7), 
		inset 0 1px 2px rgba(0, 0, 0, 0.4), 
		0 0 40px rgba(255, 255, 255, 0.5);
		-moz-box-shadow:    inset 0 0 5px rgba(0, 0, 0, 0.2), 
		0 1px 0 rgba(255, 255, 255, 0.7), 
		inset 0 1px 2px rgba(0, 0, 0, 0.4), 
		0 0 40px rgba(255, 255, 255, 0.5);
		-o-box-shadow:      inset 0 0 5px rgba(0, 0, 0, 0.2), 
		0 1px 0 rgba(255, 255, 255, 0.7), 
		inset 0 1px 2px rgba(0, 0, 0, 0.4), 
		0 0 40px rgba(255, 255, 255, 0.5);
		-webkit-box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2), 
		0 1px 0 rgba(255, 255, 255, 0.7), 
		inset 0 1px 2px rgba(0, 0, 0, 0.4), 
		0 0 40px rgba(255, 255, 255, 0.5);
	}
	label[for="search"] {
		background: transparent url(http://f.cl.ly/items/2a2Z0V0L0J1p3V082d3r/icon-search.png) no-repeat top left;
		cursor: pointer;
		display: block;
		height: 17px;
		left: 90px;
		position: relative;
		text-indent: -99999px;
		top: -21px;
		width: 16px;
	}
</style>
@endsection

@section('content')

<div class="col-md-3" style="float: left;">
	<div class="categories">

	</div>

	<br><br>
	<div class="filters">
		Sort by
		<select class="sort-filter">
			<option value="recent">Most recents</option>
			<option value="buyed">Most buyed</option>
			<option value="pricelh">Price: Low to High</option>
			<option value="pricehl">Price: High to Low</option>
			<option value="name">Name</option>
		</select>
	</div>
</div>

<div class="col-md-9">
	<div class="col-md-12">
		<form id="search-form">
			<input type="text" id="search" placeholder="search...">
			<label for="search">Search</label>
		</form>
	</div>
	<div class="col-md-12 item-section">
		@foreach($items as $item)
		<div class="col-md-3">
			<div class="item-container">
				<div class="item-header">
					<img class="item-img" src="{{URL::asset('files').'/'.$item->img1}}" style="height: 100px;" data-zoom-image="{{URL::asset('files').'/'.$item->img1}}">
				</div>

				<div class="item-info">
					<h3>{{$item->name}}</h3>
					{{$item->price}}
				</div>

			</div>
		</div>
		@endforeach
	</div>

	<div class="section-footer">
		{{ $items->links() }}
	</div>
</div>
@endsection

@section('script')

<script type="text/javascript">
	var cat = <?php print_r(json_encode(session("tree"))) ?>;
	var search = [];

	function categories(array){
		var html = "<ul>";

		for (var i = 0; i < array.length; i++) {
			if (array[i].type == "group"){
				html+= "<li><a class='cat-group' href='{{url('/')}}?category="+array[i].name+"&type=gr'>"+array[i].name;
				html+="</a><span class='caret'></span>";
				html+= categories(array[i].childs);
				html+="</li>"
			} else {
				html+= "<li><a class='cat-group' href='{{url('/')}}?category="+array[i].name+"&type=cat'>"+array[i].name;
				html+="</a></li>"
			}
		}
		html+="</ul>"

		return html;
	}

	$(document).ready(function(){
		$(".categories").append(categories(cat));

		$(".sort-filter option[value='<?php echo session("order") ?>']").attr('selected', true);

		var url = window.location.search.substring(1);
		url = url.split("&");


		for (var i = url.length - 1; i >= 0; i--) {
			var aux = url[i].split("=");
			search[aux[0]] = aux[1];
		}

      //   $(".item-img").elevateZoom({
      //     zoomType              : "inner",
      //     cursor: "crosshair"
      // });

  });

	$(".sort-filter").on("change", function(){
		url = "{{url('/')}}?order="+$(this).val();

		if ("category" in search) {
			url+= "&category="+search["category"];
			url+= "&type="+search["type"];
		}

		if ("search" in search) {
			url+="&search="+search["search"];
		}

		window.location.replace(url);
	});

	$("span.cat-group").on("click", function(){
	});

	$("span[for='search']").click(function(){
		$("#search-form").submit();
	});

	$("#search-form").submit(function(e){
		 e.preventDefault();
		 url = "{{url('/')}}?search="+$("#search").val();

		 window.location.replace(url);
	});
</script>

@endsection