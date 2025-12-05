;(function ($) {
    $(function($) {
        // Tab switching
        $('.opton-tab-link').on('click', function(e) {
            e.preventDefault();
            var pageId = $(this).data('page');

            $('.opton-tab-link').removeClass('opton-tab-active').css('background', '#f5f5f5');
            $(this).addClass('opton-tab-active').css('background', '#fff');

            $('.opton-page').hide();
            $('#opton-page-' + pageId).show();
        });

        // Repeater: Add row
        $(document).on('click', '.opton-repeater-add', function(e) {
            e.preventDefault();
            var repeaterId = $(this).data('repeater-id');
            var template = $('#' + repeaterId + '-template').html();
            var repeater = $('.opton-repeater[data-repeater-id=\"' + repeaterId + '\"]');
            var items = repeater.find('.opton-repeater-items');
            var currentIndex = items.find('.opton-repeater-row').length;

            // Replace {{INDEX}} with actual index
            var newRow = template.replace(/\{\{INDEX\}\}/g, currentIndex);

            items.append(newRow);
            updateRepeaterRowNumbers(repeaterId);
        });

        // Repeater: Remove row
        $(document).on('click', '.opton-repeater-remove', function(e) {
            e.preventDefault();
            var row = $(this).closest('.opton-repeater-row');
            var repeater = row.closest('.opton-repeater');
            var repeaterId = repeater.data('repeater-id');

            // Don't allow removing the last row
            if (repeater.find('.opton-repeater-row').length > 1) {
                row.remove();
                updateRepeaterRowNumbers(repeaterId);
                reindexRepeaterFields(repeaterId);
            } else {
                alert('You must have at least one row.');
            }
        });

        // Update row numbers after add/remove
        function updateRepeaterRowNumbers(repeaterId) {
            var repeater = $('.opton-repeater[data-repeater-id=\"' + repeaterId + '\"]');
            repeater.find('.opton-repeater-row').each(function(index) {
                $(this).find('.opton-repeater-row-number').text('Row #' + (index + 1));
            });
        }

        // Reindex field names after remove
        function reindexRepeaterFields(repeaterId) {
            var repeater = $('.opton-repeater[data-repeater-id=\"' + repeaterId + '\"]');
            repeater.find('.opton-repeater-row').each(function(index) {
                $(this).find('input, select, textarea').each(function() {
                    var name = $(this).attr('name');
                    if (name) {
                        // Replace the index in brackets
                        var newName = name.replace(/\[\\d+\]/, '[' + index + ']');
                        $(this).attr('name', newName);
                    }
                });
            });
        }

        // Conditional fields logic
        function checkConditionalFields() {
            $('.conditional-field').each(function() {
                var field = $(this);
                var conditions = field.data('conditions');

                if (conditions && conditions.length > 0) {
                    var showField = true;

                    $.each(conditions, function(index, condition) {
                        var targetField = $('#' + condition.field);
                        var targetValue = targetField.is(':checkbox') || targetField.is(':radio')
                            ? (targetField.is(':checked') ? targetField.val() : '')
                            : targetField.val();

                        var conditionMet = (targetValue == condition.value);

                        if (condition.type === 'hide') {
                            showField = !conditionMet;
                        } else {
                            showField = conditionMet;
                        }
                    });

                    if (showField) {
                        field.show();
                    } else {
                        field.hide();
                    }
                }
            });
        }

        checkConditionalFields();
        $(document).on('change', 'input, select, textarea', checkConditionalFields);
    });
}(jQuery));
