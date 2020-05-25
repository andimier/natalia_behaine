$( "#datepicker" ).datepicker({
    currentText: "Now",
    dateFormat: "yy-mm-dd",
    showWeek: false,
    dayNames: [ 
        "Domingo", 
        "Lunes", 
        "Martes", 
        "Miércoles", 
        "Jueves", 
        "Viernes", 
        "Sábado" 
    ],
    dayNamesMin: [ 
        "Do", 
        "Lu", 
        "Ma", 
        "Mi", 
        "Ju", 
        "Vi", 
        "Sá" 
    ],
    monthNames: [ 
        "Enero", 
        "Febrero", 
        "Marzo", 
        "Abril", 
        "Mayo", 
        "Junio", 
        "Julio", 
        "Agosto", 
        "Septiembre", 
        "Octubre", 
        "Noviembre", 
        "Diciembre" 
    ],
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
    
    var selectedDayHours = document.querySelectorAll('.time-wrapper[data-slot-date="' + date + '"]');
    var _selectedHours = Array.from(selectedDayHours);

    _selectedHours.forEach(function(item) {
        item.classList.remove('hidden');
        item.classList.add('selected');
    });

    selectedHours = _selectedHours;
}

function selectDate(date, datePicker) {
    document.querySelector('.summary-date').innerHTML = '';
    document.querySelector('.summary-time').innerHTML = '';

    document.querySelector('.submit-order').classList.add('hidden');

    toggleSelectedDateHours (date, datePicker);
}

function selectDateAndHour(e) {
    var selectedElement = e.target;
    var dataElement = selectedElement.parentElement;
    var selectedId = dataElement.dataset.slotId
    var selectedDate = dataElement.dataset.slotDate
    var selectedTime = dataElement.dataset.slotTime;

    selectedDateAndHour = [
        selectedDate,
        selectedTime

    ];

    document.querySelector('.summary-date').innerHTML = 'Día seleccionado: ' + selectedDate;
    document.querySelector('.summary-time').innerHTML = 'Hora seleccinada: ' + selectedTime;
    document.querySelector('.slot-data[name="slot-id"]').value = selectedId;
    document.querySelector('.slot-data[name="slot-date"]').value = selectedDate;
    document.querySelector('.slot-data[name="slot-time"]').value = selectedTime;

    document.querySelector('.submit-order').classList.remove('hidden');
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

