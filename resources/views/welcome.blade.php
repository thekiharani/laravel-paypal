@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Paypal Integration</div>
                <div class="card-body">
                	<h3>Create Product</h3>
                	@if (session('success'))
					    <div class="alert alert-success alert-dismissible fade show" role="alert">
						  {{ session('success') }}
						  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
						    <span aria-hidden="true">&times;</span>
						  </button>
						</div>
					@endif
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
                			<label for="shipping">Shipping (%)</label>
                			<input type="number" min="0.00" name="shipping" id="shipping" class="form-control">
                		</div>
                		<div class="form-group">
                			<input type="submit" class="btn btn-info" value="Submit">
                		</div>
                	</form>

                	<hr>
                    <form action="{{ route('payment.create') }}" method="POST">
                    	@csrf
                    	<label for="sub"><img src="https://www.paypalobjects.com/webstatic/mktg/merchant_portal/button/buynow.en.png" alt="Pay Now" width="150" height="40"></label>
                    	<input type="submit" id="sub" class="d-none">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
