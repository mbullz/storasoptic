
function costChange(cost, id) {
	calculateSubtotal(cost, id);
	calculateGrandTotal();
}

function calculateSubtotal(cost, id) {
	cost = parseInt(cost);
	var qty = $('#qty-' + id).html();
	qty = parseInt(qty);
	var subtotal = cost * qty;

	$('#subtotal-' + id).html(print_number(subtotal));
}

function calculateGrandTotal() {
	var grandTotal = 0;

	$("td[id|='subtotal']").each(function() {
		var subtotal = $(this).html();
		subtotal = subtotal.replace(/,/g, "");
		grandTotal += parseInt(subtotal);
	});

	$('#grandtotal').html(print_number(grandTotal));
}
