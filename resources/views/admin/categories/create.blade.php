@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-heading center">New Category</div>
				{!! Form::open(['route' => 'categories.store', 'method' => 'POST']) !!}

				<div class="panel-body">

					<div class="form-group">
						{!! Form::label('name', 'Name') !!}
						{!! Form::text('name', null, ['placeholder' => 'Category name', 'class' => 'form-control', 'required']) !!}
						<span class="msjError"> @if ($errors->first('name')) *{{ $errors->first('name') }} @endif</span>
					</div>

					<div class="form-group">
						{!! Form::label('description', 'Description') !!}
						{!! Form::textarea('description', null, array('class' => 'form-control')) !!}
					</div>
				</div>

				<div class="panel-footer">
					<a href="{{ route('categories.index') }}"><button class="btn btn-default" type="button">Back</button></a>
					{!! Form::submit('Add Category', array('class'=>'btn btn-primary')) !!}
				</div>
				{!! Form::close() !!}

			</div>
		</div>
	</div>
</div>
@endsection
