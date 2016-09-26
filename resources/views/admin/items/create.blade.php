@extends('layouts.app')

@section('content')

<div class="container">
	<div class="row">
		<div class="col-md-10 col-md-offset-1">
			<div class="panel panel-default">

				<div class="panel-heading center">New Item</div>
				{!! Form::open(['route' => 'items.store', 'method' => 'POST']) !!}

				<div class="panel-body">

					<div class="form-group col-md-12">
						{!! Form::label('name', 'Name') !!}
						{!! Form::text('name', null, ['placeholder' => 'Item name', 'class' => 'form-control', 'required']) !!}
						<span class="msjError"> @if ($errors->first('name')) *{{ $errors->first('name') }} @endif</span>
					</div>

					<div class="form-group col-md-6">
						{!! Form::label('price', 'Price') !!}
						{!! Form::number('price', null, ['class' => 'form-control', 'required']) !!}
						<span class="msjError"> @if ($errors->first('price')) *{{ $errors->first('price') }} @endif</span>
					</div>

					<div class="form-group col-md-12">
						{!! Form::label('description', 'Description') !!}
						{!! Form::textarea('description', null, array('class' => 'form-control')) !!}
					</div>

					<div class="form-group col-md-12">
					{!! Form::label('categories', 'Categories') !!}
						<div class="col-md-12 form-control" style="height: 200px; overflow: scroll;">
							@foreach($categories as $category)
							<div class="col-md-4">
								{!! Form::checkbox($category->name, $category->id) !!} {{$category->name}}
							</div>
							@endforeach
						</div>
					</div>

					<div class="col-md-12">
						<div class="col-md-6 dlink-dropzone" style="margin:30px 0;">
							<label>Image 1</label>
							<div  class="dropzone"  id ="img1"  name="mainFileUploader">
								<div  class="fallback">
									<input  name="file"  type="file"/>
								</div>
							</div>
						</div>
						<div class="col-md-6 dlink-dropzone" style="margin:30px 0;">
							<label>Image 2</label>
							<div  class="dropzone"  id ="img2"  name="mainFileUploader">
								<div  class="fallback">
									<input  name="file"  type="file"/>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="col-md-6 dlink-dropzone" style="margin:30px 0;">
							<label>Image 3</label>
							<div  class="dropzone"  id ="img3"  name="mainFileUploader">
								<div  class="fallback">
									<input  name="file"  type="file"/>
								</div>
							</div>
						</div>

						<div class="col-md-6 dlink-dropzone" style="margin:30px 0;">
							<label>Image 4</label>
							<div  class="dropzone"  id ="img4"  name="mainFileUploader">
								<div  class="fallback">
									<input  name="file"  type="file"/>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div id="content_img1"></div>
				<div id="content_img2"></div>
				<div id="content_img3"></div>
				<div id="content_img4"></div>

				<div class="panel-footer">
					<a href="{{ route('items.index') }}"><button class="btn btn-default" type="button">Back</button></a>
					{!! Form::submit('Add Item', array('class'=>'btn btn-primary')) !!}
				</div>
				{!! Form::close() !!}

			</div>
		</div>
	</div>
</div>
@endsection

@section('script')
<script>
	$("#img1").dropzone({ url: "{{route('img.upload')}}", maxFilesize: 5, dictDefaultMessage: '<div class="col-xs-12 text-center" style="padding-bottom:20px"><img src="{{URL::asset("img/file.png")}}" alt="" /></div><p class="dropzone-add-message">Drag here the file to be uploaded or <a  class="add-files">select it from your computer</a></p>',maxFiles: 1, acceptedFiles: "image/jpeg,image/png,image/gif", headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success:function(data){
			$('#content_img1').append('<input type="hidden" value='+data.xhr.response+' name="img1">');
		}
	});

	$("#img2").dropzone({ url: "{{route('img.upload')}}", maxFilesize: 5, dictDefaultMessage: '<div class="col-xs-12 text-center" style="padding-bottom:20px"><img src="{{URL::asset("img/file.png")}}" alt="" /></div><p class="dropzone-add-message">Drag here the file to be uploaded or <a  class="add-files">select it from your computer</a></p>',maxFiles: 1, acceptedFiles: "image/jpeg,image/png,image/gif", headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success:function(data){
			$('#content_img2').append('<input type="hidden" value='+data.xhr.response+' name="img2">');
		}
	});

	$("#img3").dropzone({ url: "{{route('img.upload')}}", maxFilesize: 5, dictDefaultMessage: '<div class="col-xs-12 text-center" style="padding-bottom:20px"><img src="{{URL::asset("img/file.png")}}" alt="" /></div><p class="dropzone-add-message">Drag here the file to be uploaded or <a  class="add-files">select it from your computer</a></p>',maxFiles: 1, acceptedFiles: "image/jpeg,image/png,image/gif", headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success:function(data){
			$('#content_img3').append('<input type="hidden" value='+data.xhr.response+' name="img3">');
		}
	});

	$("#img4").dropzone({ url: "{{route('img.upload')}}", maxFilesize: 5, dictDefaultMessage: '<div class="col-xs-12 text-center" style="padding-bottom:20px"><img src="{{URL::asset("img/file.png")}}" alt="" /></div><p class="dropzone-add-message">Drag here the file to be uploaded or <a  class="add-files">select it from your computer</a></p>',maxFiles: 1, acceptedFiles: "image/jpeg,image/png,image/gif", headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
		success:function(data){
			$('#content_img4').append('<input type="hidden" value='+data.xhr.response+' name="img4">');
		}
	});
</script>
@endsection