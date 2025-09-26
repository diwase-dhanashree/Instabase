function slugify(text) {
    return text.toString().toLowerCase()
        .replace(/\s+/g, '-')
        .replace(/[^\w\-]+/g, '')
        .replace(/\-\-+/g, '-')
        .replace(/^-+/, '')
        .replace(/-+$/, '');
}

var ckeOptions = {
    filebrowserImageBrowseUrl: '/assets/js/filemanager/dialog.php?akey=d357621c8fdb0300fe9db6d81a063a73&type=1&editor=ckeditor',
    filebrowserBrowseUrl: '/assets/js/filemanager/dialog.php?akey=d357621c8fdb0300fe9db6d81a063a73&type=1&editor=ckeditor',
};

$(function(){
    if($('textarea.editor').length) {
        $('textarea.editor').ckeditor(ckeOptions);
    }

    if($('.upload-btn').length) {
        $('.upload-btn').fancybox({ 
            width: 900,
            minHeight: 600,
            type: 'iframe',
            autoScale: true
        });
    }

    $('.remove-upload-btn').click(function() {
        var p = $(this).parents('.input-group').parent('.form-group');
        p.find('.form-control').val('');
        p.find('.img-responsive').attr('src', '');
    });

    if($('.select2').length) {
        $('.select2').select2();
    }

    $(document).on('keydown', ".numberonly", function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110]) !== -1 ||
            // Allow: Ctrl+A, Command+A
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
            // let it happen, don't do anything
            return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });

    $(document).on('keypress', ".money", function (e) {
        e = (e) ? e : window.event;
        var charCode = (e.which) ? e.which : e.keyCode;
        if (charCode == 8 || charCode == 37) {
            return true;
        } else if (charCode == 46 && $(this).val().indexOf('.') != -1) {
            return false;
        } else if (charCode > 31 && charCode != 46 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    });

    $(document).on('blur', ".money", function () {
        var value = parseFloat($(this).val());
        if (!isNaN(value)) {
            $(this).val(parseFloat(value).toFixed(2).replace('.00', ''));
        }
    });
});

function responsive_filemanager_callback(field_id) {
    if($('#' + field_id + '-preview').length) {
        var url = $('#' + field_id).val();
        $('#' + field_id + '-preview').attr('src', '/assets/uploads/' + url);
    }
}