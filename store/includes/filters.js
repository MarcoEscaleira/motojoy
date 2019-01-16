function show_cats(cat) {
    $.ajax({
        url: '../actions/filters.php',
        method: 'POST',
        data: {categories: 1, cat: cat},
        success: function(data) {
            $('#show_cats').html(data);
        }
    });
}


function show_brands(cat) {
    $.ajax({
        url: '../actions/filters.php',
        method: 'POST',
        data: {brands: 1, cat: cat},
        success: function(data) {
            $('#show_brands').html(data);
        }
    });
}


function products(cat) {
    $.ajax({
        url: '../actions/products.php',
        method: 'POST',
        data: {get_products: 1, cat: cat},
        success: function(data) {
            $('#products').html(data);
        }
    });
}

function show_all(cat) {
    $('#all').html('<a href="#" class="category text-center pl-4 py-2" id="all" ct="'+cat+'">Todos</a>');
}


//Categories click
$('body').delegate('.cat', "click", function(event) {
    event.preventDefault();
    var cid = $(this).attr('cat_id');
    var tid = $(this).attr('type_id');

    $.ajax({
        url: '../actions/filters.php',
        method: 'POST',
        data: {getSelectedCategory: 1, cat_id: cid, type_id: tid},
        success: function(data) {
            $('#products').html(data);
        }
    });
});

//Categories click
$('body').delegate('.brand', "click", function(event) {
    event.preventDefault();

    var bid = $(this).attr('brand_id');
    var cid = $(this).attr('cat_id');

    $.ajax({
        url: '../actions/filters.php',
        method: 'POST',
        data: {getSelectedBrand: 1, cat_id: cid, brand_id: bid},
        success: function(data) {
            $('#products').html(data);
        }
    });
});


function page(cat) {
    $.ajax({
        url: '../actions/products.php',
        method: 'POST',
        data: {page: 1, cat: cat},
        success: function(data) {
            $('#pageno').html(data);
        }
    });
}