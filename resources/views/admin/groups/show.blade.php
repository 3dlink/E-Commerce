@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-heading center"><label>Group details </label></div>

				<div class="panel-body">
					<div class="col-md-6">
						<div class="form-group">
							<label>Name: </label>
							{{$group->name}}
						</div>
					</div>

					<div class="col-md-12">
						<div class="form-group">
							<label>Description: </label>
							{{$group->description}}
						</div>
					</div>

					<div class="form-group">
					<br>
						<label>Currently formed by:</label>
						<div class="col-md-12" style="height: 200px; overflow: scroll;">
							@if(count($groups)>0)
							<b>Groups</b><br>
							@foreach($groups as $g)
							<div class="col-md-4">
								{{$g->name}}
							</div>	
							@endforeach
							<br><br>
							@endif
							@if(count($categories)>0)
							<b>Categories</b><br>
							@foreach($categories as $c)
							<div class="col-md-4">
								{{$c->name}}
							</div>	
							@endforeach
							@endif
						</div>
					</div>
				</div>
			</div>

			<div class="panel-footer">
				<a href="{{ route('groups.index') }}"><button class="btn btn-default" type="button">Back</button></a>
			</div>

		</div>
	</div>
</div>
</div>
@endsection
