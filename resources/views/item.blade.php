@extends("layouts.index")

@section('content')

<div class="item-section">
	<div class="item-header">
		<div class="image-slider">
			@if($item->img1 != null)
			<div class="image-holder">
				<img class="item-img" src="{{URL::asset('files').'/'.$item->img1}}" style="height: 300px; margin: 0 auto;" data-zoom-image="{{URL::asset('files').'/'.$item->img1}}">
			</div>
			@endif
			@if($item->img2 != null)
			<div class="image-holder">
				<img class="item-img" src="{{URL::asset('files').'/'.$item->img2}}" style="height: 300px; margin: 0 auto;" data-zoom-image="{{URL::asset('files').'/'.$item->img2}}">
			</div>
			@endif
			@if($item->img3 != null)
			<div class="image-holder">
				<img class="item-img" src="{{URL::asset('files').'/'.$item->img3}}" style="height: 300px; margin: 0 auto;" data-zoom-image="{{URL::asset('files').'/'.$item->img3}}">
			</div>
			@endif
			@if($item->img4 != null)
			<div class="image-holder">
				<img class="item-img" src="{{URL::asset('files').'/'.$item->img4}}" style="height: 300px; margin: 0 auto;" data-zoom-image="{{URL::asset('files').'/'.$item->img4}}">
			</div>
			@endif
		</div>
	</div>

	<div class="item-detail">
		<h1 class="item-name">{{$item->name}}</h1>
		<h6>
		<?php 
			for ($i=0; $i < count($item->categories); $i++) { 
				if ($i != count($item->categories)-1) {
					echo $item->categories[$i]->name.", ";
				}else{
					echo $item->categories[$i]->name;
				}
			}
		 ?>
		</h6>
		{{$item->price}}
		<p class="item-desc">{{$item->description}}</p>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">
	$(".image-slider").slick({
		arrows: false
	});

	$(".item-img").elevateZoom({
		cursor: "crosshair"
	});

  </script>

  @endsection