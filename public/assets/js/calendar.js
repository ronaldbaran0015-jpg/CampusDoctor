
/* =======================
    CALENDAR SETUP
======================= */
const calendarEl = document.getElementById("calendar");
const availableDates = JSON.parse(calendarEl.dataset.availableDates);
const daysTag = calendarEl.querySelector(".days");
const currentDate = calendarEl.querySelector(".current-date");
const prevNextIcon = calendarEl.querySelectorAll(".icons i");

/* =======================
   VIEW SWITCHING
======================= */
const switchBtn = document.getElementById('switch-view');
const simpleView = document.getElementById('simpleView');
const calendarView = document.getElementById('calendarView');

switchBtn.addEventListener('click', () => {
    simpleView.classList.toggle('d-none');
    calendarView.classList.toggle('d-none');
});

/* =======================
   DATE VARIABLES
======================= */
let date = new Date(),
    currYear = date.getFullYear(),
    currMonth = date.getMonth();

const months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

/* =======================
   MONTH DROPDOWN SYNC
======================= */
const monthSelect = document.getElementById("monthSelect");

const monthMap = {
    January: 0, February: 1, March: 2, April: 3,
    May: 4, June: 5, July: 6, August: 7,
    September: 8, October: 9, November: 10, December: 11
};

if (monthSelect) {
    monthSelect.addEventListener("change", function () {
        const [monthName, year] = this.value.split(" ");
        currMonth = monthMap[monthName];
        currYear = parseInt(year, 10);
        renderCalendar();
    });
}

/* =======================
   RENDER CALENDAR
======================= */
function renderCalendar() {
    let firstDay = new Date(currYear, currMonth, 1).getDay(),
        lastDate = new Date(currYear, currMonth + 1, 0).getDate(),
        lastDay = new Date(currYear, currMonth, lastDate).getDay(),
        prevLastDate = new Date(currYear, currMonth, 0).getDate();

    let liTag = "";

    // PREVIOUS MONTH DAYS
    for (let i = firstDay; i > 0; i--) {
        liTag += `<li class="inactive">${prevLastDate - i + 1}</li>`;
    }

    // CURRENT MONTH DAYS
    for (let day = 1; day <= lastDate; day++) {
        const fullDate =
            currYear + "-" +
            String(currMonth + 1).padStart(2, "0") + "-" +
            String(day).padStart(2, "0");

        const today = new Date();
        today.setHours(0, 0, 0, 0);

        const cellDate = new Date(currYear, currMonth, day);
        cellDate.setHours(0, 0, 0, 0);

        const isPast = cellDate < today;
        const isAvailable = availableDates.includes(fullDate);

        if (isPast) {
            // 🔒 PAST DATE
            liTag += `<li class="past">${day}</li>`;

        } else if (isAvailable) {
            // ✅ AVAILABLE DATE
            liTag += `
              <li class="available">
                <label>
                  <input type="radio" name="schedule_date" value="${fullDate}" required>
                  <span>${day}</span>
                </label>
              </li>
            `;
        } else {
            // ❌ NOT AVAILABLE
            liTag += `<li class="inactive">${day}</li>`;
        }
    }

    // NEXT MONTH DAYS
    for (let i = lastDay; i < 6; i++) {
        liTag += `<li class="inactive">${i - lastDay + 1}</li>`;
    }

    currentDate.innerText = `${months[currMonth]} ${currYear}`;
    daysTag.innerHTML = liTag;

    /* 🔄 SYNC DROPDOWN WITH CALENDAR */
    if (monthSelect) {
        const value = `${months[currMonth]} ${currYear}`;
        if ([...monthSelect.options].some(opt => opt.value === value)) {
            monthSelect.value = value;
        }
    }
}

/* =======================
   PREV / NEXT NAVIGATION
======================= */
prevNextIcon.forEach(icon => {
    icon.addEventListener("click", () => {
        currMonth = icon.id === "prev" ? currMonth - 1 : currMonth + 1;

        if (currMonth < 0 || currMonth > 11) {
            date = new Date(currYear, currMonth);
            currYear = date.getFullYear();
            currMonth = date.getMonth();
        }

        renderCalendar();
    });
});

/* =======================
   INITIAL LOAD
======================= */
renderCalendar();