@if( $errors->has() || Session::has('failure') )
	<div class="alert alert-danger">
		<button type="button" class="close" data-dismiss="alert">
			<i class="icon-remove"></i>
		</button>
		<i class="icon-remove red"></i>
		@foreach ($errors->all() as $message) 
			<span>{{$message}}</span><br/>
		@endforeach
		{{Session::get('failure')}}
	</div>
@endif
@if( Session::has('success') )
	<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">
			<i class="icon-remove"></i>
		</button>
		<i class="icon-ok green"></i>
		{{Session::get('success')}}
	</div>
@endif