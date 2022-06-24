let currentTab = 0;
if (sessionStorage.getItem('currentTab')) {
    currentTab = +sessionStorage.getItem('currentTab');
} else if (+sessionStorage.getItem('currentTab') === 2) {
    currentTab = 0;
    sessionStorage.setItem('currentTab', '0');
}
showTab(currentTab);


const countryList = document.querySelector('.country');

fetch('https://restcountries.com/v3.1/all').then(res => {
    return res.json();
}).then(data => {
    let output = '<option selected disabled value="default" hidden>Choose Country</option>`';

    data.sort((a, b) => (a.name.common > b.name.common) ? 1 : -1)
        .forEach(country => {
            output += `<option value="${country.name.common}">${country.name.common}</option>`;
            countryList.innerHTML = output;
        });
}).catch(err => {
    console.log(err.message)
});

let inputFirstName = document.getElementById('firstNameIsValid');
inputFirstName.oninvalid = function (event) {
    event.target.setCustomValidity("First Name should contain latin letters or '`- symbols and be maximum 30 symbols long.");
}
inputFirstName.oninput = function (event) {
    event.target.setCustomValidity('');
}

let inputLastName = document.getElementById('lastNameIsValid');
inputLastName.oninvalid = function (event) {
    event.target.setCustomValidity("Last Name should contain latin letters or ' symbol and be maximum 30 symbols long.");
}
inputLastName.oninput = function (event) {
    event.target.setCustomValidity('');
}

let inputNumber = document.getElementById('phoneIsValid');
inputNumber.oninvalid = function (event) {
    event.target.setCustomValidity("Phone number should contain 11 digits");
}
inputNumber.oninput = function (event) {
    event.target.setCustomValidity('');
}

let inputEmail = document.getElementById('emailIsValid');
inputEmail.oninvalid = function (event) {
    event.target.setCustomValidity("Email should only contain latin letters, digits and @ symbol.");
}
inputEmail.oninput = function (event) {
    event.target.setCustomValidity('');
}

let inputDate = document.getElementById('dateIsValid');
inputDate.oninvalid = function (event) {
    event.target.setCustomValidity("Maximum available date is 01-01-2005");
}
inputDate.oninput = function (event) {
    event.target.setCustomValidity('');
}

$(function () {
    $("#phoneIsValid").mask("+0 (000) 000-0000");
});

document.getElementById('imgLoad').addEventListener('change', updateSize);

function showTab(n) {

    const x = document.getElementsByClassName("tab");
    x[n].style.display = "block";

    if (n === 0) {
        document.getElementById("nextBtn").style.display = "inline";
        document.getElementById("step2Btn").style.display = "none";
    } else if (n === 1) {
        document.getElementById("nextBtn").style.display = "none";
        document.getElementById("step2Btn").style.display = "inline";
    }
    if (n === (x.length - 1)) {
        document.getElementById("step2Btn").style.display = "none";
        document.getElementById("regHeader").style.display = "none";
    }
    fixStepIndicator(n);
    getCount();
}

function nextPrev(n, result = true) {

    let x = document.getElementsByClassName("tab");

    if (currentTab === 0) {
        let resultOfAjax = result;
        if (typeof resultOfAjax === 'object') {
            toggleErrors(resultOfAjax);

            return false;
        } else if (resultOfAjax === 1) {
            x[currentTab].style.display = "none";
            toggleErrors(resultOfAjax);
        }
    } else if (currentTab === 1) {
        x[currentTab].style.display = "none";
    }
    currentTab = currentTab + 1;
    sessionStorage.setItem('currentTab', currentTab.toString());
    if (+sessionStorage.getItem('currentTab') === 2) {
        sessionStorage.setItem('currentTab', '0');
    }
    showTab(currentTab);
}

function fixStepIndicator(n) {

    let i, x = document.getElementsByClassName("step");
    for (i = 0; i < x.length; i++) {
        x[i].className = x[i].className.replace(" active", "");
    }
    x[n].className += " active";
}

let noErrors = {
    country: "",
    date: "",
    email: "",
    firstName: "",
    lastName: "",
    phone: "",
    subject: "",
}

function sendData(n) {
    let oldForm = document.forms.form;
    let formData = new FormData(oldForm);
    let file_data = $('#imgLoad').prop('files')[0];
    formData.append("photo", file_data);
    let result;

    for (let value of formData.entries()) {
        sessionStorage.setItem(value[0], value[1].toString());
    }

    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        url: 'send',
        data: formData,
        success: function (data) {
            if (typeof data === 'string') {
                result = JSON.parse(data);
                toggleErrors(noErrors);
                nextPrev(n, result);
                return false;
            } else if (data === 1) {
                return true;
            }
        }
    });
    if (result === 1) {
        return true;
    }
    return result;
}

function toggleErrors(data) {
    for (let prop in data) {
        if (!!data[prop]) {

            $(`#${prop}IsValid`).addClass('invalid');
            $(`#${prop}Error`).html(data[prop])
        } else if (data[prop] === '') {

            $(`#${prop}IsValid`).removeClass('invalid');
            $(`#${prop}Error`).html(data[prop])
        }
    }
}

function updateData(n) {
    let oldForm = document.forms.form;
    let formData = new FormData(oldForm);
    let file_data = $('#imgLoad').prop('files')[0];
    formData.append("photo", file_data);

    // Too much hard-code.
    // Tried to iterate through formData array using for .. of ..,
    // but it leads app to crush, sooo I left it like this for now

    formData.append('data[firstName]', sessionStorage.getItem('data[firstName]'));
    formData.append('data[lastName]', sessionStorage.getItem('data[lastName]'));
    formData.append('data[subject]', sessionStorage.getItem('data[subject]'));
    formData.append('data[date]', sessionStorage.getItem('data[date]'));
    formData.append('data[phone]', sessionStorage.getItem('data[phone]'));
    formData.append('data[email]', sessionStorage.getItem('data[email]'));
    formData.append('data[country]', sessionStorage.getItem('data[country]'));

    let fileUploaded = document.getElementById("imgLoad").files[0];
    if (fileUploaded) {
        if (fileUploaded.size > 10485760) {
            let fileSize = fileUploaded.size / 1048576;
            document.getElementById('fileWarning').innerHTML = `Max file size is 10 MB. Your is ${fileSize.toFixed(2)} MB`
            return false;
        } else {
            upload(formData, n);
        }
    } else {
        upload(formData, n);
    }
}

function upload(formData, n) {
    $.ajax({
        type: "POST",
        processData: false,
        contentType: false,
        cache: false,
        url: 'update',
        data: formData,
        success: function (data) {
            if (data) {
                console.log(data);
                $('#imgLoad').addClass('invalid');
                $('#fileWarning').html(data);
            } else {
                nextPrev(n);
                sessionStorage.removeItem('data[firstName]');
                sessionStorage.removeItem('data[lastName]');
                sessionStorage.removeItem('data[subject]');
                sessionStorage.removeItem('data[date]');
                sessionStorage.removeItem('data[phone]');
                sessionStorage.removeItem('data[email]');
                sessionStorage.removeItem('data[country]');
            }
        }
    });
}

function getCount() {
    $.get("get", function (data) {
        $("#membersCount").html(data);
    });
}

function noDigits(event) {
    if ("1234567890".indexOf(event.key) !== -1)
        event.preventDefault();
}

function updateSize() {
    var file = document.getElementById("imgLoad").files[0],
        ext = "не определилось",
        parts = file.name.split('.');
    if (parts.length > 1) {
        ext = parts.pop();
    }
    document.getElementById("e-fileinfo").innerHTML = [
        "File size: " + (file.size / 1048576).toFixed(2) + " Mb",
        "Extension: " + ext
    ].join("<br>");
}

