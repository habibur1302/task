<?php
        require '../model/items.php';
        session_start();
        $itemtb=isset($_SESSION['sporttbl0'])?unserialize($_SESSION['sporttbl0']):new items();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Buyer</title>
    <link rel="stylesheet" href="../libs/bootstrap.css">
    <link href="~/../libs/fontawesome/css/font-awesome.css" rel="stylesheet" />
    <style type="text/css">
        .wrapper{
            width: 100%;
            margin: 0 auto;
        }
        .wrapper2{
            width: 550px;
            margin: 0 auto;
        }
        .mt{
            margin-top: 0px;
            margin-left: 40px;
        }
        .error
        {
            color:red;
            font-family:verdana, Helvetica;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <?php $path = ( explode('/', $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'])); ?>
                        <a href="<?php echo  '/' . $path[1]  ?>" class="btn btn-success pull-left">Home</a>
                        <h2 class="pull-left mt">Buyer Details</h2>
                    </div>
                    <div class="wrapper2">
                    <div class="page-header">
                        <h2>Add Buyer</h2>
                    </div>
                        <div>
                            <p id="show_error"></p>
                        </div>
                    <p>Please fill this form and submit to add Buyer record in the database.</p>
                    <form action="../index.php?act=add" method="post" id="item">
                        <div class="form-group <?php echo (!empty($itemtb->amount_msg)) ? 'has-error' : ''; ?>">
                            <label>Amount</label>
                            <input type="number" name="amount" class="form-control" value="<?php echo $itemtb->amount; ?>">
                            <span class="help-block"><?php echo $itemtb->amount_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($itemtb->buyer_msg)) ? 'has-error' : ''; ?>">
                            <label>Buyer</label>
                            <input type="text" name="buyer" class="form-control buyer" value="<?php echo $itemtb->buyer; ?>" maxlength="20">
                            <span class="help-block"><?php echo $itemtb->buyer_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($itemtb->receipt_id_msg)) ? 'has-error' : ''; ?>">
                            <label>Receipt ID</label>
                            <input type="text" name="receipt_id" class="form-control" value="<?php echo $itemtb->receipt_id; ?>">
                            <span class="help-block"><?php echo $itemtb->receipt_id_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($itemtb->items_msg)) ? 'has-error' : ''; ?>">
                            <label>Items</label>
                            <div class="field_wrapper">
                                <div>
                                    <input type="text" name="item_name[]" class="item_name" value=""/>
                                    <a href="javascript:void(0);" class="add_button" title="Add field">add</a>
                                </div>
                            </div>
                            <span class="help-block"><?php echo $itemtb->items_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($itemtb->buyeremail_msg)) ? 'has-error' : ''; ?>">
                            <label>Buyer email</label>
                            <input type="text" name="buyeremail" class="form-control" value="<?php echo $itemtb->buyeremail; ?>">
                            <span class="help-block"><?php echo $itemtb->buyeremail_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($itemtb->note_msg)) ? 'has-error' : ''; ?>">
                            <label>Note</label>
                            <textarea id="w3review" name="note" rows="4" cols="67"><?php echo $itemtb->note; ?></textarea>
                            <span class="help-block"><?php echo $itemtb->note_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($itemtb->city_msg)) ? 'has-error' : ''; ?>">
                            <label>City</label>
                            <input type="text" name="city" class="form-control" value="<?php echo $itemtb->city; ?>">
                            <span class="help-block"><?php echo $itemtb->city_msg;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($itemtb->phone_msg)) ? 'has-error' : ''; ?>">
                            <label>Phone</label>
                            <div class="input-group">
                                <span class="input-group-addon">880</span>
                                <input type="number" name="phone" id="phone" class="form-control" maxlength="10" value="<?php echo $itemtb->phone; ?>">
                                <span class="help-block"><?php echo $itemtb->phone_msg;?></span>
                            </div>
                        </div>
                        <div class="form-group <?php echo (!empty($itemtb->entry_by_msg)) ? 'has-error' : ''; ?>">
                            <label>Entry By</label>
                            <input type="number" name="entry_by" class="form-control" value="<?php echo $itemtb->entry_by; ?>">
                            <span class="help-block"><?php echo $itemtb->entry_by_msg;?></span>
                        </div>
                        <input type="submit" name="addbtn" class="btn btn-primary" value="submit">
                        <a href="../index.php" class="btn btn-default">Cancel</a>
                    </form>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = '<div><input type="text" name="item_name[]" class="item_name" style="margin-top: 5px;" value=""/><a href="javascript:void(0);" class="remove_button">remove</a></div>'; //New input field html
            var x = 1; //Initial field counter is 1

            //Once add button is clicked
            $(addButton).click(function(){
                //Check maximum number of input fields
                if(x < maxField){
                    x++; //Increment field counter
                    $(wrapper).append(fieldHTML); //Add field html
                }
            });

            //Once remove button is clicked
            $(wrapper).on('click', '.remove_button', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                x--; //Decrement field counter
            });
        });
        $(function()
        {
            $("#item").validate(
                {
                    rules:
                        {
                            amount:
                                {
                                    required: true
                                },
                            buyer:
                                {
                                    required: true,
                                    maxlength: 20
                                },
                            receipt_id:
                                {
                                    required: true
                                },
                            buyeremail:
                                {
                                    required: true,
                                    email: true
                                },
                            note:
                                {
                                    required: true,
                                    maxlength: 30
                                },
                            city:
                                {
                                    required: true
                                },
                            phone:
                                {
                                    required: true
                                },
                            entry_by:
                                {
                                    required: true
                                },
                            message:
                                {
                                    rangelength:[50,1050]
                                }
                        }
                });
        });

        $('form#item').on('submit', function(event) {

            // adding rules for inputs with class 'comment'
            $('input.item_name').each(function() {
                $(this).rules("add",
                    {
                        required: true
                    })
            });

            // prevent default submit action
            event.preventDefault();
            // test if form is valid
            if($('form#item').validate().form()) {
                var phone_value = $('#phone').val();
                $('form#item').append('<input type="hidden" name="phone" value="880'+phone_value+'" />');
                var form = $(this);
                var dateObj = new Date();
                var month = ("0" + (dateObj.getMonth() + 1)).slice(-2); //months from 1-12
                var day = dateObj.getDate();
                var year = dateObj.getFullYear();
                var newdate = year + "-" + month + "-" + day;
                $('form#item').append('<input type="hidden" name="entry_at" value="'+newdate+'" />');
                var url = form.attr('action');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success:function(data)
                    {
                        console.log(data)
                        if (data == "success")
                        location.href = "http://localhost/mvclesson/";
                        else
                            alert("insert Failed.");
                        $('#show_error').html(data);
                    }
                });
            } else {
                console.log("does not validate");
            }
        })
    </script>
</body>
</html>
