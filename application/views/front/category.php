<style>
    .prod-img-outer {
        position: relative;
        height: 200px;
        overflow: hidden;
    }

    .prod-img-large {
        height: auto;
        max-width: 100%;
    }

    .prod-img {
        max-height: 200px;
        max-width: 100%;
    }

    .prod-images {
        position: absolute;
        top: 0;
        right: 0;
        background: #f7f7f7;
        padding: 4px 8px;
        border-radius: 50px;
        color: #222;
    }

    .prod-images:hover {
        color: #000;
    }
    .carousel-control, .carousel-control:hover, .carousel-control:focus {
        color: #000;
    }
    .product h4, .product h4 a {
        color: #222;
    }
    .product:nth-child(3n+1) {
        clear: both;
    }
    .qty-div {
        font-size: 12px;
    }
    .qty {
        width: 40px;
        display: inline-block;
        text-align: center;
        padding: 3px;
        height: 24px;
    }
    .quantity_size{
        margin-right: 20px !important;
        margin-left: -10px !important;
    }
    .size{
        width: 40px;
        display: inline-block;
        text-align: center;
        padding: 0px;
        height: 24px;
    }
</style>
<?php if (!$products) { ?>
    <div class="box box-solid">
        <div class="box-body">
            <h4>No products available...</h4>
        </div>
    </div>
<?php } ?>

<div class="row">
    <?php foreach ($products as $p) { ?>
        <div id="pro<?= $p['id'] ?>" class="col-md-4 text-center product">
            <div class="box">
                <div class="box-body">
                    <div class="prod-img-outer">
                        <?php if($p['link']) { ?>
                        <a href="<?= $p['link'] ?>" target="_blank"><img src="<?= uploaded_url($p['image']) ?>" class="prod-img" /></a>
                        <?php } else { ?>
                        <img src="<?= uploaded_url($p['image']) ?>" class="prod-img" />
                        <?php } ?>
                        <a href="javascript:void(0)" class="prod-images" data-pid="<?= $p['id'] ?>"><i class="fa fa-search"></i></a>
                    </div>
                </div>
                <div class="box-footer">
                    <?php if($p['link']) { ?>
                    <h4><a href="<?= $p['link'] ?>" target="_blank"><?= $p['name'] ?></a></h4>
                    <?php } else { ?>
                    <h4><?= $p['name'] ?></h4>
                    <?php } ?>
                    
                    <p class="small"><b><?= number_format($p['price']) ?> Points</b></p>
                    <?php if (!$cartAllowed) { ?>
                    <button type="button" class="btn btn-danger btn-flat btn-xs btn-add-cart" disabled="true">Add To Cart</button>
                    <?php } else { ?>
                    <div class="row quantity_size">
                        <div class=<?php echo isset($category['is_size_view']) && $category['is_size_view'] ? 'col-sm-5' : 'col-sm-9' ?> >
                            <div class="qty-div">
                                Quantity: <input type="text" class="qty form-control numberonly" value="<?= isset($qtys[$p['id']]) ? $qtys[$p['id']] : 1 ?>" maxlength="3" <?= in_array($p['id'], $cpid) ? 'readonly' : '' ?> /> 
                            </div>
                        </div>

                        <?php if ($category['is_size_view']) { ?>
                        <div class="col-sm-4">
                            <div class="qty-div">
                                Size: <select class="size form-control" name="size">
                                <?php foreach ($size as $s) { ?>    
                                    <option value=<?= $s['size'] ?>><?= $s['size'] ?></option>
                                <?php } ?>
                                </select>
                            </div>
                        </div>
                        <?php } ?>

                        <div class="col-sm-3 text-right">
                            <?php if (in_array($p['id'], $cpid)) { ?>
                                <button type="button" class="btn btn-default btn-flat btn-xs btn-add-cart" data-pid="<?= $p['id'] ?>" disabled="true"><i class="fa fa-check"></i> Added To Cart</button>
                                <button type="button" class="btn btn-danger btn-flat btn-xs btn-remove-cart" data-pid="<?= $p['id'] ?>">Remove</button>
                            <?php } elseif (!$cartAllowed) { ?>
                                <button type="button" class="btn btn-danger btn-flat btn-xs btn-add-cart" data-pid="<?= $p['id'] ?>" disabled="true">Add To Cart</button>
                                <button type="button" class="btn btn-danger btn-flat btn-xs btn-remove-cart" style="display: none;" data-pid="<?= $p['id'] ?>">Remove</button>
                            <?php } else { ?>
                                <button type="button" class="btn btn-danger btn-flat btn-xs btn-add-cart" data-pid="<?= $p['id'] ?>">Add To Cart</button>
                                <button type="button" class="btn btn-danger btn-flat btn-xs btn-remove-cart" style="display: none;" data-pid="<?= $p['id'] ?>">Remove</button>
                            <?php } ?>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
</div>

<div id="imagesModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div id="imgCarousel" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#imgCarousel" data-slide-to="0" class="active"></li>
                    </ol>

                    <div class="carousel-inner">
                        <div class="item active"><div class="text-center">Loading...</div></div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#imgCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#imgCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(function() {
        $(document).on('click', '.btn-add-cart', function() {
            var id = $(this).attr('data-pid');
            var qty = $(this).parents('.product').find('.qty').val()
            var size = $(this).parents('.product').find('.size').val()
            
            $(this).addClass('btn-default').removeClass('btn-danger');
            $(this).html('<i class="fa fa-check"></i> Added To Cart');
            $(this).prop('disabled', true);
            $(this).siblings('.btn-remove-cart').show();
            $(this).parents('.product').find('.qty').attr('readonly', true);
            $(this).parents('.product').find('.size').attr('readonly', true);

            $.ajax({
                url: base_url+"ajax/add_to_cart",
                data: {
                    id,
                    qty,
                    size
                },
                type: 'POST',
                success: function(res) {
                    $('#cart-count').text(res).show();
                }
            });
        });

        $(document).on('click', '.btn-remove-cart', function() {
            var id = $(this).attr('data-pid');

            $(this).siblings('.btn-add-cart').addClass('btn-danger').removeClass('btn-default');
            $(this).siblings('.btn-add-cart').prop('disabled', false);
            $(this).siblings('.btn-add-cart').html('Add To Cart');
            $(this).parents('.product').find('.qty').attr('readonly', false);
            $(this).hide();

            $.ajax({
                url:base_url+ "/ajax/remove_from_cart",
                data: {
                    id
                },
                type: 'POST',
                success: function(res) {
                    $('#cart-count').text(res);

                    if (res == '0') {
                        $('#cart-count').hide();
                    }
                }
            });
        });

        $(document).on('click', '.prod-images', function() {
            var id = $(this).attr('data-pid');

            $.ajax({
                url:base_url+ "/ajax/product_images",
                data: {
                    id
                },
                type: 'POST',
                dataType: 'JSON',
                success: function(res) {
                    $('#imagesModal').modal('show');

                    var ind = '', item = '';

                    $.each(res.images, function(i, v){
                        ind += '<li data-target="#imgCarousel" data-slide-to="' + i + '" ' + (i == 0 ? 'class="active"' : '') + '></li>';
                        item += '<div class="item ' + (i == 0 ? 'active' : '') + '"><div class="text-center"><img src="' + v + '" class="prod-img-large"></div></div>';
                    });

                    $('#imgCarousel .carousel-indicators').html(ind);
                    $('#imgCarousel .carousel-inner').html(item);
                }
            });
        });
    });
</script>