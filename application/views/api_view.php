<html>

<head>
    <title>CURD REST API in Codeigniter</title>

    <!-- import styles -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- import scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>

<body>
    <div class="container">
        <br />
        <h3 align="center">Please select the time slots</h3>
        <br />
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="panel-title">Time slots history</h3>
                    </div>
                    <div class="col-md-6" align="right">
                        <button type="button" id="add_button" class="btn btn-info btn-xs">Add</button>
                    </div>
                </div>
            </div>
            <div class="panel-body">
                <span id="success_message"></span>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
</body>

</html>

<div id="userModal" class="modal fade">
    <div class="modal-dialog">
        <form method="post" id="user_form">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Booking</h4>
                </div>
                <div class="modal-body">
                    <label>Enter First Name</label>
                    <input type="text" name="first_name" id="first_name" class="form-control" />
                    <span id="first_name_error" class="text-danger"></span>
                    <br />

                    <label>Enter Last Name</label>
                    <input type="text" name="last_name" id="last_name" class="form-control" />
                    <span id="last_name_error" class="text-danger"></span>
                    <br />

                    <label>Please select the date:</label>
                    <br />
                    <input type="text" name="date_slot" id="datepicker" class="form-control" />
                    <br />

                    <label>Please select the time slot:</label>
                    <br />
                    <select name="time_slot" id="time_slot" class="form-control">
                        <option value="9:00 - 9:30">9:00 - 9:30</option>
                        <option value="9:30 - 10:00">9:30 - 10:00</option>
                        <option value="10:00 - 10:30">10:00 - 10:30</option>
                        <option value="10:30 - 11:00">10:30 - 11:00</option>
                        <option value="11:00 - 11:30">11:00 - 11:30</option>
                        <option value="11:30 - 12:00">11:30 - 12:00</option>
                        <option value="12:00 - 12:30">12:00 - 12:30</option>
                        <option value="12:30 - 13:00">12:30 - 13:00</option>
                        <option value="13:00 - 13:30">13:00 - 13:30</option>
                        <option value="13:30 - 14:00">13:30 - 14:00</option>
                        <option value="14:00 - 14:30">14:00 - 14:30</option>
                        <option value="14:30 - 15:00">14:30 - 15:00</option>
                        <option value="15:00 - 15:30">15:00 - 15:30</option>
                        <option value="15:30 - 16:00">15:30 - 16:00</option>
                        <option value="16:00 - 16:30">16:00 - 16:30</option>
                        <option value="16:30 - 17:00">16:30 - 17:00</option>
                        <option value="17:00 - 17:30">17:00 - 17:30</option>
                        <option value="17:30 - 18:00">17:30 - 18:00</option>
                    </select>
                    <br />

                </div>
                <div class="modal-footer">
                    <input type="hidden" name="user_id" id="user_id" />
                    <input type="hidden" name="data_action" id="data_action" value="Insert" />
                    <input type="submit" name="action" id="action" class="btn btn-success" value="Add" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {

        // init datepicker and configs for datepicker (max up to 3 weeks of selection)
        $("#datepicker").datepicker({
            maxDate: "+3W",
            minDate: "0"
        });

        // fetch all previously saved data on page load
        function fetch_data() {
            $.ajax({
                url: "<?php echo base_url(); ?>Booking_api/action",
                method: "POST",
                data: {
                    data_action: 'fetch_all',
                },
                success: function(data) {
                    $('tbody').html(data);
                }
            });
        }

        // call fetch_data on document ready 
        fetch_data();

        // add data modal pop up
        $('#add_button').click(function() {
            $('#user_form')[0].reset();
            $('.modal-title').text("Add Booking");
            $('#action').val('Add');
            $('#data_action').val("Insert");
            $('#userModal').modal('show');
        });

        // form submit
        $(document).on('submit', '#user_form', function(event) {
            event.preventDefault();
            $.ajax({
                url: "<?php echo base_url() . 'Booking_api/action' ?>",
                method: "POST",
                data: $(this).serialize(),
                dataType: "json",
                success: function(data) {
                    if (data.success) {
                        $('#user_form')[0].reset();
                        $('#userModal').modal('hide');
                        // refresh data on success
                        fetch_data();
                        if ($('#data_action').val() == "Insert") {
                            $('#success_message').html('<div class="alert alert-success">Data Inserted</div>');
                        }
                    }

                    if (data.error) {
                        $('#first_name_error').html(data.first_name_error);
                        $('#last_name_error').html(data.last_name_error);
                    }
                }
            })
        });

        // open up edit modal dialog
        $(document).on('click', '.edit', function() {
            var user_id = $(this).attr('id');
            $.ajax({
                url: "<?php echo base_url(); ?>Booking_api/action",
                method: "POST",
                data: {
                    user_id: user_id,
                    data_action: 'fetch_single',
                },
                dataType: "json",
                success: function(data) {
                    $('#userModal').modal('show');
                    $('#first_name').val(data.first_name);
                    $('#last_name').val(data.last_name);
                    $('.modal-title').text('Edit Booking');
                    $('#user_id').val(user_id);
                    $('#action').val('Edit');
                    $('#data_action').val('Edit');
                }
            })
        });

        // delete modal
        $(document).on('click', '.delete', function() {
            var user_id = $(this).attr('id');
            if (confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url: "<?php echo base_url(); ?>Booking_api/action",
                    method: "POST",
                    data: {
                        user_id: user_id,
                        data_action: 'Delete',
                    },
                    dataType: "JSON",
                    success: function(data) {
                        if (data.success) {
                            $('#success_message').html('<div class="alert alert-success">Data Deleted</div>');
                            fetch_data();
                        }
                    }
                })
            }
        });

    });
</script>