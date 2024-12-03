<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SPA CRUD</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Data Penjualan</h1>
    <div id="sales-list"></div>
    <button id="create-sale">Tambah Data</button>

    <div id="form-container" style="display:none;">
        <input type="text" id="item_name" placeholder="Item Name">
        <input type="number" id="quantity" placeholder="Quantity">
        <input type="number" id="price" placeholder="Price">
        <button id="save-sale">Simpan</button>
    </div>

    <script>
        $(document).ready(function() {
            const apiUrl = '/api/sales';

            // Fetch and display sales
            function loadSales() {
                $.get(apiUrl, function(data) {
                    let html = '<ul>';
                    data.forEach(sale => {
                        html += `<li>${sale.item_name} - ${sale.quantity} pcs - $${sale.price}
                            <button onclick="editSale(${sale.id})">Edit</button>
                            <button onclick="deleteSale(${sale.id})">Delete</button>
                        </li>`;
                    });
                    html += '</ul>';
                    $('#sales-list').html(html);
                });
            }

            // Show form for creating a new sale
            $('#create-sale').click(function() {
                $('#form-container').show();
                $('#save-sale').data('id', '');
            });

            // Save new or updated sale
            $('#save-sale').click(function() {
                const id = $(this).data('id');
                const saleData = {
                    item_name: $('#item_name').val(),
                    quantity: $('#quantity').val(),
                    price: $('#price').val(),
                };

                if (id) {
                    // Update sale
                    $.ajax({
                        url: `${apiUrl}/${id}`,
                        method: 'PUT',
                        data: saleData,
                        success: function() {
                            loadSales();
                            $('#form-container').hide();
                        },
                    });
                } else {
                    // Create sale
                    $.post(apiUrl, saleData, function() {
                        loadSales();
                        $('#form-container').hide();
                    });
                }
            });

            // Edit sale
            window.editSale = function(id) {
                $.get(`${apiUrl}/${id}`, function(data) {
                    $('#item_name').val(data.item_name);
                    $('#quantity').val(data.quantity);
                    $('#price').val(data.price);
                    $('#save-sale').data('id', id);
                    $('#form-container').show();
                });
            };

            // Delete sale
            window.deleteSale = function(id) {
                if (confirm('Are you sure?')) {
                    $.ajax({
                        url: `${apiUrl}/${id}`,
                        method: 'DELETE',
                        success: function() {
                            loadSales();
                        },
                    });
                }
            };

            // Initial load
            loadSales();
        });
    </script>
</body>
</html>
