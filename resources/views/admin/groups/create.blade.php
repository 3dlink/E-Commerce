@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-heading center">New Group</div>
				{!! Form::open(['route' => 'groups.store', 'method' => 'POST']) !!}

				<div class="panel-body">

					<div class="form-group">
						{!! Form::label('name', 'Name') !!}
						{!! Form::text('name', null, ['placeholder' => 'Group name', 'class' => 'form-control', 'required']) !!}
						<span class="msjError"> @if ($errors->first('name')) *{{ $errors->first('name') }} @endif</span>
					</div>

					<div class="form-group">
						{!! Form::label('description', 'Description') !!}
						{!! Form::textarea('description', null, array('class' => 'form-control')) !!}
					</div>

					<div class="form-group">
						{!! Form::label('groups', 'Groups') !!}
						<div class="col-md-12 form-control" style="height: 200px; overflow: scroll;">
							@foreach($groups as $group)
							<div class="col-md-4">
								{!! Form::checkbox($group->name, $group->id) !!} {{$group->name}}
							</div>
							@endforeach
						</div>
					</div>

					<div class="form-group">
					{!! Form::label('categories', 'Categories') !!}
						<div class="col-md-12 form-control" style="height: 200px; overflow: scroll;">
							@foreach($categories as $category)
							<div class="col-md-4">
								{!! Form::checkbox($category->name, $category->id) !!} {{$category->name}}
							</div>
							@endforeach
						</div>
					</div>
				</div>

				<div class="panel-footer">
					<a href="{{ route('groups.index') }}"><button class="btn btn-default" type="button">Back</button></a>
					{!! Form::submit('Add Group', array('class'=>'btn btn-primary')) !!}
				</div>
				{!! Form::close() !!}

			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script type="text/javascript">

	var semaforo = [];
	@foreach($groups as $g)
	semaforo ["{{$g->name}}"] = 0;
	@endforeach

	@foreach($categories as $c)
	semaforo ["{{$c->name}}"] = 0;
	@endforeach
	
	function disable_C(data){
		var result = [];

		for (var i = 0; i < data.length; i++) {
			result.push(data[i].name);
		}

		return result;
	}

	function disable_G(data){
		var result = [];

		for (var i = 0; i < data.groups.length; i++) {
			result.push(data.groups[i].name);
			result = result.concat(disable_G(data.groups[i]));
		}

		result = result.concat(disable_C(data.categories));

		return result;
	}

	var checked = [];

	$('input[type="checkbox"]').click(function(){
		var me = $(this);

		var name = me.attr("name");

		if (me.is(":checked") && checked[name] == null) {
			var patt = /g\d/;
			
			if (patt.test(name)) {
				var url = "/tree/"+me.attr("value")+"?type=group";

				$.get(url, function(data){
					data = JSON.parse(data);
					checked[name] = disable_G(data).concat(data.parents);

					disable(checked[name], 1);
				});
			} else{
				var url = "/tree/"+me.attr("value")+"?type=category";

				$.get(url, function(data){
					data = JSON.parse(data);
					checked[name] = data.parents;

					disable(checked[name], 1);
				});
			}
			
		} else if(me.is(":checked") && checked[name] != null) {
			disable(checked[name], 1);
		} else {
			disable(checked[name], 2);
		}
	});

	function disable(array, action){

		if (action == 1) {
			for (var i = array.length - 1; i >= 0; i--) {
				$("input[name='"+array[i]+"']").attr('disabled',"");
				semaforo[array[i]]++;
			}
		} else {
			for (var i = array.length - 1; i >= 0; i--) {
				semaforo[array[i]]--;
				if (semaforo[array[i]] == 0) {
					$("input[name='"+array[i]+"']").attr('disabled', false);
				}
			}
		}
	}

</script>
@endsection