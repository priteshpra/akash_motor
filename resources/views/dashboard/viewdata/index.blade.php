@extends('layouts.page')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<style>
    .modal-dialog.modal-lg {
        margin-top: 10%;
    }

    a {
        text-decoration: none;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <h1>View List</h1>

        <button id="delete-selected" style="float: inline-end;margin-bottom: 5px;width: 12%;"
            class="btn btn-danger">Delete
            Selected</button>
        <div style="margin-bottom: 10px; margin-left: 58%;">
            <select id="productFilter" class="form-control"
                style="width: 20%; display: inline-block; margin-right: 10px;">
                <option value="">Filter by Product</option>
                @if ($products)
                @foreach ($products as $pro)
                <option value="{{ $pro->id }}">{{ $pro->product_name }}</option>
                @endforeach
                @endif
            </select>

            <select id="categoryFilter" class="form-control"
                style="width: 20%; display: inline-block; margin-right: 10px;">
                <option value="">Filter by Category</option>
                @if ($category)
                @foreach ($category as $cat)
                <option value="{{ $cat->id }}">{{ $cat->category_name }}</option>
                @endforeach
                @endif
            </select>
        </div>
        <table style="width: 100%;" id="viewTable" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th><input type="checkbox" id="select-all"></th>
                    <th>Product Name</th>
                    <th>Category Name</th>
                    <th>Sub-Category Name</th>
                    <th>Sub Cordinates</th>
                    <th>Frame Size</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
</div>
@php
$categorys = \App\Models\Category::select([
'categories.id',
'categories.category_name',
'categories.product_id',
'products.product_name',
'products.id as productID',
'categories.created_at'
])->leftJoin(
'products',
'products.id',
'=',
'categories.product_id'
)->where('categories.status', '1')->get();
$taxs = \App\Models\Tax::where('status', '1')->get();
@endphp
<!-- Edit Form Modal -->
<div class="modal fade" id="editFormModal" tabindex="-1" aria-labelledby="editFormModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editFormModalLabel">Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="catFormEdit">
                    @csrf
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Select Category</label>
                        <select id="categorys_d" name="category_id" class="form-controls form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categorys as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="subcategorys-containers">
                    </div>
                    <input type="hidden" name="product_id" id="product_id_edit" value="" />
                    <div class="" id="">
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="name" class="form-label">Frame Size</label>
                            <input type="text" class="form-controls numericInput sizeVal" id="size_edit" name="size"
                                placeholder="Frame Size" required>
                        </div>
                    </div>
                    <div class="" id="FootvalDiv">
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="name" class="form-label">Price</label>
                            <input type="text" class="form-controls numericInput Footval" id="Footval_edit"
                                name="Footval" placeholder="Price" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" checked name="typeOption[]"
                                id="inlineRadio11" value="Foot">
                            <label class="form-check-label" for="inlineRadio1">Foot</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" name="typeOption[]"
                                id="inlineRadio22" value="Flange">
                            <label class="form-check-label" for="inlineRadio2">Flange</label>
                        </div>
                    </div>

                    <div class="mb-3 flangeShow">
                        @if ($taxs->isNotEmpty())
                        @foreach ($taxs as $key => $value)
                        @if ($value->flange != '' || $value->flange != null)
                        <input type="radio" class="btn-check form-control" placeholder="Price" name="flange_edit"
                            id="flange_edit{{ $value->flange }}" autocomplete="off" value="{{ $value->flange }}">
                        <label class="btn btn-outline-success" for="flange_edit{{ $value->flange }}">{{ $value->flange
                            }}</label>&nbsp;&nbsp;

                        @endif
                        @endforeach
                        @endif
                    </div>

                    <button type="button" class="btn btn-info" data-bs-dismiss="modal" aria-label="Close">Back</button>
                    <button type="button" id="resetButton" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Form Model END -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete the selected items?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteButton">Delete</button>
            </div>
        </div>
    </div>
</div>
<!-- End Confirmation Box -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
    $('#catFormEdit').on('submit', function (e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('addform.update', ':id') }}".replace(':id', window.editId),
            method: "PUT",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            },
            success: function (response) {
                showAlert('success', 'Product updated successfully!');
                table.ajax.reload();
            },
            error: function (error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    })
    function getFormData(ID, PrId) {
        window.editId = ID;
        $("#product_id_edit").val(PrId);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('addform.edit', ':id') }}".replace(':id', ID),
            method: "POST",
            data: {
                ID
            },
            success: function (response) {
                $("#categorys_d").val(response.data.category_id);
                $("#categorys_d").trigger('change');
                var newSubcategory = `<div class="mb-3 row">
                    <input type="hidden" class="form-control" id="subname" name="subcategory_id[]" value='` + response.data.id + `'>
                    <label for="subname" class="col-sm-3 col-form-label "><b>` + response.data.subcategory_name + `</b></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="subname" value="` + response.data.subcategory_val + `"
                            name="subcategory_val[]" required>
                    </div>
                </div>`;
                $('#subcategorys-containers').append(newSubcategory);
                $('.form-check-input').prop('checked', false);
                if (response.data.typeOption == 'Foot') {
                    $('#inlineRadio11').click();
                    $('#inlineRadio11').prop('checked', true);
                } else {
                    $('#inlineRadio22').click();
                    $('#inlineRadio22').prop('checked', true);
                }
                $("#Footval_edit").val(response.data.footval);
                // $("#flange_edit").val(response.data.flange);
                $(".Flangeval").val(response.data.flange_val);
                $("#size_edit").val(response.data.size);
                $('input[name="flange_edit"][value="' + response.data.flange_percentage + '"]').prop('checked', true);
                // console.log(' === response === ', response.data);
                let typeOptionCheckBoc = response.data.typeOption.split(', ');
                console.log(typeOptionCheckBoc);

                $('input[name="typeOption[]"]').prop('checked', false);
                typeOptionCheckBoc.forEach(function (optionCheckbox) {
                    $('input[name="typeOption[]"][value="' + optionCheckbox + '"]').prop('checked', true);
                });

            },
            error: function (error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    }

    function showAlert(type, message) {
        const alertHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        $('.alert-container').html(alertHTML); // Insert alert into container
    }

    $('#select-all').on('click', function () {
        const rows = table.rows({
            'search': 'applied'
        }).nodes();
        $('input[type="checkbox"].select-row', rows).prop('checked', this.checked);
    });

    $('#viewTable tbody').on('change', '.select-row', function () {
        if (!this.checked) {
            $('#select-all').prop('checked', false);
        }
    });

    // Load DataTables for main table
    var table = $('#viewTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('addform.index') }}",
        columns: [{
            data: 'null',
            name: 'id',
            render: function (data, type, row, meta) {
                return `<input type="checkbox" class="select-row" data-id="${row.id}">`;
            },
            orderable: false,
            searchable: false
        },
        {
            data: 'product_name',
            name: 'product_name'
        },
        {
            data: 'category_name',
            name: 'category_name'
        },
        {
            data: 'subcategory_name',
            name: 'subcategory_name'
        },
        {
            data: 'subcategory_val',
            name: 'subcategory_val'
        },
        {
            data: 'size',
            name: 'size'
        },
        {
            data: 'footval',
            name: 'footval'
        },
        {
            data: 'action',
            name: 'action',
            orderable: false,
            searchable: false
        } // Action column
        ]
    });
    // Event listeners for filter dropdowns
    $('#productFilter, #categoryFilter').on('change', function () {
        table.draw();
    });
    const selectedIds = [];
    // Handle form submission
    $('#delete-selected').on('click', function () {
        $('#deleteConfirmationModal').modal('show'); // Show the modal
    });

    $('#confirmDeleteButton').on('click', function () {
        table.$('input[type="checkbox"].select-row:checked').each(function () {
            selectedIds.push($(this).data('id'));
        });
        // Hide the modal
        $('#deleteConfirmationModal').modal('hide');

        // Perform AJAX request to delete items
        if (selectedIds.length > 0) {
            $.ajax({
                url: "{{ route('addform.massDelete') }}",
                type: 'POST',
                data: {
                    ids: selectedIds,
                    _token: '{{ csrf_token() }}' // Include CSRF token
                },
                success: function (response) {
                    table.ajax.reload(); // Reload table data
                    showAlert('success', 'Selected products deleted successfully!');
                },
                error: function (xhr) {
                    showAlert('danger', 'Failed to delete selected items.');
                }
            });
        }
    });
</script>
</div>
@endsection