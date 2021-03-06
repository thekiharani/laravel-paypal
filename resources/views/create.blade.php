@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header h3">Create Product</div>
                <div class="card-body">
                	@include('layouts._messages')
                	<form action="{{ route('products.store') }}" method="POST">
                		@csrf
                		<div class="form-group">
                			<label for="name">Name</label>
                			<input type="text" name="name" id="name" class="form-control">
                		</div>
                		<div class="form-group">
                			<label for="price">Price</label>
                			<input type="number" min="0.00" name="price" id="price" class="form-control">
                		</div>
                		<div class="form-group">
                			<label for="tax">Tax (%)</label>
                			<input type="number" min="0.00" name="tax" id="tax" class="form-control">
                		</div>
                		<div class="form-group">
                			<input type="submit" class="btn btn-info" value="Submit">
                		</div>
                	</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
