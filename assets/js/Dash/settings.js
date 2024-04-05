$(document).ready(function () {
    $('.cancel-btn, .submit-btn').hide();

    // Edit buttons for table rows and form input groups
    $('.edit-btn').click(function () {
        var container = $(this).closest('.input-group, tr');

        // Check the checkbox state
        if (container.find('#rotationCheckbox').length && !container.find('#rotationCheckbox').prop('checked')) {
            // If checkbox is unchecked, do not allow editing
            RotationToast('Please Enable Rotation First');
            return;
        }

        toggleEditable(container, true);
        showToast(container);

        saveOriginalContent(container);
    });

    // Cancel buttons for table rows and form input groups
    $('.cancel-btn').click(function () {
        var container = $(this).closest('.input-group, tr');
        restoreOriginalContent(container);
        toggleEditable(container, false);
    });

    // Submit buttons for table rows and form input groups
    $('#submitRotation').click(function () {
        var container = $(this).closest('.input-group, tr');
        var rotationIntervalValue = parseInt(container.find('#rotationInterval').val(), 10);

        if (isValidValue(rotationIntervalValue, 15, 300)) {
            saveOriginalContent(container);
            RotationToast('Successfully set the rotation interval to ' + rotationIntervalValue + ' minutes');
            toggleEditable(container, false);
        } else {
            RotationToast('Please enter a value between 15 and 300.');
        }
    });

    $('#submitProgress').click(function () {
        var container = $(this).closest('.input-group, tr');
        var progressThresholdValue = parseInt(container.find('#progressThreshold').val(), 10);

        if (isValidValue(progressThresholdValue, 80, 100)) {
            saveOriginalContent(container);
            ProgressToast('Successfully set the progress value to ' + progressThresholdValue + ' %');
            toggleEditable(container, false);
        } else {
            ProgressToast('Please enter a value between 80 and 100.');
        }
    });

    // Handle checkbox change
    $('#rotationCheckbox').change(function () {
        var message = this.checked ? 'Rotation Enabled' : 'Rotation Disabled';
        RotationToast(message);
    });

});

function toggleEditable(container, isEditable) {
    container.find('td, input[type="text"]').attr('contenteditable', isEditable).prop('disabled', !isEditable);
    container.find('.edit-btn').toggle(!isEditable);
    container.find('.cancel-btn, .submit-btn').toggle(isEditable);
}

function showToast(container) {
    if (container.find('#rotationInterval').length) {
        RotationToast('Please enter a value between 15 and 300.');
    } else if (container.find('#progressThreshold').length) {
        ProgressToast('Please enter a value between 80 and 100.');
    }
}

function saveOriginalContent(container) {
    if (container.is('tr')) {
        container.find('td').each(function () {
            var originalContent = $(this).text();
            $(this).data('original', originalContent);
        });
    } else if (container.is('.input-group')) {
        container.find('input[type="text"]').each(function () {
            var originalContent = $(this).val();
            $(this).data('original', originalContent);
        });
    }
}

function restoreOriginalContent(container) {
    if (container.is('tr')) {
        container.find('td').each(function () {
            var originalContent = $(this).data('original');
            if (originalContent !== undefined) {
                $(this).text(originalContent);
            }
        });
    } else if (container.is('.input-group')) {
        container.find('input[type="text"]').each(function () {
            var originalContent = $(this).data('original');
            if (originalContent !== undefined) {
                $(this).val(originalContent);
            }
        });
    }
}

function isValidValue(value, min, max) {
    return !isNaN(value) && value >= min && value <= max;
}

function RotationToast(message) {
    showToastMessage(message, '#rotationtoast');
}

function ProgressToast(message) {
    showToastMessage(message, '#progresstoast');
}

function showToastMessage(message, toastElement) {
    const popover = $('<div class="popover" role="tooltip"><div class="arrow"></div><h3 class="popover-header"></h3><div class="popover-body"></div></div>');
    popover.find('.popover-body').text(message);
    const buttonPosition = $(toastElement).offset();
    popover.css({
        position: 'absolute',
        top: buttonPosition.top + $(toastElement).height() + 10,
        left: buttonPosition.left
    });
    $('body').append(popover);
    setTimeout(() => {
        popover.remove();
    }, 3000);
}
