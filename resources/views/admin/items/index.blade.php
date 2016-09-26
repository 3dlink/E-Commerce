@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading center">Items</div>

                <div class="panel-body">
					<table class="table">
						<thead>
							<th>Name</th>
							<th>Price</th>
							<!-- <th>Category</th> -->
							<th>Description</th>
							<th>Actions</th>
						</thead>

						<tbody>
							@foreach($items as $item)
								<tr>
									<td>{{$item->name}}</td>
									<td>{{$item->price}}</td>
									<td>{{$item->description}}</td>
									<td>
										<a class="itemAction" href="{{ route('items.edit', $item->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i></a>
										<a class="itemAction" href="{{ route('items.show', $item->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
										<a class="itemAction" href="" data-toggle="modal" data-target="#myModal{{$item->id}}""><i class="fa fa-trash-o" aria-hidden="true"></i></a>

									</td>
								</tr>
								<div id="myModal{{$item->id}}" class="modal fade" role="dialog">
								  <div class="modal-dialog">
								    <div class="modal-content">
								      <div class="modal-header">
								        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
								        <h4 class="modal-title">Confirm Delete</h4>
								      </div>
								      <div class="modal-body">
								        <p>Are you sure you want to delete this item?</p>
								      </div>
								      <div class="modal-footer">
								        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
								        <a href="{{route('items.destroy', $item->id)}}"><button type="button" class="btn btn-primary">Confirm</button></a>
								      </div>
								    </div>
								  </div>
								</div>
							@endforeach
						</tbody>
					</table>
					{{ $items->links() }}
                </div>
                <div class="panel-footer"><a href="{{ route('items.create') }}"><button class="btn btn-primary">Add item</button></a></div>
            </div>
        </div>
    </div>
</div>



@endsection
