document.addEventListener("DOMContentLoaded", () => {
    const dateRadios = document.querySelectorAll("input[name='schedule_date']");
    const tabs = document.querySelectorAll(".tab-btn");
    const schedules = document.querySelectorAll(".schedule-time");
    let activeSession = "Morning"; // default tab
    function filterSchedules() {
        const selectedDate = document.querySelector("input[name='schedule_date']:checked")?.value;
        let hasAny = false;
        schedules.forEach(sch => {
            if (sch.dataset.date === selectedDate && sch.dataset.session === activeSession) {
                sch.classList.remove("d-none");
                hasAny = true;
            } else {
                sch.classList.add("d-none");
            }
        });

        // Placeholder message
        const container = document.querySelector(".schedule-list");
        let placeholder = container.querySelector(".no-schedule");
        if (!hasAny) {
            if (!placeholder) {
                placeholder = document.createElement("span");
                placeholder.className = "text-warning no-schedule";
                container.appendChild(placeholder);
            }
            placeholder.innerText = `No schedules available in the ${activeSession.toLowerCase()}`;
        } else {
            if (placeholder) placeholder.remove();
        }
    }
    // Handle tab clicks
    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            tabs.forEach(t => t.classList.remove("active"));
            tab.classList.add("active");
            activeSession = tab.dataset.target;
            filterSchedules();
        });
    });
    // Handle date change
    dateRadios.forEach(radio => {
        radio.addEventListener("change", filterSchedules);
    });
    // Initial filter
    filterSchedules();
});