<div class="d-flex text-center mt-2 gap-3 schedule">
    @if ($schedulesByDate->isNotEmpty())
    @php $first = true; @endphp
    @foreach ($schedulesByDate as $date => $schedules)
    @if (\Carbon\Carbon::parse($date)->gte(\Carbon\Carbon::today()))
    <label class="schedule-date">
        <input type="radio"
            name="schedule_date"
            value="{{ $date }}"
            hidden
            required
            @if($first) checked @php $first=false; @endphp @endif>
        <span class="fs-6">{{ \Carbon\Carbon::parse($date)->format('d') }}</span>
        <p class="text">{{ \Carbon\Carbon::parse($date)->format('l') }}</p>
    </label>
    @endif
    @endforeach
    @else
    <span class="text-center text-warning">No schedules available</span>
    @endif
</div>