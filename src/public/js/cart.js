$(document).ready(function() {
	$(".qtyminus").on("click",function(){
		const line = $(this);
		const id = $(this).attr('data-line');
		var now = $(this).parent().find(".qty").val();
		if ($.isNumeric(now)){
			if (parseInt(now) -1> 0)
			{ 
				now--;
				$.ajax({
					type: "POST",
					url: '/updatequantity',
					data: {
						CSRFName: $('input[name$="CSRFName"]').val(),
						CSRFToken: $('input[name$="CSRFToken"]').val(),
						line: id,
						quantity: now
					},
					success: function(data) {
						updateTotal(data, line);
					},
					dataType: 'json'
				});
			}
			else {
				if (confirm('Delete this item from your cart?')) {
					// delete itemx
					removeItemFromCart($(this));
				} 
			}
			$(this).parent().find(".qty").val(now);
		}
	});
	$(".qtyplus").on("click",function(){
		const line = $(this);
		const id = $(this).attr('data-line');
		var now = $(this).parent().find(".qty").val();
		if ($.isNumeric(now)){
			$.ajax({
				type: "POST",
				url: '/updatequantity',
				data: {
					CSRFName: $('input[name$="CSRFName"]').val(),
					CSRFToken: $('input[name$="CSRFToken"]').val(),
					line: id,
					quantity: parseInt(now)+1
				},
				success: function(data) {
					updateTotal(data, line);
				},
				dataType: 'json'
			});
			$(this).parent().find(".qty").val(parseInt(now)+1);
		}
	});
});

function updateTotal(data, line=null) {
	$("#subtotal").html(`$${data.subTotal}`);
	$("#total").html(`$${data.total}`);
	if(line) {
		line.parent().parent().next('td').find('.totalLine').html(`$${data.lineTotal}`);
	}
}

function removeItemFromCart(line) {
	if(line) {
		const id = line.attr('data-line');
		$.ajax({
			type: "POST",
			url: '/removeitemfromcart',
			data: {
				CSRFName: $('input[name$="CSRFName"]').val(),
				CSRFToken: $('input[name$="CSRFToken"]').val(),
				line: id
			},
			success: function(data) {
				line.parent().parent().parent().remove();
				updateTotal(data);
				updateCartCount();
			},
			dataType: 'json'
		});
	}
}