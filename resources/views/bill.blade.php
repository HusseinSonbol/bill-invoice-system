 @extends('layouts.app') @section('content')
<div class="container">
    <form class="row g-3 needs-validation" novalidate>


        <div class="col-md-6">
            <label for="validationCustom04" class="form-label">Client</label>
            <select class="form-select" id="validationCustom04" required>
        <option selected disabled value="">Choose...</option>
       @foreach ( $allUsers as $user )
       <option value="{{$user->name}}">{{$user->name}}</option>
       @endforeach

      </select>
            <div class="invalid-feedback">
                Please select a valid client.
            </div>
        </div>

        <div class="col-md-6">
            <label for="validationCustom05" class="form-label">Safe</label>
            <select class="form-select" id="validationCustom05" required>
          <option selected disabled value="">Choose...</option>
          @foreach ($allSafes as $safe )
          <option value="{{$safe->name}}">{{$safe->name}}</option>
          @endforeach
        </select>
            <div class="invalid-feedback">
                Please select a valid Safe.
            </div>
        </div>
        {{--
        <div class="col-md-3">
            <label for="validationCustom03" class="form-label">Item</label>
            <select class="form-select" id="validationCustom03" required>
          <option selected disabled value="">Choose...</option>
          @foreach ($allItems as $item )
          <option value="{{$item->name}}">{{$item->name}}</option>
          @endforeach

        </select>
            <div class="invalid-feedback">
                Please select a valid item.
            </div>
        </div>

        <div class="col-md-2">
            <label for="add" class="form-label">. . .</label><br>
            <input type="button" id="add" value="Add" class="btn btn-secondary btn-add-row">
        </div> --}}


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

                    <td> <select class="form-select" id="validationCustom03" onchange="calc()" required>
                <option selected disabled value="">Choose...</option>
                @foreach ($allItems as $item )
                <option value="{{$item->id}}">{{$item->name}}</option>
                @endforeach

              </select></td>

                    <td class="cart-product-quantity">
                        <div class="quantity clearfix">
                            <input type="button" value="-" class="minus" field="quantity">
                            <input type="text" style="width: 25%" id="quantity" name="quantity" value="0" class="qty" />
                            <input type="button" value="+" class="plus" field="quantity">
                        </div>
                    </td>
                    <td><span id="price" class="amount">{{$allItems[0]->total_price}}</span></td>
                    <td><span class="sales">{{$allItems[0]->sale_price}}</span>%</td>
                    <td><span id="total" class="total_amount"></span>0</td>
                </tr>

            </tbody>
        </table>
        <div class="col-md-2">
            <input type="button" id="add" value="Add" class="btn btn-secondary btn-add-row">
        </div>
        <div><span id="fTotal" class="h3"></span></div>

        <div class="col-12">
            <button class="btn btn-primary" type="submit">Submit form</button>
        </div>
    </form>
</div>


<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
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
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
<script>
    function calculate(obj) {

        var sale = parseInt($(obj).parent().parent().parent().find('.sales').text()) || 0;

        var price = parseFloat($(obj).parent().parent().parent().find('.amount').text()) || 0;
        price = price - price * sale / 100;
        var quantity = parseInt($(obj).parent().find('.qty').val());
        var nearTotal = price * quantity;
        var total = parseFloat(nearTotal).toFixed(2)

        tot = $(obj).parent().parent().parent().find('.total_amount').text(total);
        console.log(tot[0].innerText);

    }

    function changeQuantity(num, obj) {
        var value_to_set = parseInt($(obj).parent().find('.qty').val()) + num;
        if (value_to_set <= 0) {
            $(obj).parent().find('.qty').val(1);
            return;
        }
        $(obj).parent().find('.qty').val(value_to_set);
    }


    function calc() {
        let item = document.getElementById('validationCustom03').value;

        console.log(item);
        //$('#myTable').append('<tr><td>{{$allItems[0]->name}}</td><td class="cart-product-quantity"><div class="quantity clearfix"><input type="button" value="-" class="minus" field="quantity"><input type="text" style="width: 25%" id="quantity" name="quantity" value="1" class="qty"/><input type="button" value="+" class="plus" field="quantity"></div></td><td><span id="price" class="amount">{{$allItems[0]->total_price}}</span></td><td><span class="sales">{{$allItems[0]->sale_price}}</span>%</td><td><span id="total" class="total_amount"></span></td></tr>');
        const $lastRow = $('.item:last')
    }
    $().ready(function() {
        $(".minus").click(function() {
            changeQuantity(-1, this);
            calculate(this);
        });
        $(".plus").click(function() {
            changeQuantity(1, this);
            calculate(this);
        });
        $(".qty").keyup(function(e) {
            if (e.keyCode == 38) changeQuantity(1, this);
            if (e.keyCode == 40) changeQuantity(-1, this);
            calculate(this);
        });
    });
    // $( "#add" ).click(function() {

    //     // var val = $('#validationCustom03').val();
    //     // for(var i=0 ; i<{{count($allItems)}}; i++){
    //     //     console.log(i);
    //     //     if(val==$allItems[i]){
    //     //         console.log($allItems[i]);
    //     //     }
    //     // }
    //     $('#myTable').append('<tr><th scope="row">{{$allItems[0]->id}}</th><td>{{$allItems[0]->name}}</td><td class="cart-product-quantity"><div class="quantity clearfix"><input type="button" value="-" class="minus" field="quantity"><input type="text" style="width: 25%" id="quantity" name="quantity" value="1" class="qty"/><input type="button" value="+" class="plus" field="quantity"></div></td><td><span id="price" class="amount">{{$allItems[0]->total_price}}</span></td><td><span class="sales">{{$allItems[0]->sale_price}}</span>%</td><td><span id="total" class="total_amount"></span></td></tr>');
    //     // "<tr><th scope='row'>{{$allItems[1]->id}}</th><td>{{$allItems[1]->name}}</td><td class='cart-product-quantity'><div class='quantity clearfix'><input type='button' value='-' class='minus' field='quantity'><input type='text' style='width: 25%' id='quantity' name='quantity' value='1' class='qty'><input type='button' value='+' class='plus' field='quantity'></div></td><td><span id='price' class='amount'>{{$allItems[1]->total_price}}</span></td><td><span class='sales'>{{$allItems[1]->sale_price}}</span>%</td><td><span id='total' class='total_amount'></span></td></tr>"

    // });

    $('.btn-add-row').on('click', () => {
        const $lastRow = $('.item:last');
        const $newRow = $lastRow.clone();

        $newRow.find('.qty').val('0');
        $newRow.find('.amount').text('0');
        $newRow.find('.sales').text('0');
        $newRow.find('td:last').text('0');
        $newRow.insertAfter($lastRow);

        $newRow.find('input:first').focus();
    });
</script>
@endsection