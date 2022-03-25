 @extends('layouts.app') @section('content')
<div class="container">
    <form class="row g-3 needs-validation" id="myForm" novalidate>


        <div class="col-md-6">
            <label for="validationCustom04" class="form-label">Client</label>
            <select class="form-select user" id="validationCustom04" required>
        <option selected disabled value="">Choose...</option>
       @foreach ( $allUsers as $user )
       <option value="{{$user->id}}">{{$user->name}}</option>
       @endforeach

      </select>
            <div class="invalid-feedback">
                Please select a valid client.
            </div>
        </div>

        <div class="col-md-6">
            <label for="validationCustom05" class="form-label">Safe</label>
            <select class="form-select safe" id="validationCustom05" required>
          <option selected disabled value="">Choose...</option>
          @foreach ($allSafes as $safe )
          <option value="{{$safe->id}}">{{$safe->name}}</option>
          @endforeach
        </select>
            <div class="invalid-feedback">
                Please select a valid Safe.
            </div>
        </div>

        <table class="table table-striped table-hover" id="myTable">
            <thead>
                <tr>

                    <th scope="col" class="w-25">Item Name</th>
                    <th scope="col" class="w-25">Quantity</th>
                    <th scope="col" class="">Price</th>
                    <th scope="col" class="">Sale</th>
                    <th scope="col" class="">Total Price</th>

                </tr>
            </thead>
            <tbody>
                <tr class="item">

                    <td> <select class="form-select select" id="validationCustom03" onchange="calculateItemDetails(event)" required>
                <option selected disabled value="" class="op">Choose...</option>
                @foreach ($allItems as $item )
                <option value="{{$item->id}}" class="itemValue">{{$item->name}}</option>
                @endforeach

              </select>

                    </td>


                    <td class="cart-product-quantity">
                        <div class="quantity clearfix">
                            <input type="button" value="-" class="minus" field="quantity">
                            <input type="text" style="width: 25%" id="quantity" name="quantity" value="0" class="qty" />
                            <input type="button" value="+" class="plus" field="quantity">
                        </div>
                    </td>
                    <td><span id="price" class="amount price">0</span></td>
                    <td><span class="sales">0</span>%</td>
                    <td class="total_amount total">0</td>
                </tr>


            </tbody>
        </table>
        <span hidden id="err" class="text-danger" style="width: 100%; height: 10%; margin-top:-15px ;">please select an item</span>
        <div class="col-md-2">
            <input type="button" id="add" value="Add" class="btn btn-secondary btn-add-row">
        </div>
        <div><span id="fTotal" class="h3"></span></div>
        <div>
            <h4>Total Price :</h4><span id="totalPrice">0</span>
        </div>
        <div class="col-12">
            <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
    </form>
</div>


<script>
    //Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }else{
                        console.log('');
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
<script>

    function calculateItemDetails(event) {
        const $lastRow = $('.item:last')

        $.ajax({
            type: 'GET',
            url: `billItem/${event.target.value}`,

            dataType: 'json',
            success: function(data) {
                //console.log(data)
                $lastRow.find('.amount').text(data[0].quantity);
                $lastRow.find('.sales').text(data[0].sale_price);

            }
        });

    }
    var totalSumPrice = $('#totalPrice');
    $().ready(function() {

        $("#myTable").click(function(e) {
            if (e.target.classList.contains("plus")) {
                if (e.target.parentElement.parentElement.previousElementSibling.firstElementChild.value == '') {
                    document.getElementById('err').hidden = false
                } else {
                    document.getElementById('err').hidden = true
                    let row = e.target.parentNode.parentNode.parentNode
                    let qty = row.querySelector(".qty")
                    qty.value = parseInt(qty.value) + 1
                    calculatePrice(row, qty)
                }
            } else if (e.target.classList.contains("minus")) {

                    let row = e.target.parentNode.parentNode.parentNode
                    let qty = row.querySelector("#quantity")
                    if (qty.value > 0) {
                        qty.value = parseInt(qty.value) - 1
                    }
                    calculatePrice(row, qty)

            }
        })
    });

    function calculatePrice(row, qty) {

        let price = row.querySelector(".price")
        let total = row.querySelector(".total")
        let item = row.querySelector(".itemValue")
        let sales = row.querySelector(".sales")
        price = (parseInt(price.innerText) - (parseInt(price.innerText) * parseInt(sales.innerText)) / 100)
        let nearTotal = price * parseInt(qty.value)
        let totalPrice = parseFloat(nearTotal).toFixed(1)
        let sum = 0

        total.innerText = totalPrice
        document.querySelectorAll(".total").forEach(e => {
            sum = sum + parseFloat(e.innerText)
        })
        totalSumPrice[0].innerText = sum.toFixed(2)
        //console.log(row);
    }

    $('.btn-add-row').on('click', (e) => {
        document.getElementById('err').hidden = true
        let select ;
        $('.select').each(function() {
            select =  $(this).find(':selected')[0].value;
        })
        if(select !=''){
        const $lastRow = $('.item:last');
        const $newRow = $lastRow.clone();

        $newRow.find('.qty').val('0');
        $newRow.find('.amount').text('0');
        $newRow.find('.sales').text('0');
        $newRow.find('td:last').text('0');
        $newRow.insertAfter($lastRow);

        $newRow.find('input:first').focus();
        }else{
            document.getElementById('err').hidden = false
        }
    });

    $("#myForm").on("submit", function(e) {

        e.preventDefault()
        console.log(this.checkValidity());
        if (!this.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
         }else{

        prices = []
        document.querySelectorAll(".price").forEach(e => {
            prices.push(e.innerText)
        })
        //console.log(prices)

        quantites = []
        document.querySelectorAll(".qty").forEach(e => {
            quantites.push(e.value)
        })
        //console.log(quantites)

        sales = []
        document.querySelectorAll(".sales").forEach(e => {
            sales.push(e.innerText)
        })
        //console.log(sales)

        let items = []
        $('.select').each(function() {
            items.push($(this).find(':selected')[0].value)
        })
        //console.log(items)
        let totalItem = []
        document.querySelectorAll(".total").forEach(e => {
            totalItem.push(e.innerText);
        })

        let billPrice = totalSumPrice[0].innerText;
        let user = $('.user').find(':selected')[0].value ;
        let safe = $('.safe').find(':selected')[0].value ;

        //console.log(totalItem);
        $.ajax({
            type: 'POST',
            url: 'submitBill/',

            // dataType: 'json',
            data: {
                '_token': "{{csrf_token()}}",
                sales,
                prices,
                quantites,
                items,
                totalItem,
                user,
                safe,
                billPrice
            },
            success: function(data) {
                //console.log(data)
                window.location.href = "billList";
            },
            error:function (reject){
                    var response = $.parseJSON(reject.responseText);
                    console.log(response)
                }
        });
    }
    })
</script>
@endsection
