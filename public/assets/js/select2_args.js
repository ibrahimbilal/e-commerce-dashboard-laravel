'use strict';

jQuery(() => {

    // Function To Return Language Flag
    $('#newitem-lang').select2({
        templateResult: function (item) {
            if (!item.id) {
                return item.text;
            }
            var $span = $("<span><img src='" + $(item.element).data('flag') + "' width='22' class='me-1' /> " + item.text + '</span>');
            return $span;
        },
        templateSelection: function (item) {
            if (!item.id) {
                return item.text;
            }
            var $span = $("<span><img src='" + $(item.element).data('flag') + "' width='22' class='me-1' /> " + item.text + '</span>');
            return $span;
        },
        minimumResultsForSearch: -1
    });

    // Select 2 Tags
    $('#product-tags-select').select2({
        tags: true,
        tokenSeparators: [','],
        placeholder: "Separate tags with comma (,)",
    }).on('change', function () {
        var $selected = $(this).find('option:selected');
        var $container = $(this).siblings('.selected-tags-container');

        var $list = $('<ul class="tags-list mt-3 mb-0">');
        $selected.each(function (k, v) {
            var $li = $('<li class="tag-item mb-1 me-1"><span class="tag-name">' + $(v).text() + '</span><span data-value="' + $(v).val() + '" class="destroy-tag-selected icon ms-2"><i class="fi-rr-cross-circle"></i></span></li>');
            $li.children('span.destroy-tag-selected')
                .off('click.select2-copy')
                .on('click.select2-copy', function (e) {
                    var $select = $('#product-tags-select');
                    var values = $select.val();
                    var idToRemove = $(this).data('value');
                    if (values) {
                        var i = values.indexOf(idToRemove);
                        if (i >= 0) {
                            values.splice(i, 1);
                            $select.val(values).trigger('change');
                        }
                    }
                });
            $list.append($li);
        });
        $container.html('').append($list);
    }).trigger('change');

    // Select 2 Sizes && Colors
    var productAttributes = $('.select2-wrapper').find('select');
    var selectIDArray = []; // empty array 
    productAttributes.each(function(k, v) {
        var selectID = $(this).attr('id'); // select element id
        selectIDArray.push('#' + selectID); // add select element id to array with # 
        $('#' + selectID).select2({
            width: "100%",
            tags: true,
            placeholder: $(this).attr('placeholder'),
            createTag: function () {
                // Disable tagging
                return undefined;
            },
            templateResult: function (data) {
                if ( data._resultId !== undefined ) {
                    if ( data._resultId.indexOf('colors') > 0 ) {
                        return $('<span class="tag-name" style="background-color:'+ data.id +';width: 17px;height: 17px;display: inline-block;border-radius: 50%;position: relative;left: -5px;vertical-align: middle;margin-left:5px"></span style="margin-left:5px"><span>'  + data.text + '</span>');
                    } else {
						return data.text;
					}
                }
            },
            templateSelection: function (data, container) {
                if ( data._resultId.indexOf('colors') < 0 ) {
                    container.html('<span class="tag-name">' + data.text + '</span><span class="select2-selection__choice__remove icon ms-2"><i class="fi-rr-cross-circle"></i></span>');
                } else {
                    container.html('<span class="tag-name" style="background-color:'+ data.id +';width: 25px;height: 25px;display: inline-block;border-radius: 50%;position: relative;left: -5px;vertical-align: middle;"></span><span class="select2-selection__choice__remove icon"><i class="fi-rr-cross-circle"></i></span>');
                }
            },
        });
    });

    // convert selectIDArray to string (separated with comma)
    // prevent search in attributs
    $(selectIDArray.toString()).on('select2:opening select2:closing', function( event ) {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
    });

    // Normal Select 2 Dropdown
    $('.normal-dropdown').select2({
        minimumResultsForSearch: -1
    });
});

