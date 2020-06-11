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

var UserInfo = function(data) {
    this.slotId = data.slotId;
    this.name = data.name;
    this.email = data.email;
    this.phone = data.phone;

    if (this.details) {
        this.details = data.details;
    }
}

UserInfo.prototype.insertUser = function() {
    var _this = this;

    return new Promise(function(resolve, reject) {
        
        if (_this.slotId) {
            var xhr = new XMLHttpRequest();

            xhr.addEventListener("readystatechange", function() {
                if (this.readyState === this.DONE) {
                    var response = this.responseText;
            
                    if (response) {
                        resolve('User created correctly: ' + response);
                    } else {
                        reject("Could not crate user");
                    }
                }
            });

            var formatData = new FormData();
            formatData.append('insertUser', 'true');
            formatData.append('slotId', _this.slotId);
            formatData.append('userName', _this.name );
            formatData.append('userEmail', _this.email);
            formatData.append('userPhone', _this.phone);

            if (_this.details) {
                formatData.append('userDetails', _this.details);
            }
    
            xhr.open("POST", "crud/rw-slot-data.php");
            xhr.send(formatData);
        }
    });
}

UserInfo.prototype.validateInsertion = function() {
    if (this.readyState === this.DONE) {
        var response = this.responseText;

        if (response) {
            console.log('User created correctly: ', response);
        } else {
            console.warn("Could not crate user");
        }
    }
}

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

    if (!_selectedHours.length) {
        document.querySelector('.slots-error-message').classList.remove('hidden');
    } else {
        document.querySelector('.slots-error-message').classList.add('hidden');

        _selectedHours.forEach(function(item) {
            item.classList.remove('hidden');
            item.classList.add('selected');
        });
    }

    selectedHours = _selectedHours;
}

function selectDate(date, datePicker) {
    document.querySelector('.summary-date').innerHTML = '';
    document.querySelector('.summary-time').innerHTML = '';

    document.querySelector('#submit-order').classList.add('hidden');

    toggleSelectedDateHours (date, datePicker);
}

function selectDateAndHour(e) {
    var selectedElement = e.target;
    var dataElement = selectedElement.parentElement;
    var selectedType = dataElement.dataset.slotType
    var selectedId = dataElement.dataset.slotId
    var selectedDate = dataElement.dataset.slotDate
    var selectedTime = dataElement.dataset.slotTime;

    selectedDateAndHour = [
        selectedDate,
        selectedTime
    ];

    document.querySelector('.summary-date').innerHTML = 'Día seleccionado: ' + selectedDate;
    document.querySelector('.summary-time').innerHTML = 'Hora seleccinada: ' + selectedTime;
    
    document.querySelector('.slot-data[name="slot-type"]').value = selectedType;
    document.querySelector('.slot-data[name="slot-id"]').value = selectedId;
    document.querySelector('.slot-data[name="slot-date"]').value = selectedDate;
    document.querySelector('.slot-data[name="slot-time"]').value = selectedTime;

    document.querySelector('#submit-order').classList.remove('hidden');
}

function validateInfo(e) {
    var items = Array.from(e.target.querySelectorAll('.payer-info-field'));
    var errors = [];
    var hasEmailCharacters = false;
    var data = {};

    event.preventDefault();

    items.forEach(function(el) {
        console.log(el.className + ': ' +el.value);

        if (!el.value.length || !el.value) {
            errors.push(el.className);
        }

        // strip html tags
        var str = el.value;
        var validStr = str.replace(/(<([^>]+)>)/ig,"");
        el.value = validStr;

        if (el.name === 'payer-email') {
            hasEmailCharacters = el.value.includes('.') && el.value.includes('@'); 
        }

        data[el.name.split('-')[1]] = el.value;
    });

    if (errors.length || !hasEmailCharacters) {
        var message = errors.length ? 'Los datos están incompletos.' : '';
        message = (!hasEmailCharacters) ? message + ' El correo ingresado no es válido' : message;

        alert(message);
    } else {
        data['slotId'] = e.target.querySelector("[name='slot-id'").value;

        var userInfo = new UserInfo(data);
        var insertedUser = userInfo.insertUser();

        insertedUser.then(function(val) {
            e.target.submit();
        });

        insertedUser.catch(function(reason) {
            console.log(reason);
        });
    }
}

function setEvents() {
    document.querySelector('.hours-wrapper').addEventListener('click', selectDateAndHour);
    document.querySelector('#submit-order').addEventListener('submit', validateInfo);
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

