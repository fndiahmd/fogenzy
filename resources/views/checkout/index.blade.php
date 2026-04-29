@extends('layouts.app')
@section('title', 'Checkout — FOGENZY')

@section('content')
<div class="container-fluid px-4 px-md-5 py-5">
    <div class="row">
        <div class="col-12 mb-4">
            <p style="font-size:0.6rem;letter-spacing:0.25em;text-transform:uppercase;color:var(--accent);">Langkah Terakhir</p>
            <h1 style="font-family:var(--font-display);font-weight:300;font-size:2.5rem;">Checkout</h1>
        </div>
    </div>

    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="row g-5">
            <!-- LEFT: FORM -->
            <div class="col-lg-7">

                <!-- SHIPPING INFO -->
                <div style="margin-bottom:2.5rem;">
                    <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);padding-bottom:0.75rem;margin-bottom:1.5rem;">Informasi Pengiriman</p>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label-noir">Nama Lengkap *</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="form-control-noir w-100">
                            @error('name')<p style="font-size:0.72rem;color:#c0392b;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-noir">Nomor Telepon *</label>
                            <input type="text" name="phone" value="{{ old('phone') }}" required class="form-control-noir w-100" placeholder="08xx xxxx xxxx">
                            @error('phone')<p style="font-size:0.72rem;color:#c0392b;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label-noir">Alamat Lengkap *</label>
                            <textarea name="address" rows="3" required class="form-control-noir w-100" placeholder="Jalan, nomor rumah, RT/RW, kelurahan, kecamatan">{{ old('address') }}</textarea>
                            @error('address')<p style="font-size:0.72rem;color:#c0392b;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-md-8">
                            <label class="form-label-noir">Kota / Kabupaten *</label>
                            <input type="text" name="city" value="{{ old('city') }}" required class="form-control-noir w-100" placeholder="Jakarta Selatan">
                            @error('city')<p style="font-size:0.72rem;color:#c0392b;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label-noir">Kode Pos *</label>
                            <input type="text" name="postal_code" value="{{ old('postal_code') }}" required class="form-control-noir w-100" placeholder="12345">
                            @error('postal_code')<p style="font-size:0.72rem;color:#c0392b;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- PAYMENT METHOD -->
                <div style="margin-bottom:2.5rem;">
                    <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--muted);border-bottom:1px solid var(--border);padding-bottom:0.75rem;margin-bottom:1.5rem;">Metode Pembayaran</p>

                    <div class="d-flex flex-column gap-3">
                        @foreach([
                            ['value' => 'transfer_bank', 'label' => 'Transfer Bank', 'desc' => 'BCA, Mandiri, BNI, BRI'],
                            ['value' => 'e_wallet',      'label' => 'E-Wallet',       'desc' => 'GoPay, OVO, DANA, ShopeePay'],
                            ['value' => 'cod',           'label' => 'COD',             'desc' => 'Bayar di tempat saat barang tiba'],
                        ] as $pm)
                        <label style="display:flex;align-items:flex-start;gap:1rem;padding:1rem 1.25rem;border:1px solid var(--border);cursor:pointer;transition:border-color 0.2s;" class="payment-opt">
                            <input type="radio" name="payment_method" value="{{ $pm['value'] }}" {{ old('payment_method') == $pm['value'] || $pm['value'] == 'transfer_bank' ? 'checked' : '' }} style="accent-color:var(--noir);margin-top:3px;" required>
                            <div>
                                <p style="font-size:0.8rem;font-weight:500;margin:0;">{{ $pm['label'] }}</p>
                                <p style="font-size:0.72rem;color:var(--muted);margin:0;">{{ $pm['desc'] }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('payment_method')<p style="font-size:0.72rem;color:#c0392b;margin-top:8px;">{{ $message }}</p>@enderror
                </div>

                <!-- NOTES -->
                <div style="margin-bottom:2rem;">
                    <label class="form-label-noir">Catatan (opsional)</label>
                    <textarea name="notes" rows="2" class="form-control-noir w-100" placeholder="Instruksi khusus untuk pengiriman...">{{ old('notes') }}</textarea>
                </div>
            </div>

            <!-- RIGHT: ORDER SUMMARY -->
            <div class="col-lg-5">
                <div style="background:#f8f8f6;padding:2rem;position:sticky;top:80px;">
                    <p style="font-size:0.6rem;letter-spacing:0.2em;text-transform:uppercase;margin-bottom:1.5rem;">Ringkasan Pesanan</p>

                    @foreach($carts as $cart)
                    <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:1rem;padding-bottom:1rem;border-bottom:1px solid var(--border);">
                        <div style="flex:1;">
                            <p style="font-size:0.78rem;font-weight:400;margin:0;text-transform:uppercase;letter-spacing:0.04em;">{{ $cart->product->name }}</p>
                            <p style="font-size:0.7rem;color:var(--muted);margin:0;">Qty: {{ $cart->quantity }}</p>
                        </div>
                        <span style="font-family:var(--font-display);font-size:0.95rem;font-weight:600;flex-shrink:0;margin-left:1rem;">
                            Rp {{ number_format($cart->product->price * $cart->quantity, 0, ',', '.') }}
                        </span>
                    </div>
                    @endforeach

                    <div style="display:flex;justify-content:space-between;padding-top:0.75rem;">
                        <span style="font-size:0.65rem;letter-spacing:0.12em;text-transform:uppercase;font-weight:500;">Total</span>
                        <span style="font-family:var(--font-display);font-size:1.5rem;font-weight:600;">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <button type="submit" class="btn-noir" style="width:100%;margin-top:1.5rem;text-align:center;">
                        Konfirmasi Pesanan
                    </button>

                    <p style="font-size:0.65rem;color:var(--muted);text-align:center;margin-top:1rem;line-height:1.6;">
                        Dengan melanjutkan, Anda menyetujui syarat & ketentuan FOGENZY
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
