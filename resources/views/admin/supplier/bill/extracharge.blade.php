<div >
    <h5 class="mt-2">
        Bill Expenses
    </h5 >
    <hr>
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="extra-title">
                    Expense Title
                </label>
                <input class="form-control" type="text" id="extra-title" >

            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="extra-title">
                    Expense Amount
                </label>
                <input class="form-control" type="number" step="0.01" id="extra-amount" >
            </div>
        </div>
        <div class="col-md-12">
            <span class="btn btn-primary" onclick="addExpense()">Add Expense</span>
        </div>
        
    </div>
    <hr>
    <table class="table">
        <tr>
            <th>
                Title
            </th>
            <th>
                Amount
            </th>
            <th>

            </th>
        </tr>
        <tbody id="expense-items">
        </tbody>
        <tr>
            <td>
                Total
            </td>
            <td id="ei-total">
                0
            </td>
            <td>

            </td>
        </tr>
        
    </table>
</div>
@section('js3')
<script>
    ei=1;
    function addExpense(){
        title= $('#extra-title').val();
        amount=$('#extra-amount').val();
        if(title==""){
            alert('Please Enter Expense Title');
            return;
        }
        if(amount==''){
            alert('Please Enter Expense Amount');
            return;
        }else{
            if(parseFloat(amount)<=0){
                alert('Please Enter Expense Amount');
                return; 
            }
        }

        html="<tr id='ei-"+ei+"'>"+
            "<td>"+title+"<input type='hidden' name='ei-title-"+ei+"' value='"+title+"'><input type='hidden' name='eis[]' value='"+ei+"'></td>"+
            "<td>"+amount+"<input type='hidden' class='ei-amount' name='ei-amount-"+ei+"' value='"+amount+"'></td>"+
            "<td><span class='btn btn-danger'  onclick='removeExpense("+ei+");'>Del</span></td>"+
            "</tr>";
            $('#expense-items').prepend(html);
            $('#extra-title').val('');
            $('#extra-amount').val('');
            $('#extra-title').focus();
            calculateExpenseTotal();
    }
    function removeExpense(id){
        $("#ei-"+id).remove();
        calculateExpenseTotal();
    }

    function calculateExpenseTotal(){
        eitotal=0;
        $('.ei-amount').each(function(){
            console.log($(this).val());
            eitotal+=parseFloat($(this).val());
        });

        $('#ei-total').text(eitotal);
    }
</script>
@endsection