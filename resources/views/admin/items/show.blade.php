@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-heading center"><label>Item details </label></div>

				<div class="panel-body">
					<div class="col-md-6">
						<div class="form-group">
							<label>Name: </label>
							{{$item->name}}
						</div>
					</div>

					<div class="col-md-6">
						<div class="form-group">
							<label>Price: </label>
							{{$item->price}}
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label>Description: </label>
							{{$item->description}}
						</div>
					</div>

					<div class="form-group col-md-12">
						<br>
						<label>Categories</label>
						<div class="col-md-12" style="height: 100px; overflow: scroll;">
							@foreach($categories as $c)
							<div class="col-md-4">
								{{$c->name}}
							</div>	
							@endforeach
						</div>
					</div>

					<div class="current-imgs col-md-12">
						<label>Current images</label>
						<div class="col-md-12">
							<div class="col-md-3">
								@if($item->img1 != null)
								<label>Image 1</label>
								<img src="{{URL::asset('files/'.$item->img1)}}" style="width:100%;">
								@endif
							</div>

							<div class="col-md-3">
								@if($item->img2 != null)
								<label>Image 2</label>
								<img src="{{URL::asset('files/'.$item->img2)}}" style="width:100%;">
								@endif
							</div>

							<div class="col-md-3">
								@if($item->img3 != null)
								<label>Image 3</label>
								<img src="{{URL::asset('files/'.$item->img3)}}" style="width:100%;">
								@endif
							</div>

							<div class="col-md-3">
								@if($item->img4 != null)
								<label>Image 4</label>
								<img src="{{URL::asset('files/'.$item->img4)}}" style="width:100%;">
								@endif
							</div>
						</div>
					</div>
				</div>

				<div class="panel-footer">
					<a href="{{ route('items.index') }}"><button class="btn btn-default" type="button">Back</button></a>
				</div>

			</div>
		</div>
	</div>
</div>
@endsection
