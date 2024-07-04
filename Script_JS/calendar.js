class Calendar {
    constructor(date) {
        this.activeYear = date ? new Date(date).getFullYear() : new Date().getFullYear();
        this.activeMonth = date ? new Date(date).getMonth() + 1 : new Date().getMonth() + 1;
        this.activeDay = date ? new Date(date).getDate() : new Date().getDate();
        this.monthYear = this.activeYear + '-' + this.activeMonth;
    }

    selectMonthYear(year, month, day) {
        this.activeDay = day;
        this.activeMonth = month;
        this.activeYear = year;
        this.monthYear = year + '-' + month + '-' + day;
        return this.monthYear;
    }

    generateCalendar() {
        const numDays = new Date(this.activeYear, this.activeMonth, 0).getDate();
        const numDaysLastMonth = new Date(this.activeYear, this.activeMonth - 1, 0).getDate();
        const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        const firstDayOfWeek = new Date(this.activeYear, this.activeMonth - 1, 1).getDay();

        let html = '<div class="calendar">';
        html += '<div class="days">';

        days.forEach(day => {
            html += '<div class="day_name">' + day + '</div>';
        });

        for (let i = firstDayOfWeek; i > 0; i--) {
            html += '<div class="day_num ignore">' + (numDaysLastMonth - i + 1) + '</div>';
        }
        
        for (let i = 1; i <= numDays; i++) {
            const selected = (i === this.activeDay && this.activeMonth === new Date().getMonth() + 1 && this.activeYear === new Date().getFullYear()) ? ' selected' : '';

            html += '<div class="day_num ' + selected + ' contain_day" data-bs-toggle="modal" data-bs-target="#model-set-time" onclick="ShowDataDate('+i+')">';
            html += '<a href="#" id="today" style="text-decoration:none">' + i + '</a>';
            html += '</div>';
        }

        for (let i = 1; i <= (42 - numDays - Math.max(firstDayOfWeek, 0)); i++) {
            html += '<div class="day_num ignore">' + i + '</div>';
        }

        html += '</div>';
        html += '</div>';
        return html;
    }   
}