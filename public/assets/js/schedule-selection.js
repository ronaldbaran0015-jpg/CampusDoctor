$(document).ready(function () {
    // On schedule selection
    $('input[name="schedule_id"]').change(function () {
        var scheduleId = $(this).val();
        var btn = $('#book-btn');

        // AJAX call to check availability
        $.get('/schedule/check-availability/' + scheduleId, function (data) {
            if (data.isFullyBooked) {
                btn.prop('disabled', true);
                btn.text('Cannot Book - Fully Booked');
            } else {
                btn.prop('disabled', false);
                btn.text('Book Appointment');
            }
        });
    });

    // Trigger change on page load for pre-selected schedule
    $('input[name="schedule_id"]:checked').trigger('change');
});