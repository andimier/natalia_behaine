$( "#datepicker" ).datepicker({
    currentText: "Now",
    dateFormat: "yy-mm-dd",
    showWeek: true,
    dayNames: [ "Dimanche", "Lundi", "Mardi", "Mercredi", "Jeudi", "Vendredi", "Samedi" ],
    dayNamesMin: [ "Di", "Lu", "Ma", "Me", "Je", "Ve", "Sa" ],
    monthNames: [ "Januar", "Februar", "Marts", "April", "Maj", "Juni", "Juli", "August", "September", "Oktober", "November", "December" ],
    showButtonPanel: true,
    onSelect: selectDate
});

var selectedDateAndHour = [];
var selectedHours = [];

function toggleSelectedDateHours (date, datePicker) {
    
    if (selectedHours.length) {
        // Hide selected hors
        selectedHours.forEach(function(item) {
            item.classList.add('hidden');
            item.classList.remove('selected');
        });
    }
    
    var selectedDayHours = document.querySelectorAll('.hour-wrapper[data-date="' + date + '"]');
    var _selectedHours = Array.from(selectedDayHours);

    _selectedHours.forEach(function(item) {
        item.classList.remove('hidden');
        item.classList.add('selected');
    });

    selectedHours = _selectedHours;

}

function selectDate(date, datePicker) {
    document.querySelector('.summary-date').innerHTML = '';
    document.querySelector('.summary-hour').innerHTML = '';
    toggleSelectedDateHours (date, datePicker);
}

function selectDateAndHour(e) {
    var selectedElement = e.target;
    var dataElement = selectedElement.parentElement;

    selectedDateAndHour = [
        dataElement.dataset.date,
        dataElement.dataset.hour
    ];

    document.querySelector('.summary-date').innerHTML = 'Día seleccionado: ' + dataElement.dataset.date;
    document.querySelector('.summary-hour').innerHTML = 'Hora seleccinada: ' + dataElement.dataset.hour;
}

function setEvents() {
    document.querySelector('.hours-wrapper').addEventListener('click', selectDateAndHour);
}

function pad(number) {
    if (number < 10) {
      return '0' + number;
    }
    return number;
}

(function selectCurrentDay() {
    var date = new Date();
    var selectedDate = [
        date.getFullYear(),
        date.getMonth(), 
        date.getDate()
    ];

    var parsedDate = selectedDate.map(function(item, i) {
        if (i === 0) return item;
        if (i === 1) return pad(item + 1);
        return pad(item);
    }).join('-');

    selectDate(parsedDate, {});

    setEvents();
})();

