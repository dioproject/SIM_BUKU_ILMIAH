# Design Improvement Plan — SIM BUKU ILMIAH

## Masalah Utama

1. **Assignment UI berantakan** — Form penugasan author/reviewer inline di dalam tabel, bercampur dengan tombol detail
2. **Tampilan kurang menarik** — Tabel biasa tanpa visual hierarchy yang baik
3. **Status badge tidak konsisten** — Duplikasi logika badge di banyak view, tidak pakai component
4. **Tidak ada reuse** — Form layout, flash message, status badge copy-paste di mana-mana

---

## Solusi yang Direncanakan

### Terminologi UI

- Gunakan istilah **Reviewer** secara konsisten di UI, dokumentasi desain, dan label tabel.
- Jangan gunakan padanan lain untuk role tersebut.
- Gunakan istilah **Author** untuk role penulis jika mengikuti nama role database saat ini.

### 1. Pisahkan Assignment dari Detail

**Sekarang:**
```
| No | Bab | Author | Reviewer | Status | Aksi |
|----|-----|--------|----------|--------|------|
| 1  | Bab 1 | [dropdown author] [dropdown reviewer] [save] [detail] |
```

**Setelah:**
```
| No | Bab | Author | Reviewer | Status | Aksi |
|----|-----|--------|----------|--------|------|
| 1  | Bab 1 | Ahmad | Budi | Ditugaskan | [Assign] [Detail] |
```

- Tabel hanya menampilkan data (read-only)
- Tombol **[Assign]** buka **modal** untuk assign author/reviewer
- Tombol **[Detail]** tetap ke halaman detail chapter
- Lebih rapi, lebih intuitif

### 2. Gunakan Modal untuk Assignment

Modal Bootstrap 4 dengan:
- Dropdown **Select2** untuk author dan reviewer (searchable)
- Info bab yang akan di-assign
- Tombol **Simpan** dan **Batal**
- Loading state saat submit

### 3. Buat Blade Components

Untuk reuse di semua halaman:

| Component | Fungsi |
|-----------|--------|
| `<x-status-badge :status="$status" />` | Badge status dengan warna otomatis |
| `<x-flash-message />` | Alert success/error |
| `<x-admin.table>` | Wrapper tabel dengan header, search, pagination |
| `<x-admin.card>` | Card wrapper dengan header/body |
| `<x-admin.form-field>` | Form horizontal layout |

### 4. Status Badge Colors

Berdasarkan `StatusHelper::getStatusBadgeClass()`:

| Status | Color | Icon |
|--------|-------|------|
| Draft | `badge-secondary` | `fa-file` |
| Tersedia | `badge-primary` | `fa-check-circle` |
| Ditugaskan | `badge-info` | `fa-user-check` |
| Dikirim Author | `badge-warning` | `fa-upload` |
| Dalam Review | `badge-primary` | `fa-search` |
| Revisi | `badge-danger` | `fa-exclamation-triangle` |
| Direvisi | `badge-warning` | `fa-redo` |
| Disetujui | `badge-success` | `fa-check-double` |
| Finalisasi | `badge-dark` | `fa-book` |
| Terbit | `badge-success` | `fa-globe` |

### 5. Dashboard Cards

Gunakan cards yang lebih menarik:
- Icon background dengan gradient
- Angka besar untuk statistik
- Label kecil di bawah
- Card hover effect

### 6. Tabel yang Lebih Baik

- **Striped rows** untuk alternating color
- **Hover effect** pada row
- **Status badge** dengan icon
- **Action buttons** dengan icon dan tooltip
- **Responsive** untuk mobile

---

## File yang Perlu Diubah

### New Files (Components)
1. `resources/views/components/status-badge.blade.php`
2. `resources/views/components/flash-message.blade.php`
3. `resources/views/components/admin/card.blade.php`
4. `resources/views/components/admin/table.blade.php`
5. `resources/views/components/admin/form-field.blade.php`

### Updated Views
1. `resources/views/pages/admin/books/show.blade.php` — Assignment modal
2. `resources/views/pages/admin/chapters/index.blade.php` — Use components
3. `resources/views/pages/admin/books/index.blade.php` — Better table
4. `resources/views/pages/author/books/show.blade.php` — Use components
5. `resources/views/pages/reviewer/books/show.blade.php` — Use components

### Controller Updates
1. `app/Http/Controllers/admin/BookController.php` — Add AJAX endpoint for assignment

---

## Implementation Steps

### Phase 1: Blade Components
1. Create `status-badge` component
2. Create `flash-message` component
3. Create `admin/card` component
4. Create `admin/table` component
5. Create `admin/form-field` component

### Phase 2: Assignment Modal
1. Add modal HTML to books/show.blade.php
2. Add Select2 for author/reviewer dropdowns
3. Add AJAX submission endpoint
4. Add loading state and success/error handling
5. Remove inline forms from table

### Phase 3: View Improvements
1. Update all views to use new components
2. Improve table styling (striped, hover)
3. Add proper spacing and typography
4. Improve mobile responsiveness

### Phase 4: Dashboard Enhancement
1. Redesign stat cards with gradient icons
2. Add welcome message with user info
3. Improve chart styling

---

## Contoh Implementasi

### Status Badge Component
```blade
{{-- resources/views/components/status-badge.blade.php --}}
@props(['status'])

@php
    $class = match($status->id) {
        1 => 'badge-secondary',
        2 => 'badge-primary',
        3 => 'badge-success',
        4 => 'badge-info',
        5 => 'badge-danger',
        6 => 'badge-primary',
        7 => 'badge-warning',
        8 => 'badge-warning',
        9 => 'badge-dark',
        10 => 'badge-success',
        default => 'badge-secondary'
    };
@endphp

<span class="badge {{ $class }}">
    <i class="fas fa-{{ match($status->id) {
        1 => 'file',
        2 => 'check-circle',
        3 => 'check-double',
        4 => 'user-check',
        5 => 'exclamation-triangle',
        6 => 'search',
        7 => 'upload',
        8 => 'redo',
        9 => 'book',
        10 => 'globe',
        default => 'circle'
    }}"></i>
    {{ $status->option }}
</span>
```

### Assignment Modal
```blade
{{-- Modal untuk assign author/reviewer --}}
<div class="modal fade" id="assignModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Penugasan Bab</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="assignForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label>Bab: <strong id="assignChapterName"></strong></label>
                        <input type="hidden" name="chapter_id" id="assignChapterId">
                    </div>
                    <div class="form-group">
                        <label>Author <span class="text-danger">*</span></label>
                        <select name="author_id" id="assignAuthor" class="form-control select2" required>
                            <option value="">Pilih Author</option>
                            @foreach ($authors as $author)
                                <option value="{{ $author->id }}">{{ $author->username }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Reviewer</label>
                        <select name="reviewer_id" id="assignReviewer" class="form-control select2">
                            <option value="">Pilih Reviewer</option>
                            @foreach ($reviewers as $reviewer)
                                <option value="{{ $reviewer->id }}">{{ $reviewer->username }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="far fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
```

### Improved Table Row
```blade
<tr>
    <td>{{ $key + 1 }}</td>
    <td>{{ $bab->nama }}</td>
    <td>{{ $bab->author->username ?? '-' }}</td>
    <td>{{ $bab->reviewer->username ?? '-' }}</td>
    <td><x-status-badge :status="$bab->status" /></td>
    <td>
        <button class="btn btn-info btn-sm" data-toggle="tooltip" title="Assign"
            onclick="openAssignModal({{ $bab->id }}, '{{ $bab->nama }}', {{ $bab->author_id ?? 'null' }}, {{ $bab->reviewer_id ?? 'null' }})">
            <i class="fas fa-user-edit"></i>
        </button>
        <a class="btn btn-success btn-sm" data-toggle="tooltip" title="Detail"
            href="{{ route('admin.show.chapter', $bab->id) }}">
            <i class="fas fa-list"></i>
        </a>
    </td>
</tr>
```

---

## CSS Custom (Minimal)

```css
/* Tabel styling */
.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05);
}

/* Status badge spacing */
.badge {
    font-size: 0.85em;
    padding: 0.4em 0.6em;
}

/* Action buttons spacing */
.btn-sm + .btn-sm {
    margin-left: 4px;
}

/* Card hover effect */
.card-statistic-1:hover {
    transform: translateY(-2px);
    transition: transform 0.2s ease;
}

/* Modal form styling */
.modal-body .form-group:last-child {
    margin-bottom: 0;
}
```

---

## Hasil Akhir

### Sebelum:
- Tabel dengan form inline yang berantakan
- Dropdown native yang tidak menarik
- Status badge duplikasi di mana-mana
- Tidak ada component reuse

### Setelah:
- Tabel rapi hanya data, aksi di modal
- Dropdown Select2 yang searchable dan modern
- Status badge konsisten via component
- Flash message via component
- Form layout via component
- Lebih mudah maintain, lebih user-friendly
