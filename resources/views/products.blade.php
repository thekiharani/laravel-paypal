@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3">All Product</div>
                <div class="card-body">
                	@if (session('success'))
					    <div class="alert alert-success alert-dismissible fade show" role="alert">
						  {{ session('success') }}
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>
					@endif
                	<ul class="list-group">
                		@foreach ($products as $product)
                			<li class="list-group-item">{{ $product->name }}</li>
                		@endforeach
                	</ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
