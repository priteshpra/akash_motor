@extends('layouts.page')
@section('content')
@if (session()->has('response'))
@if (session('response')['status'] === 200)
<p class="text-success"> {{ session('response')['message'] }}</p>
@else
<p class="text-danger"> {{ session('response')['message'] }}</p>
@endif
@endif
<!-- Begin Page Content -->

<div class="container-fluid">

    <div class="row">
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                mb-3">
                        <div>
                            <h4 class="mb-0">Calculate Data</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-briefcase fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">0</h1>
                        <p class="mb-0">
                            <span class="text-dark me-2"><button class="btn btn-info">Details</button></span>
                            <span class="text-dark me-8"></span>

                            {{-- <span class="text-dark me-2"><button class="btn btn-primary">Details</button></span>
                            --}}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                mb-3">
                        <div>
                            <h4 class="mb-0">View Data</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-list-task fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">0</h1>
                        <p class="mb-0">
                            {{-- <span class="text-dark me-2"><button class="btn btn-info">Details</button></span> --}}
                            <span class="text-dark me-8"></span>

                            <span class="text-dark me-2"><button class="btn btn-primary">Details</button></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                mb-3">
                        <div>
                            <h4 class="mb-0">Add Data</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">0</h1>
                        <p class="mb-0">

                            <span class="text-dark me-8"></span>

                            <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#addFormModal">Add</button></span>
                        </p>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-xl-3 col-lg-6 col-md-12 col-12 mt-6">
            <!-- card -->
            <div class="card ">
                <!-- card body -->
                <div class="card-body">
                    <!-- heading -->
                    <div class="d-flex justify-content-between align-items-center
                mb-3">
                        <div>
                            <h4 class="mb-0">Settings</h4>
                        </div>
                        <div class="icon-shape icon-md bg-light-primary text-primary
                  rounded-2">
                            <i class="bi bi-bullseye fs-4"></i>
                        </div>
                    </div>
                    <!-- project number -->
                    <div>
                        <h1 class="fw-bold">0</h1>
                        <p class="mb-0">
                            <span class="text-dark me-12"></span>

                            <span class="text-dark me-2"><a href="{{ route('settings.index') }}"><button
                                        class="btn btn-primary">Go To Setting
                                        Screens</button>
                                </a></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /.container-fluid -->
@php
$products = \App\Models\Product::where('status', '1')->get();
@endphp
<!-- Sub Category Modal -->
<div class="modal fade" id="addFormModal" tabindex="-1" aria-labelledby="addFormModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFormModalLabel">Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="addForm">
                    @csrf
                    <div class="mb-3 text-center">
                        <?php if ($products) {
                            foreach ($products as $key => $value) { ?>
                        <a href="#" data-bs-toggle="modal" class="productClick mt-6" data-bs-target="#catFormModal"
                            data-id='<?php echo $value->id; ?>' data-title='<?php echo $value->product_name; ?>'><button
                                class="btn btn-primary mt-6" style="width: 20%; ">
                                <?php echo $value->product_name; ?>
                            </button>&nbsp;&nbsp;
                        </a>
                        <?php }
                        } ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Product Model END -->
@php
$categorys = \App\Models\Category::select(['categories.id', 'categories.category_name', 'categories.product_id',
'products.product_name', 'products.id as productID', 'categories.created_at'])->leftJoin('products', 'products.id', '=',
'categories.product_id')->get();
$taxs = \App\Models\Tax::where('status','1')->get();
@endphp
<!-- Sub Category Modal -->
<div class="modal fade" id="catFormModal" tabindex="-1" aria-labelledby="catFormModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="catFormModalLabel">Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="catForm">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Select Category</label>
                        <select id="categorys" name="category_id" class="form-control" required>
                            <option value="">Select Category</option>
                            @foreach ($categorys as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="subcategory-container">
                    </div>
                    <input type="hidden" name="product_id" id="product_ids" value="" />
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" checked name="typeOption" id="inlineRadio1"
                                value="Foot">
                            <label class="form-check-label" for="inlineRadio1">Foot</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="typeOption" id="inlineRadio2"
                                value="Flange">
                            <label class="form-check-label" for="inlineRadio2">Flange</label>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check" id="FootvalDiv">
                            <input type="text" class="form-control" id="Footval" name="Footval" required>
                        </div>
                    </div>

                    <div class="mb-3 flangeShow">
                        @if ($taxs->isNotEmpty())
                        @foreach ($taxs as $key => $value)
                        @if ($value->flange != '' || $value->flange !=null)
                        <input type="radio" class="btn-check" name="flange" id="flange{{ $value->flange }}"
                            autocomplete="off" value="{{ $value->flange }}" checked>
                        <label class="btn btn-outline-success" for="flange{{ $value->flange }}">{{ $value->flange
                            }}</label>&nbsp;&nbsp;

                        @endif
                        @endforeach
                        @endif
                    </div>

                    <button type="button" id="resetButton" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Product Model END -->

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
    $('#catForm').on('submit', function(e) {
    e.preventDefault();
    $.ajax({
            url: "{{ route('addform.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                showAlert('success', 'Product added successfully!');
                $('#catForm')[0].reset();
            },
            error: function(error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    })
    document.getElementById('resetButton').addEventListener('click', function() {
        document.getElementById('catForm').reset();
    });
    $('#addForm').on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('product.store') }}", // Replace with your store route
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                showAlert('success', 'Product added successfully!');
                $('#productForm')[0].reset();
                table3.ajax.reload(); // Reload DataTable
            },
            error: function(error) {
                console.error(error);
                // alert('Something went wrong!');
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    });
    $(".flangeShow").css('display', 'none');
    $('.form-check-input').on('click', function(e) {
        if ($(this).val() == 'Flange') {
            $(".flangeShow").css('display', 'block');
            $(".flangeShow").css('margin-left','16px');
            $("#FootvalDiv").css('display', 'none');
            $("#Footval").removeAttr('required');
        } else {
            $(".flangeShow").css('display', 'none');
            $("#FootvalDiv").css('display', 'block');
            $("#Footval").attr('required',true);
        }
    });

    $('.productClick').on('click', function(e) {
        e.preventDefault();
        $('#product-dropdown').html('<option value="">Select Product</option>');
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');
        var product_id = $(this).data('id');
        var product_title = $(this).data('title');
        $("#catFormModalLabel").html(product_title);
        $("#product_ids").val(product_id);
        if (product_id) {
            $.ajax({
                url: '{{ route("get.categorys", "") }}/' + product_id,
                type: 'GET',
                success: function(data) {
                    $('#categorys').html('<option value="">Select Category</option>');
                    $.each(data, function(id, category_name) {

                        $('#categorys').append('<option value="' + id + '">' + category_name + '</option>');
                    });
                },
                error: function(error) {
                    console.error(error);
                    showAlert('danger', 'Something went wrong. Please try again.');
                }
            });
        }
    });

    $('#categorys').change(function() {
        var category_id = $(this).val();
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');

        if (category_id) {
            $.ajax({
                url: '{{ route("get.subcategorys", "") }}/' + category_id,
                type: 'GET',
                success: function(data) {
                    console.log(' - data - ', data);
                    $("#subcategory-container").html('');
                    var newSubcategory = ``;
                    if (data) {
                        $.each(data, function(id, category_name) {
                            newSubcategory = `<div class="mb-3 row">
                                                    <label for="subname" class="col-sm-2 col-form-label "><b>` + category_name + `</b></label>
                                                    <div class="col-sm-10">
                                                        <input type="text" class="form-control" id="subname" name="subcategory_name[]" required>
                                                    </div>
                                                </div>`;
                            $('#subcategory-container').append(newSubcategory);
                        });
                    } else {
                        $('#subcategory-container').append(newSubcategory);
                    }
                }
            });
        }
    });

    function showAlert(type, message) {
        const alertHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        $('.alert-container').html(alertHTML); // Insert alert into container
    }

    $(document).on('click', '.btn-close', function() {
        location.reload(); // Reload the page
    });
</script>
@endsection