@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Paypal Integration</div>
                <div class="card-body">
                	<h3>Create Product</h3>
                	@include('layouts._messages')
                    <form action="{{ route('orders.store') }}" method="POST">
                    	@csrf
                    	@foreach ($products as $product)
                    	    <input type="hidden" name="product_id[]" value="{{ $product->id }}">
                    	    <input type="hidden" name="price[]" value="{{ $product->less_tax }}">
                    	    <input type="hidden" name="tax[]" value="{{ $product->tax_value }}">
                    	    <input type="hidden" name="total[]" value="{{ $product->price }}">
                    		<div class="row">
                    			<div class="form-group col-sm-3">
                    				<label>Name</label>
                    				<input type="text" name="name[]" class="form-control" value="{{ $product->name }}" readonly>
                    			</div>
                    			<div class="form-group col-sm-3">
                    				<label>Qty</label>
                    				<input type="number" min="1" name="qty[]" class="form-control qty qty-{{ $product->id }}" value="1" id="{{ $product->id }}">
                    			</div>
                    			<div class="form-group col-sm-3">
                    				<label>Amount</label>
                    				<input type="number" min="1" name="amount[]" class="form-control amount amount-{{ $product->id }}" value="{{ $product->price }}" id="{{ $product->id }}" unit="{{ $product->price }}" readonly>
                    			</div>
                    		</div>
                    	@endforeach
                    	<label for="sub"><img src="https://www.paypalobjects.com/webstatic/mktg/merchant_portal/button/buynow.en.png" alt="Pay Now" width="150" height="40"></label>
                    	<input type="submit" id="sub" class="d-none">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('script')
<script>
$(document).ready(function() {
	$(document).on('change', '.qty', function() {
		var id = $(this).attr('id');
		$('input[type=number].qty-' + id).val(parseInt($(this).val()));
		var qty = parseInt($(this).val());
		var price = parseInt($('.amount-' + id).attr('unit'));
		$('input[type=number].amount-' + id).val(parseInt(qty * price));
		// $('.price-' + id).val(parseInt(qty * price));
	});
});
</script>
@endpush
@endsection
