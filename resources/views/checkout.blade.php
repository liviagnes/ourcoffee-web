@extends('layouts.app')

@section('head')
    <style>
        body {
            background: #f9f6f3;
        }
        .checkout-box {
            background: #fff;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(139, 94, 60, 0.08);
            max-width: 600px;
            margin: 60px auto;
        }
        .payment-option {
            border: 2px solid #f0e6d2;
            border-radius: 12px;
            padding: 18px 20px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }
        .payment-option:hover {
            border-color: #d5bdaf;
            background: #fcf9f5;
        }
        .payment-option:has(input:checked) {
            border-color: #8b5e3c;
            background: #fdfaf6;
            box-shadow: 0 5px 15px rgba(139, 94, 60, 0.1);
        }
        .total-pay {
            font-size: 28px;
            font-weight: 800;
            color: #4a3228;
            text-align: center;
            margin: 15px 0 30px;
        }
        .btn-submit-order {
            background: #8b5e3c;
            color: #fff;
            border-radius: 50px;
            padding: 15px 30px;
            font-weight: bold;
            font-size: 1.1rem;
            transition: all 0.3s ease;
            border: none;
        }
        .btn-submit-order:hover {
            background: #6a442a;
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(139, 94, 60, 0.3);
        }
        .btn-cancel-order {
            color: #a08c80;
            transition: all 0.3s ease;
        }
        .btn-cancel-order:hover {
            color: #4a3228;
            text-decoration: underline !important;
        }
    </style>
@endsection

@section('content')
<div class="container">
    <div class="checkout-box">
        <h2 class="text-center fw-bold mb-4" style="color:#4a3228;">Checkout</h2>

        <form action="{{ url('/checkout/process') }}" method="POST">
            @csrf
            <input type="hidden" name="total_price" value="{{ $grand_total }}">

            <div class="mb-4">
                <label class="form-label fw-bold" style="color: #4a3228;">Table Number</label>
                <input type="text" name="no_meja" class="form-control form-control-lg" placeholder="Example: A-05" required style="border-radius: 12px; border: 2px solid #f0e6d2;">
                <small class="text-muted mt-2 d-block"><i class="fas fa-info-circle me-1"></i>Check the number sticker on your table.</small>
            </div>

            <div class="p-4 rounded-4 mb-4" style="background-color: #fcf9f5; border: 1px dashed #d5bdaf;">
                <p class="text-center text-muted mb-1 text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.85rem;">Total Amount</p>
                <div class="total-pay">Rp {{ number_format($grand_total, 0, ',', '.') }}</div>
            </div>

            <h6 class="fw-bold mb-3" style="color: #4a3228;">Select Payment Method</h6>

            <label class="payment-option">
                <input type="radio" name="payment_method" value="qris" class="form-check-input me-3" required>
                <div class="fs-3 me-3" style="color: #00A5CF;"><i class="fas fa-qrcode"></i></div>
                <div>
                    <h6 class="mb-1 fw-bold" style="color: #4a3228;">QRIS / Online</h6>
                    <small class="text-muted">Supports GoPay, OVO, Dana, ShopeePay</small>
                </div>
            </label>

            <label class="payment-option">
                <input type="radio" name="payment_method" value="cashier" class="form-check-input me-3" required>
                <div class="fs-3 me-3" style="color: #4a3228;"><i class="fas fa-cash-register"></i></div>
                <div>
                    <h6 class="mb-1 fw-bold" style="color: #4a3228;">Pay at Cashier</h6>
                    <small class="text-muted">Pay Cash / Debit at our cashier desk</small>
                </div>
            </label>

            <hr class="my-4" style="border-color: #e6dace;">

            <button type="submit" class="btn w-100 btn-submit-order">
                Place Order Now
            </button>

            <a href="{{ url('/cart') }}" class="d-block text-center mt-4 text-decoration-none btn-cancel-order">
                Cancel & Return to Cart
            </a>
        </form>
    </div>
</div>
@endsection
