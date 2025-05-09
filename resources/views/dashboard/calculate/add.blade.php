@extends('layouts.page')
@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
<style>
    .textWidth {
        width: 94%;
        float: right;
    }

    .otherTextWidthSet {
        float: right;
        min-width: 95%;
        margin-right: -1%;
    }

    label.btn.btn-outline-success.setPosition {
        margin-left: 6%;
    }
</style>
<div class="container-fluid">
    <div class="row">
        <h1>{{ $products[0]['product_name'] }}</h1>
        @php
        $taxs = \App\Models\Tax::where('status', '1')->get();
        @endphp
        <div class="tab-pane fade show active" id="product" role="tabpanel" aria-labelledby="product-tab">
            <div class="alert-container">
            </div>
            <form id="calForm">
                @csrf
                <div class="mb-33 d-flex justify-content-between">
                    <label for="name" class="form-label">Select Category</label>
                    <select id="category_cal" name="category_id" class="form-controls form-select" required>
                        {!! $options !!}
                    </select>
                </div>

                <div id="subcategorycal-containercal">
                </div>
                <div class="mb-33 d-flex justify-content-between">
                    <label for="name" class="form-label">Frame Size</label>
                    <div class="col-sm-9">
                        <input type="text" class="frameOriginal numericInput form-controls otherTextWidthSet" readonly
                            name="frame" value="">
                    </div>
                </div>
                <div class="" id="">
                    <div class="mb-33 d-flex justify-content-between">
                        <label for="name" class="form-label">Price</label>
                        <div class="col-sm-9">
                            <input type="text" class="priceOriginal form-controls otherTextWidthSet" readonly
                                name="price" value="">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input toggleRadio" type="checkbox" checked name="typeOption_cal[]"
                            id="inlineRadio1" value="Foot">
                        <label class="form-check-label" for="inlineRadio1">Foot</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input toggleRadio" type="checkbox" name="typeOption_cal[]"
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
                        </div>
                    </div>
                    @endif
                </div>

                <div class="">
                    <div class="mb-3 d-flex justify-content-between">
                        @if ($taxs->isNotEmpty())
                        <label for="name" class="form-label">Additional Tax</label>
                        <div class="col-sm-9">
                            @foreach ($taxs as $key => $value)
                            @if ($value->tax != '' || $value->tax != null)
                            <?php $no = $key + 1; ?>

                            <input type="radio" class="btn-check form-control flangePerc" placeholder="Price"
                                name="flange_cal" id="flanges{{ $value->tax }}" autocomplete="off"
                                value="{{ $value->tax }}">
                            <label class="btn btn-outline-success setPosition" for="flanges{{ $value->tax }}">{{
                                $value->tax
                                }}</label>&nbsp;&nbsp;
                            @endif
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mb-33 d-flex justify-content-between">
                    <label for="name" class="form-label">GST</label>
                    <div class="col-sm-9">
                        @if ($taxs->isNotEmpty())
                        @foreach ($taxs as $key => $value)
                        <?php        $gstVal = $value->gst; ?>
                        @endforeach
                        @endif
                        <input type="text" class="taxOriginal numericInput form-controls otherTextWidthSet" readonly
                            name="tax" value="{{ $gstVal }}">
                    </div>
                </div>
                <div class="mb-33 finalDiscount" style="display: none !important">
                    <label for="name" class="form-label">Discount %</label>
                    <input type="text" class="form-controls numericInput" id="finaldiscount" name="finaldiscount"
                        required>
                </div>
                <div class="mb-3">
                    <div id="calculateData"></div>
                    <div id="calculateDataWithoutTax"></div>
                    <div id="calculateDataFlange"></div>
                    <div id="calculateDataFlangeWithoutTax"></div>
                    <div id="calculateDataFoot"></div>
                    <div id="calculateDataFootWithouTax"></div>
                </div>
                <button type="button" onclick="goBack()" class="btn btn-info" aria-label="Close">Back</button>
                <button type="button" id="calculateButton" class="btn btn-secondary">Calculate</button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" id="downloadBtn">Download</button>
            </form>
        </div>
    </div>
</div>

<!-- Bootstrap Modal Download-->
<div class="modal fade" id="pdfModal" tabindex="-1" aria-labelledby="pdfModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="pdfModalLabel">Enter Your Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ url('/generate-pdf') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Name:</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address:</label>
                        <textarea class="form-control" name="address" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Phone:</label>
                        <input type="tel" title="Enter a 10-digit phone number numericInput" class="form-control"
                            name="phone" required pattern="[0-9]{10}" maxlength="10">
                        <input type="hidden" class="form-control" name="product_id" id="pdfProductId" value="">
                        <input type="hidden" class="form-control" name="category_id" id="pdfCategory" value="">
                        <input type="hidden" class="form-control" name="pdfDate" id="pdfDate" value="">
                        <input type="hidden" class="form-control" name="pdfCalculate" id="pdfCalculate" value="">
                        <input type="hidden" class="form-control" name="pdfCalculateWithoutTax"
                            id="pdfCalculateWithoutTax" value="">
                        <input type="hidden" class="form-control" name="quantity" id="quantity" value="">

                    </div>
                    <!-- <div class="mb-3">
                        <label for="number" class="form-label">Quantity:</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" value="1" maxlength="999" minlength="1"  min="1">
                    </div> -->
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Countinue</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Bootstrap Modal -->
<div class="modal fade" id="quantityModal" tabindex="-1" aria-labelledby="quantityModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enter Quantity</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="number" maxlength="999" minlength="1" value="1" id="quantityInput" class="form-control"
                    placeholder="Enter quantity" min="1">
            </div>
            <div class="modal-footer">
                <button type="button" id="submitQuantity" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

<script>
    function showAlert(type, message) {
        const alertHTML = `<div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>`;
        $('.alert-container').html(alertHTML); // Insert alert into container
    }
    $(".flangeShow").css('display', 'none');
    $(".flangePerShow").css('display', 'none');
    $(".FlangevalDiv").css('display', 'none');
    $("#downloadBtn").click(function () {
        // Show Bootstrap modal
        var catIdCh = $('#category_cal').val();
        var flange_calw = $('input[name="flange_cal"]:checked').val();
        var finaldiscountSDS = $("#finaldiscount").val();
        if(catIdCh && flange_calw && finaldiscountSDS) {
            $("#pdfModal").modal('show');
            $('#category_cal').css('border', 'none');
            $("#submitQuantity").click();
        } else {
            $('#category_cal').css('border', '1px solid red');
        }
    });
    $("#calculateButton").click(function () {
        // Show Bootstrap modal
            var catIdChk = $('#category_cal').val();
            var flange_cal = $('input[name="flange_cal"]:checked').val();
            var finaldiscountSD = $("#finaldiscount").val();
            var frameOriginal = $(".frameOriginal").val();
            var priceOriginal = $(".priceOriginal").val();
            // if(catIdChk && flange_cal && finaldiscountSD) {
            //     $("#quantityModal").modal('show');
            //     $('#category_cal').css('border', 'none');
            // } else {
            //     $('#category_cal').css('border', '1px solid red');
            // }
            let hasError = false;

            // Validate category
            if (!catIdChk) {
                $('#category_cal').css('border', '1px solid red');
                hasError = true;
            } else {
                $('#category_cal').css('border', 'none');
            }

            // Validate flange_cal
            if (!flange_cal) {
                $('.setPosition').css('border', '1px solid red');
                hasError = true;
            } else {
                $('.setPosition').css('border', 'none');
            }

            // Validate flange_cal
            if (!frameOriginal) {
                $('input[name="frame"]').css('border', '1px solid red');
                hasError = true;
            } else {
                $('input[name="frame"]').css('border', 'none');
            }

            // Validate flange_cal
            if (!priceOriginal) {
                $('input[name="price"]').css('border', '1px solid red');
                hasError = true;
            } else {
                $('input[name="price"]').css('border', 'none');
            }

            // Validate discount
            if (!finaldiscountSD) {
                $('#finaldiscount').css('border', '1px solid red');
                hasError = true;
            } else {
                $('#finaldiscount').css('border', 'none');
            }

            if (!hasError) {
                $("#quantityModal").modal('show');
            }
    });
    $("#submitQuantity").click(function () {
        $(".frameOriginal").val();
        let quantity = parseInt($("#quantityInput").val());
         if (!quantity || quantity <= 0) {
            alert("Please enter a valid quantity.");
            return;
        }
        $("#quantity").val(quantity);
        $("#quantityModal").modal('hide');
        let originalPrice = parseFloat($(".priceOriginal").val());
        let taxOriginal = parseFloat($(".taxOriginal").val());
        let selectedValues = $('input[name="typeOption_cal[]"]:checked').map(function () {
            return $(this).val(); // Return the value of each checked checkbox
        }).get();
        let price;
        let flangeprice;
        if (selectedValues.length === 1 && selectedValues[0] === 'Flange') {
            flangeprice = parseFloat($(".calFlangePrice").html());
            price = flangeprice;
        } else if (selectedValues.length === 1 && selectedValues[0] === 'Foot') {
            price = originalPrice;
        } else if (selectedValues.includes('Flange') && selectedValues.includes('Foot')) {
            flangeprice = parseFloat($(".calFlangePrice").html());
            footprice = originalPrice;
        } else {
            price = originalPrice;
        }
        discountRate = parseFloat($("#finaldiscount").val());
        AdditionalTaxs = parseFloat($('input[name="flange_cal"]:checked').val());

        let discountPrice = (price * (discountRate / 100));
        let AfterDiscount = (price - discountPrice);
        AdditionalTaxes = AfterDiscount * (AdditionalTaxs / 100);
        let taxAmount = AfterDiscount + AdditionalTaxes;
        taxOriginal = taxAmount * (taxOriginal / 100);
        let extraTaxAmount = taxAmount + taxOriginal;
        let FinalPrice = Math.round(parseFloat(extraTaxAmount.toFixed(2))) * quantity;
        let FinalPriceWithoutTax = Math.round(parseFloat(taxAmount.toFixed(2))) * quantity;

        if (selectedValues.includes('Flange') && selectedValues.includes('Foot')) {
            taxOriginal = parseFloat($(".taxOriginal").val());

            let discountPriceflange = (flangeprice * (discountRate / 100));
            let AfterDiscountFlange = (flangeprice - discountPriceflange);
            AdditionalTaxFlane = AfterDiscountFlange * (AdditionalTaxs / 100);
            let taxAmountFlange = AfterDiscountFlange + AdditionalTaxFlane;
            taxOriginalflange = taxAmountFlange * (taxOriginal / 100);
            let extraTaxAmountFlange = taxAmountFlange + taxOriginalflange;
            let FinalPriceFlange = Math.round(parseFloat(extraTaxAmountFlange.toFixed(2))) * quantity;
            let FinalPriceFlangeWithoutTax = Math.round(parseFloat(taxAmountFlange.toFixed(2))) * quantity;
            console.log('flangeprice', flangeprice);
            console.log('discountPriceflange', discountPriceflange);
            console.log('AdditionalTaxFlane', AdditionalTaxFlane);

            let discountPricefoot = (footprice * (discountRate / 100));
            let AfterDiscountFoot = (footprice - discountPricefoot);
            AdditionalTaxFoot = AfterDiscountFoot * (AdditionalTaxs / 100);
            let taxAmountFoot = AfterDiscountFoot + AdditionalTaxFoot;
            taxOriginalFoot = taxAmountFoot * (taxOriginal / 100);
            let extraTaxAmountFoot = taxAmountFoot + taxOriginalFoot;
            let FinalPriceFoot = Math.round(parseFloat(extraTaxAmountFoot.toFixed(2))) * quantity;
            let FinalPriceFootWithoutTax = Math.round(parseFloat(taxAmountFoot.toFixed(2))) * quantity;

            $("#calculateDataFlange").html('Final Amount Flange With Tax : <b>' + FinalPriceFlange.toFixed(2) + '</b>');

            $("#calculateDataFlangeWithoutTax").html('Final Amount Flange Without Tax : <b>' + FinalPriceFlangeWithoutTax.toFixed(2) + '</b>');

            $("#calculateDataFoot").html('Final Amount Foot With Tax : <b>' + FinalPriceFoot.toFixed(2) + '</b>');

            $("#calculateDataFootWithouTax").html('Final Amount Foot Without Tax : <b>' + FinalPriceFootWithoutTax.toFixed(2) + '</b>');

            $("#calculateData").hide();
            $("#calculateDataWithoutTax").hide();
        }
        $("#calculateData").html('Final Amount With Tax : <b>' + FinalPrice.toFixed(2));
        $("#pdfCalculate").val(FinalPrice.toFixed(2));
        $("#pdfCalculateWithoutTax").val(FinalPriceWithoutTax.toFixed(2));
        $("#calculateDataWithoutTax").html('Final Amount Without Tax : <b>' + FinalPriceWithoutTax.toFixed(2));
    });

    $('#category_cal').change(function () {
        var category_id = $(this).val();
        $("#calculateData").html('');
        $("#calculateDataWithoutTax").html('');
        $("#calculateDataFlange").html('');
        $("#calculateDataFlangeWithoutTax").html('');
        $("#calculateDataFoot").html('');
        $("#finaldiscount").val('');
        $('#subcategory-dropdown').html('<option value="">Select Subcategory</option>');
        let productId = "{{ $products[0]['id'] }}";
       $("#pdfCategory").val(category_id);
       $("#pdfProductId").val(productId);
        let url = "{{ route('get.subcategory', [':categoryId', ':productId']) }}";
        url = url.replace(':categoryId', category_id).replace(':productId', productId);
        if (category_id) {
            $.ajax({
                url: url,
                type: 'GET',
                success: function (data) {
                    // console.log(data);
                    $("#subcategorycal-containercal").html('');
                    if (data) {
                        $.each(data, function (id, subcategory_val) {

                            // Assuming `subcategory_val.options` contains an array of options for the dropdown
                            let options = ''; // Initialize an empty string for options
                            if (subcategory_val.options && Array.isArray(subcategory_val.options)) {
                                $.each(subcategory_val.options, function (index, option) {
                                    if (index == 0) {
                                        $("#pdfDate").val(option.value);
                                    }
                                    options += `<option value="${option.value}">${option.label}</option>`;
                                });
                            }

                            let newSubcategory = `
                                <div class="mb-33 d-flex justify-content-between">
                                    <label for="subname" class="form-label">${subcategory_val.name}</label>
                                    <div class="col-sm-9">
                                        <select name="subCat" data-idval="${subcategory_val.id}" onchange="getSabCatval(this, ${subcategory_val.cat_id});" class="form-select form-control textWidth subCat">
                                            ${options}
                                        </select>
                                    </div>
                                </div>`; //onchange="getSabCatval(this, ${subcategory_val.cat_id});"
                            $('#subcategorycal-containercal').append(newSubcategory);

                        });
                        if (data[0]) {
                            $('.priceOriginal').val(data[0].footval);
                        }
                        if (data[0] && data[0].flange_percentage) {


                            $(".flangePerShow").css('display', 'block');

                            $(".flangeShow").css('display', 'block');
                            // $('button.btn-flange:contains("' + data[0].flange_percentage + '")').addClass('btn-success active').attr('disabled', true);
                            // $('button.btn-flange').attr('disabled', true);
                            $('input[name="flange"][value="' + data[0].flange_percentage + '"]').prop('checked', true);
                        } else {
                            $(".flangePerShow").css('display', 'none');

                            $(".flangeShow").css('display', 'none');
                        }

                        var price = (data[0]) ? parseFloat(data[0].footval) : 0; // Base price
                        var percentage = (data[0]) ? parseFloat(data[0].flange_percentage) : 0;

                        var finalPrice = price + (price * percentage / 100);
                        let typeOptionCheckBoc = (data[0]) ? data[0].typeOption.split(', ') : [];
                        $('input[name="typeOption_cal[]"]').prop('checked', false);
                        typeOptionCheckBoc.forEach(function (optionCheckbox) {
                            $('input[name="typeOption_cal[]"][value="' + optionCheckbox + '"]').prop('checked', true);
                        });

                        $(".calFlangePrice").text(finalPrice);
                        $("#bracketFlangeVal").html(percentage + '%');
                        $(".finalDiscount").removeAttr('style');
                        $(".frameOriginal").val((data[0]) ? data[0].size : '');
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
        let productId = {{ $product_id }};

        let selectedDropDownVals = [];

        $('.subCat').each(function(index) {
            let currentDropdownTexts = $(this).find("option:selected").map(function() {
                return $(this).val();
            }).get();

            selectedDropDownVals = selectedDropDownVals.concat(currentDropdownTexts); // append to the main array
        });

        $("#calculateData").html('');
        $("#calculateDataWithoutTax").html('');
        $("#calculateDataFlange").html('');
        $("#calculateDataFlangeWithoutTax").html('');
        $("#calculateDataFoot").html('');
        $("#finaldiscount").val('');

        let url = "{{ route('get.subvalcategory', [':created_at', ':productId', ':catId', ':selectedDropDownVals']) }}";
        $("#pdfDate").val(created_at);
        url = url.replace(':created_at', created_at).replace(':productId', productId).replace(':catId', cat_id).replace(':selectedDropDownVals', selectedDropDownVals);
        $.ajax({
            url: url,
            type: 'GET',
            success: function (data) {
                if (Array.isArray(data) && data.length > 0) {
                    $.each(data, function (id, subcategory_val) {
                        let options = ''; // Initialize an empty string for options
                        if (subcategory_val.options && Array.isArray(subcategory_val.options)) {
                            $.each(subcategory_val.options, function (index, option) {
                                var $selectElement = $('select[data-idval="' + subcategory_val.id + '"]');
                                $selectElement.find('option[value="' + option.value + '"]').prop('selected', true);
                            });
                        }
                    });
                    $(".priceOriginal").val(data[0].price);
                    $(".frameOriginal").val(data[0].size);
                    var price = parseFloat(data[0].price);
                    let typeOptionCheckBoc = data[0].typeOption.split(', ');
                    $('input[name="typeOption_cal[]"]').prop('checked', false);
                    var percentage = parseFloat(data[0].flange_percentage);
                    var finalPrice = price + (price * percentage / 100);
                    typeOptionCheckBoc.forEach(function (optionCheckbox) {
                        if (optionCheckbox == 'Flange') {
                            $(".calFlangePrice").text(finalPrice);
                            $("#bracketFlangeVal").html(percentage + '%');
                            $(".flangeShow").css('display', 'block');
                        } else if (optionCheckbox == 'Foot') {
                            $(".flangeShow").css('display', 'none');
                        } else {
                            $(".flangeShow").css('display', 'none');
                        }
                        $('input[name="typeOption_cal[]"][value="' + optionCheckbox + '"]').prop('checked', true);
                    });
                } else {
                    $(".priceOriginal").val('');
                    $(".frameOriginal").val('');
                    $('input[name="typeOption_cal[]"]').prop('checked', false);
                    alert('No data found for the selected subcategory.');
                }
            }
        });
    }

    function goBack() {
        if (window.history.length > 1) {
            window.history.back();
        } else {
            window.location.href = '/'; // Redirect to a default page
        }
    }
    $('.numericInput').on('keypress', function(event) {
        // Allow digits only (ASCII codes 48-57 for '0' to '9')
        var charCode = event.which ? event.which : event.keyCode;

        if (charCode < 48 || charCode > 57) {
            event.preventDefault(); // Prevent non-digit input
        }
    });
</script>
@endsection