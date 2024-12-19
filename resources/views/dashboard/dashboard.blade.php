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
<style>
    a.productClick.mt-6 {
        text-decoration: none;
    }

    .col-sm-9 {
        width: 71%;
        margin-left: 4%;
    }

    @media (min-width: 576px) {
        .col-sm-9 {
            width: 71% !important;
            margin-left: 4% !important;
        }
    }
</style>
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
                            <span class="text-dark me-2"><button class="btn btn-info" data-bs-toggle="modal"
                                    data-bs-target="#calculateModal">Details</button></span>
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

                            <span class="text-dark me-2"><button class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#viewModal">Details</button></span>
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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
@php
$products = \App\Models\Product::where('status', '1')->get();
@endphp
<!-- Add Form Modal -->
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
<!-- Add Form END -->

@php
$categorys = \App\Models\Category::select(['categories.id', 'categories.category_name', 'categories.product_id',
'products.product_name', 'products.id as productID', 'categories.created_at'])->leftJoin('products', 'products.id', '=',
'categories.product_id')->where('categories.status','1')->get();
$taxs = \App\Models\Tax::where('status','1')->get();
@endphp
<!-- Sub Category Modal -->
<div class="modal fade" id="catFormModal" tabindex="-1" aria-labelledby="catFormModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title catFormModalLabel" id="catFormModalLabel">Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="catForm">
                    @csrf
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Select Category</label>
                        <select id="categorys" name="category_id" class="form-controls form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categorys as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="subcategory-container">
                    </div>
                    <input type="hidden" name="product_id" id="product_ids" value="" />
                    <div class="" id="">
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="name" class="form-label">Frame Size</label>
                            <input type="text" class="form-controls numericInput Footval" id="size" name="size"
                                placeholder="Frame Size" required>
                        </div>
                    </div>
                    <div class="" id="FootvalDiv">
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="name" class="form-label">Price</label>
                            <input type="text" class="form-controls numericInput Footval" id="Footval" name="Footval"
                                placeholder="Price" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" checked name="typeOption[]"
                                id="inlineRadio1" value="Foot">
                            <label class="form-check-label" for="inlineRadio1">Foot</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" name="typeOption[]"
                                id="inlineRadio2" value="Flange">
                            <label class="form-check-label" for="inlineRadio2">Flange</label>
                        </div>
                    </div>

                    <div class="mb-3 flangeShow">
                        @if ($taxs->isNotEmpty())
                        @foreach ($taxs as $key => $value)
                        @if ($value->flange != '' || $value->flange !=null)
                        <input type="radio" class="btn-check form-control" placeholder="Price" name="flange"
                            id="flange{{ $value->flange }}" autocomplete="off" value="{{ $value->flange }}" checked>
                        <label class="btn btn-outline-success" for="flange{{ $value->flange }}">{{ $value->flange
                            }}</label>&nbsp;&nbsp;

                        @endif
                        @endforeach
                        @endif
                    </div>
                    <!-- <div class="FlangevalDiv" id="FlangevalDiv">
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="name" class="form-label">Price</label>
                            <input type="text" class="form-controls numericInput Flangeval" id="Flangeval"
                                name="Flangeval" placeholder="Price" required>
                        </div>
                    </div> -->



                    <button type="button" id="resetButton" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Product Model END -->

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
                            <input type="text" class="form-controls numericInput Footval" id="Footval_edit" name="Footval"
                                placeholder="Price" required>
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
                        @if ($value->flange != '' || $value->flange !=null)
                        <input type="radio" class="btn-check form-control" placeholder="Price" name="flange_edit"
                            id="flange_edit{{ $value->flange }}" autocomplete="off" value="{{ $value->flange }}">
                        <label class="btn btn-outline-success" for="flange_edit{{ $value->flange }}">{{ $value->flange
                            }}</label>&nbsp;&nbsp;

                        @endif
                        @endforeach
                        @endif
                    </div>


                    <button type="button" id="resetButton" class="btn btn-secondary">Reset</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Edit Form Model END -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- View Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewModalLabel">View Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <button id="delete-selected" style="float: inline-end;margin-bottom: 5px;" class="btn btn-danger">Delete Selected</button>
                <h6>View List</h6>
                <table style="width: 100%;" id="viewTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all"></th>
                            <th>Product Name</th>
                            <th>Category Name</th>
                            <th>Sub-Category Name</th>
                            <th>Sub Cordinates</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- View Model END -->

<!-- Calculate Modal -->
<div class="modal fade" id="calculateModal" tabindex="-1" aria-labelledby="calculateModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="calculateModalLabel">Products</h5>
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
                                <a href="#" data-bs-toggle="modal" class="productClick mt-6" data-bs-target="#calFormModal"
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
<!-- Calculate Model END -->

<!-- Calculate Form Modal -->
<div class="modal fade" id="calFormModal" tabindex="-1" aria-labelledby="calFormModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title catFormModalLabel" id="catFormModalLabel">Products</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="alert-container">
                    <!-- Alerts will be dynamically inserted here -->
                </div>
                <form id="calForm">
                    @csrf
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Select Category</label>
                        <select id="category_cal" name="category_id" class="form-controls form-select" required>
                            <option value="">Select Category</option>
                            @foreach ($categorys as $category)
                            <option value="{{$category->id}}">{{$category->category_name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="subcategorycal-containercal">
                    </div>
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Frame Size</label>
                        <div class="col-sm-9">
                            <input type="text" class="frameOriginal numericInput form-control" readonly name="frame"
                                value="">
                        </div>
                    </div>
                    <!-- <div id="subcategorycordinate">
                    </div> -->
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Price</label>
                        <div class="col-sm-9">
                            <input type="text" class="priceOriginal form-control" readonly name="price" value="">
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" checked name="typeOption[]"
                                id="inlineRadio1" value="Foot">
                            <label class="form-check-label" for="inlineRadio1">Foot</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input toggleRadio" type="checkbox" name="typeOption[]"
                                id="inlineRadio2" value="Flange">
                            <label class="form-check-label" for="inlineRadio2">Flange</label>
                        </div>
                    </div>
                    <div class="flangePerShow flangeShow">
                        @if ($taxs->isNotEmpty())
                        <div class="mb-33 d-flex justify-content-between">
                            <label for="name" class="form-label">Flange ( <span id="bracketFlangeVal"></span> )</label>
                            <div class=" col-sm-9">
                                <span class="calFlangePrice"></span>
                                <!-- @foreach ($taxs as $key => $value)
                                @if ($value->flange != '' || $value->flange !=null)
                                <button class="btn btn-flange">{{ $value->flange }}</button>
                                @endif
                                @endforeach -->
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- <div class="mb-3 flangeShow">
                        @if ($taxs->isNotEmpty())
                        @foreach ($taxs as $key => $value)
                        @if ($value->flange != '' || $value->flange !=null)
                        <input type="radio" class="btn-check form-control flangePerc" placeholder="Price" name="flange"
                            id="flanges{{ $value->flange }}" autocomplete="off" value="{{ $value->flange }}">
                        <label class="btn btn-outline-success" for="flanges{{ $value->flange }}">{{ $value->flange
                            }}</label>&nbsp;&nbsp;

                        @endif
                        @endforeach
                        @endif
                    </div> -->
                    <div class="">

                        <div class="mb-3 d-flex justify-content-between">
                            @if ($taxs->isNotEmpty())
                            <label for="name" class="form-label">Additional Tax</label>
                            <div class="col-sm-9">
                                @foreach ($taxs as $key => $value)
                                @if ($value->tax != '' || $value->tax !=null)
                                <?php $no = $key + 1; ?>
                                <!-- <div class="col-sm-9">
                                <label for="name" class="form-label">{{ $value->tax }}</label>
                            </div> -->
                                <input type="radio" class="btn-check form-control flangePerc" placeholder="Price"
                                    name="flange_cal" id="flanges{{ $value->tax }}" autocomplete="off"
                                    value="{{ $value->tax }}">
                                <label class="btn btn-outline-success" for="flanges{{ $value->tax }}">{{ $value->tax
                                    }}</label>&nbsp;&nbsp;
                                @endif
                                @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Tax</label>
                        <div class="col-sm-9">
                            @if ($taxs->isNotEmpty())
                            @foreach ($taxs as $key => $value)
                            <?php $gstVal = $value->gst; ?>
                            @endforeach
                            @endif
                            <input type="text" class="taxOriginal numericInput form-control" readonly name="tax"
                                value="{{ $gstVal }}">
                        </div>
                    </div>
                    <div class="mb-33 finalDiscount" style="display: none !important">
                        <label for="name" class="form-label">Discount %</label>
                        <input type="text" class="form-controls numericInput" id="finaldiscount" name="finaldiscount"
                            required>
                    </div>
                    <div class="mb-3">
                        <div id="calculateData"></div>
                    </div>
                    <button type="button" id="calculateButton" class="btn btn-secondary">Calculate</button>
                    <button type="button" class="btn btn-primary">Download</button>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Calculate Form Model END -->

<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>

<script>
    $("#calculateButton").click(function() {
        $(".frameOriginal").val();
        originalPrice = parseFloat($(".priceOriginal").val());
        taxOriginal = parseFloat($(".taxOriginal").val());
        let selectedValues = $('input[name="typeOption[]"]:checked').map(function() {
            return $(this).val(); // Return the value of each checked checkbox
        }).get();
        if (selectedValues[0] == 'Flange') {
            var flangeprice = parseFloat($(".calFlangePrice").html());
            var price = originalPrice + flangeprice;
        } else if (selectedValues[0] == 'Foot') {
            var price = parseFloat($(".priceOriginal").val());
        } else {
            var price = parseFloat($(".priceOriginal").val());
        }
        discountRate = parseFloat($("#finaldiscount").val());
        AdditionalTax = parseFloat($('input[name="flange_cal"]:checked').val());
        // let taxAmount = (price * AdditionalTax) / 100;
        // let priceAfterTax = price + taxAmount;
        // let discountAmount = (priceAfterTax * discountRate) / 100;
        // let totalAfterDiscount = priceAfterTax - discountAmount;
        // let extraTaxAmount = (totalAfterDiscount * taxOriginal) / 100;
        // let finalTotal = totalAfterDiscount + extraTaxAmount;

        let discountPrice = (originalPrice * (discountRate / 100));
        let AfterDiscount = (price - discountPrice);
        let taxAmount = AfterDiscount + AdditionalTax;
        let extraTaxAmount = taxAmount + taxOriginal;
        let FinalPrice = Math.round(parseFloat(extraTaxAmount.toFixed(2)));
        console.log('price', price);
        console.log('discountPrice', discountPrice);
        console.log('AfterDiscount', AfterDiscount);
        console.log('taxAmount', taxAmount);
        console.log('extraTaxAmount', extraTaxAmount);
        console.log('FinalPrice', FinalPrice);


        $("#calculateData").html('Final Amount : <b>' + FinalPrice.toFixed(2) + '</b> ( Formula if flange selected (((flange+price) - dicount) + AT) + Tax' + 'Formula if foot selected (((price) - dicount) + AT) + Tax )');
    });
    $('#catFormEdit').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('addform.update', ':id') }}".replace(':id', window.editId),
            method: "PUT",
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Include CSRF token
            },
            success: function(response) {
                showAlert('success', 'Product updated successfully!');
                table.ajax.reload();
            },
            error: function(error) {
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
            success: function(response) {
                $("#categorys_d").val(response.data.category_id);
                $("#categorys_d").trigger('change');
                var newSubcategory = `<div class="mb-3 row">
                    <input type="hidden" class="form-control" id="subname" name="subcategory_id[]" value='` + response.data.id + `'>
                    <label for="subname" class="col-sm-3 col-form-label "><b>` + response.data.subcategory_name + `</b></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="subname" value="` + response.data.subcategory_val + `" name="subcategory_val[]" required>
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
                typeOptionCheckBoc.forEach(function(optionCheckbox) {
                    $('input[name="typeOption[]"][value="' + optionCheckbox + '"]').prop('checked', true);
                });

            },
            error: function(error) {
                console.error(error);
                showAlert('danger', 'Something went wrong. Please try again.');
            }
        });
    }
    $('#catForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: "{{ route('addform.store') }}",
            method: "POST",
            data: $(this).serialize(),
            success: function(response) {
                showAlert('success', 'Product added successfully!');
                $('#catForm')[0].reset();
                // setTimeout(function() {
                //     location.reload();
                // }, 3000);
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
    $(".flangePerShow").css('display', 'none');
    $(".FlangevalDiv").css('display', 'none');

    $('.toggleRadio').on('change', function() {
        // Check if the current radio button is checked
        if ($(this).is(':checked') && $(this).val() === 'Flange') {
            $(".flangeShow").css('display', 'block');
            $(".FlangevalDiv").css('display', 'block');
            $(".flangeShow").css('margin-left', '16px');
            $(".Footval").removeAttr('required');
            $(".Flangeval").attr('required', true);
        } else {
            if ($(this).val() === 'Flange') {
                $(".flangeShow").css('display', 'none');
                $(".FlangevalDiv").css('display', 'none');
                $(".Footval").attr('required', true);
                $(".Flangeval").removeAttr('required');
            }
        }
    });
    //end edit form
    $('.productClick').on('click', function(e) {
        e.preventDefault();
        $('#product-dropdown').html('<option value="">Select Product</option>');
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');
        var product_id = $(this).data('id');
        window.product_id = product_id;
        var product_title = $(this).data('title');
        $(".catFormModalLabel").html(product_title);
        $("#product_ids").val(product_id);
        if (product_id) {
            $.ajax({
                url: '{{ route("get.categorys", "") }}/' + product_id,
                type: 'GET',
                success: function(data) {
                    $('#categorys').html('<option value="">Select Category</option>');
                    $('#category_cal').html('<option value="">Select Category</option>');
                    $.each(data, function(id, category_name) {

                        $('#categorys').append('<option value="' + id + '">' + category_name + '</option>');
                        $('#category_cal').append('<option value="' + id + '">' + category_name + '</option>');
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
                                <input type="hidden" class="form-control" id="subname" name="subcategory_id[]" value='` + id + `'>
                                                    <label for="subname" class="col-sm-3 col-form-label "><b>` + category_name + `</b></label>
                                                    <div class="col-sm-9">
                                                        <input type="text" class="form-control" id="subname" name="subcategory_val[]" required>
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

    $('#category_cal').change(function() {
        var category_id = $(this).val();
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');
        let productId = window.product_id;
        let url = "{{ route('get.subcategory', [':categoryId', ':productId']) }}";
        url = url.replace(':categoryId', category_id).replace(':productId', productId);
        if (category_id) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    // console.log(data);
                    $("#subcategorycal-containercal").html('');
                    if (data) {
                        $.each(data, function(id, subcategory_val) {

                            // Assuming `subcategory_val.options` contains an array of options for the dropdown
                            let options = ''; // Initialize an empty string for options
                            if (subcategory_val.options && Array.isArray(subcategory_val.options)) {
                                $.each(subcategory_val.options, function(index, option) {
                                    options += `<option value="${option.value}">${option.label}</option>`;
                                });
                            }

                            let newSubcategory = `
                                <div class="mb-33 d-flex justify-content-between">
                                    <label for="subname" class="form-label">${subcategory_val.name}</label>
                                    <div class="col-sm-9">
                                        <select name="subCat" data-idval="${subcategory_val.id}" onchange="getSabCatval(this, ${subcategory_val.cat_id});" class="form-select form-controlss subCat">
                                            ${options}
                                        </select>
                                    </div>
                                </div>`;
                            $('#subcategorycal-containercal').append(newSubcategory);

                        });
                        $('.priceOriginal').val(data[0].footval);
                        if (data[0].flange_percentage) {


                            $(".flangePerShow").css('display', 'block');

                            $(".flangeShow").css('display', 'block');
                            // $('button.btn-flange:contains("' + data[0].flange_percentage + '")').addClass('btn-success active').attr('disabled', true);
                            // $('button.btn-flange').attr('disabled', true);
                            $('input[name="flange"][value="' + data[0].flange_percentage + '"]').prop('checked', true);
                        } else {
                            $(".flangePerShow").css('display', 'none');

                            $(".flangeShow").css('display', 'none');
                        }

                        var price = parseFloat(data[0].footval); // Base price
                        var percentage = parseFloat(data[0].flange_percentage);

                        var finalPrice = price + (price * percentage / 100);
                        let typeOptionCheckBoc = data[0].typeOption.split(', ');
                        $('input[name="typeOption[]"]').prop('checked', false);
                        typeOptionCheckBoc.forEach(function(optionCheckbox) {
                            $('input[name="typeOption[]"][value="' + optionCheckbox + '"]').prop('checked', true);
                        });

                        $(".calFlangePrice").text(finalPrice);
                        $("#bracketFlangeVal").html(percentage + '%');
                        $(".finalDiscount").removeAttr('style');
                        $(".frameOriginal").val(data[0].size);
                    } else {
                        $('#subcategorycal-containercal').append(newSubcategory);
                    }
                }
            });
        } else {
            $("#subcategorycal-containercal").html('');
        }
    });

    function getSabCatval(sel, cat_id) {
        var created_at = sel.value;
        let productId = window.product_id;
        let url = "{{ route('get.subvalcategory', [':created_at', ':productId', ':catId']) }}";
        url = url.replace(':created_at', created_at).replace(':productId', productId).replace(':catId', cat_id);
        $.ajax({
            url: url,
            type: 'GET',
            success: function(data) {
                if (data) {
                    $.each(data, function(id, subcategory_val) {
                        let options = ''; // Initialize an empty string for options
                        if (subcategory_val.options && Array.isArray(subcategory_val.options)) {
                            $.each(subcategory_val.options, function(index, option) {
                                var $selectElement = $('select[data-idval="' + subcategory_val.id + '"]');
                                $selectElement.find('option[value="' + option.value + '"]').prop('selected', true);
                            });
                        }
                    });
                }
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

    $(document).on('click', '.btn-close', function() {
        location.reload(); // Reload the page
    });
    $('#select-all').on('click', function() {
        const rows = table.rows({
            'search': 'applied'
        }).nodes();
        $('input[type="checkbox"].select-row', rows).prop('checked', this.checked);
    });

    $('#viewTable tbody').on('change', '.select-row', function() {
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
                render: function(data, type, row, meta) {
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
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            } // Action column
        ]
    });
    // Handle form submission

    $('#delete-selected').on('click', function() {
        const selectedIds = [];
        table.$('input[type="checkbox"].select-row:checked').each(function() {
            selectedIds.push($(this).data('id'));
        });

        if (selectedIds.length > 0) {
            if (confirm('Are you sure you want to delete these items?')) {
                $.ajax({
                    url: "{{ route('addform.massDelete') }}",
                    type: 'POST',
                    data: {
                        ids: selectedIds,
                        _token: '{{ csrf_token() }}' // Include CSRF token
                    },
                    success: function(response) {
                        table.ajax.reload();
                        showAlert('success', 'Selected products deleted successfully!');
                    },
                    error: function(xhr) {
                        showAlert('danger', 'Failed to delete selected items.');
                    }
                });
            }
        } else {
            alert('No rows selected.');
        }
    });

    $('.numericInput').on('keypress', function(event) {
        // Allow digits only (ASCII codes 48-57 for '0' to '9')
        var charCode = event.which ? event.which : event.keyCode;

        if (charCode < 48 || charCode > 57) {
            event.preventDefault(); // Prevent non-digit input
        }
    });
</script>
@endsection