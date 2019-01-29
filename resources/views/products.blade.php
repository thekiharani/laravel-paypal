@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3">All Product</div>
                <div class="card-body">
                	@include('layouts._messages')
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
