{{-- Shared form partial for create & edit product --}}
<div class="row g-4">
    <!-- LEFT: MAIN INFO -->
    <div class="col-lg-8">
        <div class="admin-form-card" style="margin-bottom:1rem;">
            <p class="form-section-title">Informasi Produk</p>

            <div class="mb-3">
                <label class="form-label">Nama Produk *</label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}"
                    class="form-control @error('name') is-invalid @enderror" required>
                @error('name') <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Kategori *</label>
                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                    <option value="">Pilih kategori...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Deskripsi</label>
                <textarea name="description" rows="5" class="form-control @error('description') is-invalid @enderror"
                    placeholder="Deskripsikan produk: bahan, siluet, kecocokan, dll.">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description') <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div> @enderror
            </div>
        </div>

        <!-- PRICING & STOCK -->
        <div class="admin-form-card">
            <p class="form-section-title">Harga & Stok</p>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label">Harga (Rp) *</label>
                    <input type="number" name="price" value="{{ old('price', $product->price ?? '') }}"
                        class="form-control @error('price') is-invalid @enderror"
                        min="0" step="1000" required placeholder="875000">
                    @error('price') <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Stok *</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock ?? 0) }}"
                        class="form-control @error('stock') is-invalid @enderror"
                        min="0" required>
                    @error('stock') <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>
    </div>

    <!-- RIGHT: IMAGE + STATUS -->
    <div class="col-lg-4">
        <!-- IMAGE UPLOAD -->
        <div class="admin-form-card" style="margin-bottom:1rem;">
            <p class="form-section-title">Foto Produk</p>

            @if(isset($product) && $product->image)
                <div style="margin-bottom:1rem;background:#f5f5f5;aspect-ratio:3/4;overflow:hidden;">
                    <img src="{{ asset('storage/' . $product->image) }}" id="img-preview"
                        style="width:100%;height:100%;object-fit:cover;" alt="Current image">
                </div>
            @else
                <div id="img-placeholder" style="background:#f5f5f5;aspect-ratio:3/4;display:flex;flex-direction:column;align-items:center;justify-content:center;margin-bottom:1rem;cursor:pointer;" onclick="document.getElementById('image-input').click()">
                    <i class="bi bi-image" style="font-size:2rem;color:#ccc;margin-bottom:0.5rem;"></i>
                    <p style="font-size:0.7rem;color:var(--muted);margin:0;">Klik untuk upload</p>
                </div>
                <img id="img-preview" style="display:none;width:100%;aspect-ratio:3/4;object-fit:cover;margin-bottom:1rem;" alt="">
            @endif

            <input type="file" name="image" id="image-input" accept="image/*"
                class="form-control @error('image') is-invalid @enderror"
                onchange="previewImage(this)" style="font-size:0.78rem;">
            <p style="font-size:0.68rem;color:var(--muted);margin-top:0.5rem;">JPG, PNG, WEBP. Maks 2MB.</p>
            @error('image') <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div> @enderror
        </div>

        <!-- STATUS -->
        <div class="admin-form-card" style="margin-bottom:1rem;">
            <p class="form-section-title">Status Produk</p>
            <div style="display:flex;align-items:center;gap:0.75rem;">
                <input type="checkbox" name="is_active" id="is_active" value="1"
                    {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}
                    style="accent-color:var(--noir);width:16px;height:16px;">
                <label for="is_active" style="font-size:0.82rem;cursor:pointer;margin:0;">Produk Aktif (ditampilkan di store)</label>
            </div>
        </div>

        <!-- SUBMIT -->
        <button type="submit" class="topbar-btn accent" style="width:100%;padding:0.875rem;font-size:0.72rem;">
            {{ isset($product) ? 'Simpan Perubahan' : 'Tambah Produk' }}
        </button>
        <a href="{{ route('admin.products.index') }}" class="topbar-btn" style="width:100%;display:block;text-align:center;margin-top:0.5rem;padding:0.875rem;font-size:0.72rem;">
            Batal
        </a>
    </div>
</div>

@push('scripts')
<script>
function previewImage(input) {
    const preview = document.getElementById('img-preview');
    const placeholder = document.getElementById('img-placeholder');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endpush
