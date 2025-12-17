@extends('pos.layout')

@section('title', 'Categories')

@section('content')
<div class="categories-container">
    <!-- Header Section -->
    <div class="categories-header">
        <div>
            <h1 class="categories-title">Categories</h1>
            <p class="categories-subtitle">Organize your products into categories</p>
        </div>
        <button type="button" class="btn-add-category" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M10 4V16M4 10H16" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            Add Category
        </button>
    </div>

    <!-- Categories Grid -->
    <div class="categories-grid">
        @forelse($categories as $category)
        <div class="category-card">
            <div class="category-icon" style="background-color: {{ $category->color }};">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M20 7L12 3L4 7M20 7L12 11M20 7V17L12 21M12 11L4 7M12 11V21M4 7V17L12 21" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="category-content">
                <h3 class="category-name">{{ $category->name }}</h3>
                <p class="category-description">{{ $category->description }}</p>
            </div>
            <button type="button" class="btn-edit-category" data-id="{{ $category->id }}" 
                    data-name="{{ $category->name }}" 
                    data-description="{{ $category->description }}" 
                    data-color="{{ $category->color }}">
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8.25 3H3C2.44772 3 2 3.44772 2 4V15C2 15.5523 2.44772 16 3 16H14C14.5523 16 15 15.5523 15 15V9.75M13.5 2.25L15.75 4.5M7.5 10.5L15.75 2.25L13.5 2.25" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
        </div>
        @empty
        <div class="empty-state">
            <p>No categories yet. Click "Add Category" to create one.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Add/Edit Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('categories.store') }}" method="POST" id="categoryForm">
                @csrf
                <input type="hidden" name="_method" value="POST" id="formMethod">
                <input type="hidden" name="id" id="categoryId">
                
                <div class="modal-body">
                    <!-- Name Field -->
                    <div class="form-group">
                        <label for="categoryName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="categoryName" name="name" required>
                    </div>

                    <!-- Description Field -->
                    <div class="form-group">
                        <label for="categoryDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="categoryDescription" name="description" rows="3"></textarea>
                    </div>

                    <!-- Color Field -->
                    <div class="form-group">
                        <label for="categoryColor" class="form-label">Color</label>
                        <div class="color-picker-wrapper">
                            <div class="color-preview" id="colorPreview"></div>
                            <input type="text" class="form-control" id="categoryColor" name="color" value="#6366f1" required>
                        </div>
                        
                        <!-- Color Palette -->
                        <div class="color-palette">
                            <button type="button" class="color-option" data-color="#3b82f6" style="background-color: #3b82f6;"></button>
                            <button type="button" class="color-option" data-color="#8b5cf6" style="background-color: #8b5cf6;"></button>
                            <button type="button" class="color-option" data-color="#ef4444" style="background-color: #ef4444;"></button>
                            <button type="button" class="color-option" data-color="#10b981" style="background-color: #10b981;"></button>
                            <button type="button" class="color-option" data-color="#f59e0b" style="background-color: #f59e0b;"></button>
                            <button type="button" class="color-option" data-color="#6366f1" style="background-color: #6366f1;"></button>
                            <button type="button" class="color-option" data-color="#ec4899" style="background-color: #ec4899;"></button>
                            <button type="button" class="color-option" data-color="#14b8a6" style="background-color: #14b8a6;"></button>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn-create">Create</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
/* Container Styles */
.categories-container {
    padding: 2rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Header Styles */
.categories-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 2rem;
}

.categories-title {
    font-size: 2rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.5rem 0;
}

.categories-subtitle {
    font-size: 0.95rem;
    color: #6b7280;
    margin: 0;
}

.btn-add-category {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    background-color: #059669;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-add-category:hover {
    background-color: #047857;
}

/* Categories Grid */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(400px, 1fr));
    gap: 1.5rem;
}

/* Category Card */
.category-card {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 0.75rem;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    position: relative;
    transition: box-shadow 0.2s;
}

.category-card:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.category-icon {
    width: 48px;
    height: 48px;
    border-radius: 0.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.category-content {
    flex: 1;
}

.category-name {
    font-size: 1rem;
    font-weight: 600;
    color: #1f2937;
    margin: 0 0 0.25rem 0;
}

.category-description {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0;
}

.btn-edit-category {
    background: transparent;
    border: none;
    color: #6b7280;
    padding: 0.5rem;
    cursor: pointer;
    border-radius: 0.375rem;
    transition: all 0.2s;
}

.btn-edit-category:hover {
    background-color: #f3f4f6;
    color: #1f2937;
}

/* Modal Styles */
.modal-content {
    border-radius: 0.75rem;
    border: none;
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

.modal-header {
    padding: 1.5rem;
    border-bottom: 1px solid #e5e7eb;
}

.modal-title {
    font-size: 1.25rem;
    font-weight: 600;
    color: #1f2937;
}

.btn-close {
    opacity: 0.5;
}

.btn-close:hover {
    opacity: 1;
}

.modal-body {
    padding: 1.5rem;
}

.modal-footer {
    padding: 1.5rem;
    border-top: none;
}

/* Form Styles */
.form-group {
    margin-bottom: 1.25rem;
}

.form-label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

.form-control {
    width: 100%;
    padding: 0.625rem 0.875rem;
    border: 1.5px solid #d1d5db;
    border-radius: 0.5rem;
    font-size: 0.95rem;
    transition: border-color 0.2s;
}

.form-control:focus {
    outline: none;
    border-color: #059669;
    box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
}

textarea.form-control {
    resize: vertical;
    min-height: 80px;
}

/* Color Picker */
.color-picker-wrapper {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.color-preview {
    width: 40px;
    height: 40px;
    border-radius: 0.375rem;
    background-color: #6366f1;
    border: 2px solid #e5e7eb;
    flex-shrink: 0;
}

.color-palette {
    display: flex;
    gap: 0.5rem;
    margin-top: 0.75rem;
    flex-wrap: wrap;
}

.color-option {
    width: 36px;
    height: 36px;
    border-radius: 0.375rem;
    border: 2px solid transparent;
    cursor: pointer;
    transition: all 0.2s;
}

.color-option:hover {
    transform: scale(1.1);
    border-color: #1f2937;
}

.color-option.active {
    border-color: #1f2937;
    box-shadow: 0 0 0 2px white, 0 0 0 4px #1f2937;
}

/* Create Button */
.btn-create {
    width: 100%;
    background-color: #059669;
    color: white;
    border: none;
    padding: 0.75rem 1.5rem;
    border-radius: 0.5rem;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-create:hover {
    background-color: #047857;
}

/* Empty State */
.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    color: #6b7280;
}

/* Responsive Design */
@media (max-width: 768px) {
    .categories-grid {
        grid-template-columns: 1fr;
    }
    
    .categories-header {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .btn-add-category {
        justify-content: center;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('addCategoryModal');
    const form = document.getElementById('categoryForm');
    const modalTitle = document.getElementById('addCategoryModalLabel');
    const formMethod = document.getElementById('formMethod');
    const categoryIdInput = document.getElementById('categoryId');
    const colorInput = document.getElementById('categoryColor');
    const colorPreview = document.getElementById('colorPreview');
    const colorOptions = document.querySelectorAll('.color-option');
    
    // Update color preview when input changes
    colorInput.addEventListener('input', function() {
        updateColorPreview(this.value);
    });
    
    // Color palette selection
    colorOptions.forEach(option => {
        option.addEventListener('click', function() {
            const color = this.dataset.color;
            colorInput.value = color;
            updateColorPreview(color);
            
            // Update active state
            colorOptions.forEach(opt => opt.classList.remove('active'));
            this.classList.add('active');
        });
    });
    
    // Initialize color preview
    updateColorPreview(colorInput.value);
    
    function updateColorPreview(color) {
        colorPreview.style.backgroundColor = color;
        
        // Update active color option
        colorOptions.forEach(option => {
            if (option.dataset.color === color) {
                option.classList.add('active');
            } else {
                option.classList.remove('active');
            }
        });
    }
    
    // Reset modal on close
    modal.addEventListener('hidden.bs.modal', function() {
        form.reset();
        modalTitle.textContent = 'Add Category';
        formMethod.value = 'POST';
        categoryIdInput.value = '';
        form.action = '{{ route("categories.store") }}';
        updateColorPreview('#6366f1');
    });
    
    // Edit category buttons
    document.querySelectorAll('.btn-edit-category').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.dataset.id;
            const name = this.dataset.name;
            const description = this.dataset.description;
            const color = this.dataset.color;
            
            // Update modal
            modalTitle.textContent = 'Edit Category';
            formMethod.value = 'PUT';
            categoryIdInput.value = id;
            form.action = `/categories/${id}`;
            
            // Populate form
            document.getElementById('categoryName').value = name;
            document.getElementById('categoryDescription').value = description;
            document.getElementById('categoryColor').value = color;
            updateColorPreview(color);
            
            // Show modal
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();
        });
    });
});
</script>
@endsection