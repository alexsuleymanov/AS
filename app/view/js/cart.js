function fmtmoney(num){
    return num.toFixed(2);
}

function update_cart_block(data){
    console.log(data);

    $("#prods #val").html(data.prods);
    $("#amount #val2").html(fmtmoney(data.amount));

    if(typeof data.message != 'undefined'){
        swal({
            title: data.message,
            text: '',
            timer: 800,
            showConfirmButton: false });

            /*window.setTimeout(function(){
                location.reload();
            } ,800);*/
    }
}

function buy(id){
//	console.log($("#prodform_"+id).attr('action'));

//    $.post($("#prodform_"+id).attr('action'), $("#prodform_"+id).serialize(), function (data){
//	console.log(data);
//    });
    $.post($("#prodform_"+id).attr('action'), $("#prodform_"+id).serialize(), update_cart_block, "json");
}

function update_cart(data){
    console.log(data);

    $("#cart_price_"+data.cart_id).html(fmtmoney(data.price));
    $("#cart_sum_"+data.cart_id).html(fmtmoney(data.num * data.price));
    $("#cart_num_"+data.cart_id).val(data.num);
    $(".cart_amount").html(fmtmoney(data.amount));

    update_cart_block(data);
}

function change_cart_num(cart_id){
    var num = $("#cart_num_"+cart_id).val();

    $.post($("#cartform").attr('action'), "cart_id="+cart_id+"&num="+num, update_cart, "json");
}

function plus_minus_cart_num(plus_minus, cart_id){
    if(plus_minus == 'plus'){
        var num = parseInt($("#cart_num_"+cart_id).val());
        num += 1;
    }
    if(plus_minus == 'minus'){
        var num = parseInt($("#cart_num_"+cart_id).val());
        num -= 1;
    }
    $.post("/cart/update", "cart_id="+cart_id+"&num="+num, update_cart, "json");
}

function cart_delete(cart_id){
    $.post("/cart/delete", "cart_id="+cart_id, update_cart, "json");
}

function wishlist(id){
    $.post("/wishlist/add/"+id, $("#prodform_"+id).serialize(), function (data){
	//alert("Товар добавлен в вишлист");// Убрать
	$(".wishlist_count").html(data.num);
	
	// Добавить стиль к кнопке. Сделать ее не кликабельной! В блоке вишлист в шапке показать кол-во товаров	
    }, "json");
}

function wish_to_cart(id){
    $("#prod_added").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');
    $.post("/cart/buy/fromwish", $("#wishform_"+id).serialize(), function (data){
        window.location.reload();
    }, "json");
}

function cart_to_wish(id){
    $("#prod_added2").show().animate({opacity: 0.9}, 500).delay(500).hide('fast');

    $.post("/wishlist/fromcart/"+id, {'id': id}, function (data){
        window.location.reload();
    });
}

function wishlist_delete(id){
    /*alert(id);
	$.post("/wishlist/delete/"+id, $("#wishform_"+id).serialize(), "json");*/
    $.get("/wishlist/delete/"+id);
}

function compare_add(cat, id){
    	$.get("/compare/add/"+cat+"/"+id, {}, function (data){
	    //alert("Товар добавлен в сравнение");
	    console.log(data);
//  $("#prod_compare"+id).; Добавить стиль кнопки (нажата), изменить onclick на compare_del, написать на ней кол-во товаров в сравнении (data.count), рядом должна появится ссылка "Сравнить" href = data.url
	    
	});
}

function compare_del(cat, id){
    	$.get("/compare/del/"+cat+"/"+id, {}, function (data){
	   // alert("Товар удален в сравнение"); // Эту строку убрать
//  $("#prod_compare"+id).; Убрать стиль кнопки(нажата), изменить onclick на compare_add, убрать кол-во товаров в сравнении (data.count), если data.count = 0 убрать ссылку "Сравнить", иначе оставить href = data.url
	    
	}, "json");
}

$(document).ready(function() {
    var gsearchwidth = $('#search').width();
    $("#gsearch").autocomplete("/hint/prod", {
        width: gsearchwidth,
        selectFirst: false,
        highlight: function(value) {
            return value;
        },
    });
});
