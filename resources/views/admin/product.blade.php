@extends('layouts.app')
@section('title', 'Product')
@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Product </h4>
                        </div>
                        <div class="container">
                            <br>
                            <div
                                class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3 mx-3">
                                <form id="searchForm" method="GET" action="{{ route('product.index') }}"
                                    class="mb-3 mb-md-0">
                                    @csrf
                                    <div class="input-group">
                                        <input type="text" name="search" value="{{ $search }}"
                                            class="form-control" placeholder="Search...">
                                        <select name="is_active" class="form-select ms-2">
                                            <option value="">All Status</option>
                                            <option value="1" {{ $isActive == '1' ? 'selected' : '' }}>Active</option>
                                            <option value="0" {{ $isActive == '0' ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                        <button class="btn btn-primary ms-2" type="submit">
                                            <i class="fa fa-search"></i> Search
                                        </button>
                                    </div>
                                </form>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#createProductModal">
                                    <i class="fa fa-plus"></i> Add Product
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="results" class="table-responsive">
                                <table class="display table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>berat</th>
                                            <th>Foto</th>
                                            <th>Is Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Name</th>
                                            <th>Price</th>
                                            <th>berat</th>
                                            <th>Foto</th>
                                            <th>Is Active</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @if ($products->isEmpty())
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak Ada Produk Untuk Ditampilkan
                                                </td>
                                            </tr>
                                        @else
                                            @foreach ($products as $product)
                                                <tr>
                                                    <td>{{ $product->name }}</td>
                                                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                                    <td>{{ $product->berat }} gram</td>
                                                    <td>
                                                        <button type="button" class="btn btn-secondary btn-sm"
                                                            data-toggle="modal"
                                                            data-target="#imageModal-{{ $product->id }}">
                                                            Image and Desc
                                                        </button>
                                                    </td>
                                                    <td>{{ $product->is_active ? 'Active' : 'Inactive' }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-warning"
                                                            data-toggle="modal"
                                                            data-target="#editProductModal{{ $product->id }}">
                                                            Edit
                                                        </button>
                                                        <button class="btn btn-sm btn-danger"
                                                            onclick="confirmDelete({{ $product->id }})">Delete</button>
                                                        <form id="delete-form-{{ $product->id }}"
                                                            action="{{ route('product.destroy', $product->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                                <nav aria-label="Page navigation">
                                    <ul class="pagination justify-content-center mt-3">
                                        @if ($products->onFirstPage())
                                            <li class="page-item disabled">
                                                <span class="page-link">Previous</span>
                                            </li>
                                        @else
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $products->previousPageUrl() }}&search={{ $search }}&is_active={{ $isActive }}">Previous</a>
                                            </li>
                                        @endif

                                        @for ($i = 1; $i <= $products->lastPage(); $i++)
                                            <li class="page-item {{ $i == $products->currentPage() ? 'active' : '' }}">
                                                <a class="page-link"
                                                    href="{{ $products->url($i) }}&search={{ $search }}&is_active={{ $isActive }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        @if ($products->hasMorePages())
                                            <li class="page-item">
                                                <a class="page-link"
                                                    href="{{ $products->nextPageUrl() }}&search={{ $search }}&is_active={{ $isActive }}">Next</a>
                                            </li>
                                        @else
                                            <li class="page-item disabled">
                                                <span class="page-link">Next</span>
                                            </li>
                                        @endif
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create -->
    <div class="modal fade" id="createProductModal" tabindex="-1" role="dialog" aria-labelledby="createProductModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('product.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="createProductModalLabel">Add New Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price_display" required
                                oninput="formatRupiah(this)">
                            <input type="hidden" id="price" name="price">
                        </div>
                        <div class="form-group">
                            <label for="berat">Berat (gram)</label>
                            <input type="number" class="form-control" id="berat" name="berat" required>
                        </div>
                        <div class="form-group">
                            <label for="foto">Photo</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*"
                                onchange="previewImage(event)">
                            <img id="photoPreview" src="" alt="Image Preview"
                                style="display: none; margin-top: 10px; max-width: 100%;" />
                        </div>
                        <div class="form-group">
                            <label for="is_active">Status</label>
                            <select class="form-control" id="is_active" name="is_active" required>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($products as $product)
        <!-- Modal Edit -->
        <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <form method="POST" action="{{ route('product.update', $product->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Edit Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="name{{ $product->id }}">Name</label>
                                <input type="text" class="form-control" id="name{{ $product->id }}" name="name"
                                    value="{{ $product->name }}" required>
                            </div>
                            <div class="form-group">
                                <label for="description{{ $product->id }}">Description</label>
                                <textarea class="form-control" id="description{{ $product->id }}" name="description" required>{{ $product->description }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="price_display{{ $product->id }}">Price</label>
                                <input type="text" class="form-control" id="price_display{{ $product->id }}"
                                    name="price_display" value="Rp {{ number_format($product->price, 0, ',', '.') }}"
                                    required oninput="formatRupiah(this)">
                            </div>
                            <div class="form-group">
                                <label for="berat{{ $product->id }}">Berat (gram)</label>
                                <input type="number" class="form-control" id="berat{{ $product->id }}" name="berat"
                                    value="{{ $product->berat }}" required>
                            </div>
                            <div class="form-group">
                                <label for="foto{{ $product->id }}">Photo</label>
                                <input type="file" class="form-control" id="foto{{ $product->id }}" name="foto"
                                    accept="image/*" onchange="previewImage(event, '{{ $product->id }}')">
                                @if ($product->foto)
                                    <small class="form-text text-muted">
                                        Current File: {{ basename($product->foto) }}
                                    </small>
                                @endif
                                <img id="photoPreview{{ $product->id }}"
                                    src="{{ $product->foto ? asset('foto/product/' . $product->foto) : '' }}"
                                    alt="Image Preview"
                                    style="display: {{ $product->foto ? 'block' : 'none' }}; margin-top: 10px; max-width: 100%;" />
                            </div>
                            <div class="form-group">
                                <label for="is_active{{ $product->id }}">Status</label>
                                <select class="form-control" id="is_active{{ $product->id }}" name="is_active"
                                    required>
                                    <option value="1" {{ $product->is_active ? 'selected' : '' }}>Active</option>
                                    <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Image -->
        <div class="modal fade" id="imageModal-{{ $product->id }}" tabindex="-1" role="dialog"
            aria-labelledby="imageModalLabel-{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="imageModalLabel-{{ $product->id }}">{{ $product->name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body text-center">
                        @if ($product->foto)
                            <img src="{{ asset('foto/product/' . $product->foto) }}" alt="{{ $product->name }}"
                                class="img-fluid mb-3" style="max-width: 100%; height: auto; max-height: 300px;">
                        @else
                            <p class="text-muted">No image available</p>
                        @endif
                        <div class="mt-3">
                            <h6>Description:</h6>
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    timer: 3000,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    <script>
        function formatRupiah(element) {
            // Remove non-digit characters except comma
            let value = element.value.replace(/[^,\d]/g, '').toString();
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            element.value = 'Rp ' + rupiah;

            // Get the ID from the element for edit form
            let id = element.id.replace('price_display', '');

            // If this is the create form (no ID)
            if (id === '') {
                document.getElementById('price').value = value.replace(/[^,\d]/g, '');
            }
        }

        function previewImage(event, id = '') {
            const file = event.target.files[0];
            const reader = new FileReader();
            const photoPreview = document.getElementById('photoPreview' + id);

            if (photoPreview) {
                if (file) {
                    reader.onload = function(e) {
                        photoPreview.src = e.target.result;
                        photoPreview.style.display = 'block';
                    };
                    reader.readAsDataURL(file);
                } else {
                    photoPreview.src = '';
                    photoPreview.style.display = 'none';
                }
            }
        }

        function confirmDelete(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        }

        // Optional: Initialize DataTable if you're using it
        $(document).ready(function() {
            $('.table').DataTable({
                "pageLength": 10,
                "ordering": true,
                "info": true,
                "responsive": true,
                "dom": '<"top"f>rt<"bottom"lip><"clear">',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search..."
                }
            });
        });

        // Handle file input change
        document.querySelectorAll('input[type="file"]').forEach(function(input) {
            input.addEventListener('change', function() {
                const fileName = this.files[0]?.name;
                const fileSize = this.files[0]?.size;
                const maxSize = 2 * 1024 * 1024; // 2MB

                if (fileSize > maxSize) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File too large',
                        text: 'Please select a file smaller than 2MB'
                    });
                    this.value = '';
                    return false;
                }

                const fileExtension = fileName?.split('.').pop().toLowerCase();
                const allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (!allowedExtensions.includes(fileExtension)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid file type',
                        text: 'Please select a valid image file (JPG, JPEG, PNG, GIF)'
                    });
                    this.value = '';
                    return false;
                }
            });
        });

        // Optional: Add form validation
        document.querySelectorAll('form').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;

                requiredFields.forEach(function(field) {
                    if (!field.value) {
                        isValid = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!isValid) {
                    event.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please fill in all required fields'
                    });
                }
            });
        });
    </script>
@endsection
