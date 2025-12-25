$(document).ready(function () {
    // Month filter
    $('#monthSelect').on('change', function () {
        var selectedMonth = $(this).val();
        $('.schedule-date').each(function () {
            var scheduleMonth = $(this).data('month');
            if (selectedMonth === 'all' || scheduleMonth === selectedMonth) {
                $(this).show();
            } else {
                $(this).hide();
                $(this).find('input[name="schedule_date"]').prop('checked', false);
            }
        });
        // Auto-select first visible schedule
        var firstVisible = $('.schedule-date:visible').first();
        if (firstVisible.length) {
            firstVisible.find('input[name="schedule_date"]').prop('checked', true).trigger('change');
        }
    });
    // Trigger change on page load
    $('#monthSelect').trigger('change');
    $('.schedule-time').each(function () {
        var scheduleMonth = $(this).data('month');
        if (scheduleMonth === selectedMonth) {
            $(this).show();
        } else {
            $(this).hide();
            $(this).find('input[name="schedule_id"]').prop('checked', false);
        }
    });

});