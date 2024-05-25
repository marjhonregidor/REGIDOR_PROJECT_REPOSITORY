<?php include('connection.php'); ?>

<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="css/bootstrap5.0.1.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="css/datatables-1.10.25.min.css" />
    <title>CRUD Stocks Management</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif !important;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #C9CCD3;
            background-image: linear-gradient(-180deg, rgba(255,255,255,0.50) 0%, rgba(0,0,0,0.50) 100%);
            background-blend-mode: lighten;
        }

        .container {
            background-color: rgba(255, 255, 255, 0.5);
            box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
            padding: 30px 40px;
            border-radius: 20px;
            width: 90%;
            height: 90%;
        }
    </style>

</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="header-container text-center">
                    <h2>Stocks Management</h2>
                    <div class="btnAdd">
                        <a href="#!" data-id="" data-bs-toggle="modal" data-bs-target="#addItemModal" class="btn btn-dark">Add Item</a>
                    </div>
                </div>
                <hr>
                <table id="example" class="table">
                    <thead>
                        <th>#</th>
                        <th>Items</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Address</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="js/jquery-3.6.0.min.js" crossorigin="anonymous"></script>
    <script src="js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="js/dt-1.10.25datatables.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#example').DataTable({
                "fnCreatedRow": function(nRow, aData, iDataIndex) {
                    $(nRow).attr('id', aData[0]);
                },
                'serverSide': 'true',
                'processing': 'true',
                'paging': 'true',
                'order': [],
                'ajax': {
                    'url': 'fetch_data.php',
                    'type': 'post',
                },
                "aoColumnDefs": [{
                    "bSortable": false,
                    "aTargets": [5]
                },

                ]
            });
        });
        $(document).on('submit', '#addItem', function(e) {
            e.preventDefault();
            var address = $('#addAddressField').val();
            var item = $('#addItemField').val();
            var price = $('#addPriceField').val();
            var description = $('#addDescriptionField').val();
            if (address != '' && item != '' && price != '' && description != '') {
                $.ajax({
                    url: "add_user.php",
                    type: "post",
                    data: {
                        address: address,
                        item: item,
                        price: price,
                        description: description
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        var status = json.status;
                        if (status == 'true') {
                            mytable = $('#example').DataTable();
                            mytable.draw();
                            $('#addItemModal').modal('hide');
                        } else {
                            alert('failed');
                        }
                    }
                });
            } else {
                alert('Fill all the required fields');
            }
        });
        $(document).on('submit', '#updateItem', function(e) {
            e.preventDefault();
            //var tr = $(this).closest('tr');
            var address = $('#addressField').val();
            var item = $('#itemField').val();
            var price = $('#priceField').val();
            var description = $('#descField').val();
            var trid = $('#trid').val();
            var id = $('#id').val();
            if (address != '' && item != '' && price != '' && description != '') {
                $.ajax({
                    url: "update_user.php",
                    type: "post",
                    data: {
                        address: address,
                        item: item,
                        price: price,
                        description: description,
                        id: id
                    },
                    success: function(data) {
                        var json = JSON.parse(data);
                        var status = json.status;
                        if (status == 'true') {
                            table = $('#example').DataTable();
                            var button = '<td><a href="javascript:void();" data-id="' + id + '" class="btn btn-secondary btn-sm editbtn">Edit</a>  <a href="#!"  data-id="' + id + '"  class="btn btn-danger btn-sm deleteBtn">Delete</a></td>';
                            var row = table.row("[id='" + trid + "']");
                            row.row("[id='" + trid + "']").data([id, item, description, price, address, button]);
                            $('#exampleModal').modal('hide');
                        } else {
                            alert('failed');
                        }
                    }
                });
            } else {
                alert('Fill all the required fields');
            }
        });
        $('#example').on('click', '.editbtn ', function(event) {
            var table = $('#example').DataTable();
            var trid = $(this).closest('tr').attr('id');
            // console.log(selectedRow);
            var id = $(this).data('id');
            $('#exampleModal').modal('show');

            $.ajax({
                url: "get_single_data.php",
                data: {
                    id: id
                },
                type: 'post',
                success: function(data) {
                    var json = JSON.parse(data);
                    $('#itemField').val(json.item);
                    $('#descField').val(json.description);
                    $('#priceField').val(json.price);
                    $('#addressField').val(json.address);
                    $('#id').val(id);
                    $('#trid').val(trid);
                }
            })
        });

        $(document).on('click', '.deleteBtn', function(event) {
            var table = $('#example').DataTable();
            event.preventDefault();
            var id = $(this).data('id');
            if (confirm("Are you sure want to delete this Item ? ")) {
                $.ajax({
                    url: "delete_user.php",
                    data: {
                        id: id
                    },
                    type: "post",
                    success: function(data) {
                        var json = JSON.parse(data);
                        status = json.status;
                        if (status == 'success') {
                            $("#" + id).closest('tr').remove();
                        } else {
                            alert('Failed');
                            return;
                        }
                    }
                });
            } else {
                return null;
            }
        })
    </script>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="updateItem">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="trid" id="trid" value="">
                        <div class="mb-3 row">
                            <label for="itemField" class="col-md-3 form-label">Item</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="itemField" name="item">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="descField" class="col-md-3 form-label">Description</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="descField" name="description">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="priceField" class="col-md-3 form-label">Price</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="priceField" name="price">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="addressField" class="col-md-3 form-label">Address</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="addressField" name="price">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Add user Modal -->
    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addItem" action="">
                        <div class="mb-3 row">
                            <label for="addItemField" class="col-md-3 form-label">Item</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="addItemField" name="item">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="addDescriptionField" class="col-md-3 form-label">Description</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="addDescriptionField" name="description">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="addPriceField" class="col-md-3 form-label">Price</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="addPriceField" name="price">
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <label for="addAddressField" class="col-md-3 form-label">Address</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="addAddressField" name="address">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</body>
</html>