<div class="box box-primary">
    <div class="box-body">
        <?= form_open() ?>
            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="name" class="required">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="<?= isset($row['name']) ? $row['name'] : "" ?>" required />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="link">Link</label>
                    <input type="text" id="link" name="link" class="form-control" value="<?= isset($row['link']) ? $row['link'] : "" ?>" />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-3">
                    <label for="length" class="required">Length</label>
                    <input type="text" id="length" name="length" class="form-control numberonly" value="<?= isset($row['length']) ? $row['length'] : "" ?>" maxlength="2" />
                </div>
                <div class="form-group col-sm-3">
                    <label for="breadth" class="required">Breadth</label>
                    <input type="text" id="breadth" name="breadth" class="form-control numberonly" value="<?= isset($row['breadth']) ? $row['breadth'] : "" ?>" maxlength="2" />
                </div>
                <div class="form-group col-sm-3">
                    <label for="height" class="required">Height</label>
                    <input type="text" id="height" name="height" class="form-control numberonly" value="<?= isset($row['height']) ? $row['height'] : "" ?>" maxlength="2" />
                </div>
                <div class="form-group col-sm-3">
                    <label for="weight" class="required">Weight</label>
                    <input type="text" id="weight" name="weight" class="form-control money" value="<?= isset($row['weight']) ? $row['weight'] : "" ?>" maxlength="5" />
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-4">
                    <label for="image" class="required">Main Image</label>
                    <div class="input-group">
                        <input type="text" id="image" name="image" value="<?= isset($row['image']) ? $row['image'] : "" ?>" class="form-control" required readonly />
                        <span class="input-group-btn">
                            <a href="<?= file_manager('image') ?>" class="btn btn-primary upload-btn"><i class="fa fa-picture-o"></i> Choose</a>
                        </span>
                    </div>
                    <div style="background: #ccc; display: inline-block; padding: 5px; margin-top: 10px;">
                        <img class="img-responsive" id="image-preview" style="max-height: 100px;" src="<?= isset($row['image']) ? uploaded_url($row['image']) : '' ?>" />
                    </div>
                </div>

                <div class="form-group col-sm-3">
                    <label for="categories">Category</label>
                    <select id="categories" name="categories[]" class="form-control">
                        <?php foreach ($categories as $cid => $cname) { ?>
                        <option value="<?= $cid ?>" <?= isset($row['categories']) && in_array($cid, $row['categories']) ? 'selected' : '' ?>><?= $cname ?></option>
                        <?php } ?>
                    </select>
                </div>

                <div class="form-group col-sm-3">
                    <label for="price">Price</label>
                    <input type="text" id="price" name="price" class="form-control numberonly" value="<?= isset($row['price']) ? $row['price'] : "" ?>" maxlength="5" required />
                </div>
                
                
                <div class="form-group col-sm-3">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="1" <?= isset($row['status']) && $row['status'] == 1 ? 'selected' : '' ?>>Active</option>
                        <option value="0" <?= isset($row['status']) && $row['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                    </select> 
                </div>
            </div>

            <h4>Other Images</h4>

            <div id="other_images" class="row">
                <?php if(isset($row['images'])) { ?>
                    <?php foreach ($row['images'] as $k => $img) { ?>
                    <div class="form-group col-sm-4 img-form-group">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <a href="<?= file_manager('oimage' . $k) ?>" class="btn btn-primary upload-btn"><i class="fa fa-picture-o"></i> Choose</a>
                            </span>
                            <input type="text" id="oimage<?= $k ?>" name="images[<?= $k ?>][image]" value="<?= $img['image'] ?>" class="form-control" readonly />
                            <span class="input-group-btn">
                                <a href="javascript:void(0)" class="btn btn-danger remove-img"><i class="fa fa-timex"></i></a>
                            </span>
                        </div>
                        <div style="background: #ccc; display: inline-block; padding: 5px; margin-top: 10px;">
                            <img class="img-responsive" id="oimage<?= $k ?>-preview" style="max-height: 100px;" src="<?= $img['image'] ? uploaded_url($img['image']) : '' ?>" />
                        </div>
                        <input type="hidden" name="images[<?= $k ?>][id]" value="<?= $img['id'] ?>" />
                    </div>
                    <?php } ?>
                <?php } ?>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <a href="javascript:void(0)" class="btn btn-primary another-img" style="margin-bottom: 20px;">+ Add Another Image</a>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    <button type="submit" name="submit" class="btn btn-primary">Save</button> 
                    <a href="<?= admin_url('products') ?>" class="btn btn-default">Cancel</a>
                </div>
            </div>
        <?= form_close() ?>
    </div>
</div>

<script type="text/javascript">
var imgcnt = <?= isset($row['images']) ? count($row['images']) : 0 ?>;
$(function(){
    $('.another-img').click(function(){
        if($('#other_images .upload-btn').length < 4) {
            var img  = '<div class="form-group col-sm-4 img-form-group">';
                img += '  <div class="input-group">';
                img += '    <span class="input-group-btn">';
                img += '      <a href="<?= file_manager('oimage') ?>' + imgcnt + '" class="btn btn-primary upload-btn"><i class="fa fa-picture-o"></i> Choose</a>';
                img += '    </span>';
                img += '    <input type="text" id="oimage' + imgcnt + '" name="images[' + imgcnt + '][image]" class="form-control image" readonly />';
                img += '    <span class="input-group-btn">';
                img += '      <a href="javascript:void(0)" class="btn btn-danger remove-img"><i class="fa fa-times"></i></a>';
                img += '    </span>';
                img += '  </div>';
                img += '  <div style="background: #ccc; display: inline-block; padding: 5px; margin-top: 10px;">';
                img += '    <img class="img-responsive" id="oimage' + imgcnt + '-preview" style="max-height: 100px;" src="" />';
                img += '  </div>';
                img += '  <input type="hidden" name="images[' + imgcnt + '][id]" value="" />';
                img += '</div>';

            $('#other_images').append(img);
            imgcnt++;

            $('#other_images .upload-btn').fancybox({ 
                width: 900,
                minHeight: 600,
                type: 'iframe',
                autoScale: true
            });
        } else {
            alert('You can only add maximum 4 images.');
        }
    });

    $('.clear-img').click(function(){
        if($('#image').val() != '' ) {
            if(confirm('Are you sure you want to remove this image?')) {
                $('#image').val('');
                $('#image-preview').attr('src', '');
            }
        }
    });

    $(document).on('click', '.remove-img', function() {
        if(confirm('Are you sure you want to remove this image?')) {
            $(this).parents('.img-form-group').remove();
        }
    });
});
</script>