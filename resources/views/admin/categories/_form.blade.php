{{-- Shared form partial for category create & edit --}}
<div class="admin-form-card">
    <p class="form-section-title">Detail Kategori</p>

    <div class="mb-3">
        <label class="form-label">Nama Kategori *</label>
        <input type="text" name="name" value="{{ old('name', $category->name ?? '') }}"
            class="form-control @error('name') is-invalid @enderror"
            required placeholder="cth: Wanita, Pria, Aksesoris"
            oninput="generateSlug(this.value)">
        @error('name') <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Slug</label>
        <input type="text" name="slug" id="slug-field" value="{{ old('slug', $category->slug ?? '') }}"
            class="form-control @error('slug') is-invalid @enderror"
            placeholder="akan dibuat otomatis">
        <p style="font-size:0.68rem;color:var(--muted);margin-top:4px;">Digunakan di URL. Hanya huruf kecil, angka, dan tanda hubung.</p>
        @error('slug') <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div> @enderror
    </div>

    <div class="mb-4">
        <label class="form-label">Deskripsi</label>
        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror"
            placeholder="Deskripsi singkat kategori ini">{{ old('description', $category->description ?? '') }}</textarea>
        @error('description') <div class="invalid-feedback" style="font-size:0.72rem;">{{ $message }}</div> @enderror
    </div>

    <div style="display:flex;gap:0.75rem;">
        <button type="submit" class="topbar-btn accent" style="padding:0.75rem 2rem;">
            {{ isset($category) ? 'Simpan Perubahan' : 'Tambah Kategori' }}
        </button>
        <a href="{{ route('admin.categories.index') }}" class="topbar-btn" style="padding:0.75rem 2rem;">Batal</a>
    </div>
</div>

@push('scripts')
<script>
function generateSlug(value) {
    const slug = value.toLowerCase()
        .replace(/[^a-z0-9\s-]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim();
    document.getElementById('slug-field').value = slug;
}
</script>
@endpush
