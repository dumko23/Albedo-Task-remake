<?php
$title = "Register Form";

include('source/views/layouts/header.php');


?>
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1651.8741415025238!2d-118.34412348513942!3d34.10158833461871!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2bf20e4c82873%3A0x14015754d926dadb!2zNzA2MCBIb2xseXdvb2QgQmx2ZCwgTG9zIEFuZ2VsZXMsIENBIDkwMDI4LCDQodCo0JA!5e0!3m2!1sru!2sua!4v1654499127339!5m2!1sru!2sua"
        width="100%" height="450px" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade"></iframe>
<form id="regForm" name="form" enctype="multipart/form-data" onsubmit="return false" method="post">
    <h1 id="regHeader" style="text-align: center">To participate in the conference, please fill out the form</h1>
    <div class="tab">
        <h3>Step 1</h3>
        <h3>Personal Info:</h3>
        <p><span class="required">*</span> - Required</p>
        <p><label>First name<span class="required">*</span>:
                <input id="firstNameIsValid" name="data[firstName]" placeholder="First name..."
                       pattern="^([\u00C0-\u017Fa-zA-Z]{2,}(?:[-]?[\u00C0-\u017Fa-zA-Z]{2,}))$"
                       maxlength="30" required>
            </label>
            <span>Only latin alphabet and '`- symbols allowed </span>
            <span class="error" id="firstNameError"></span>
        </p>
        <p><label>Last name<span class="required">*</span>:
                <input id="lastNameIsValid" name="data[lastName]" placeholder="Last name..."
                       pattern="^([\u00C0-\u017Fa-zA-Z]{2,}(?:[-]?[\u00C0-\u017Fa-zA-Z]{2,}))$"
                       maxlength="30" required>
            </label>
            <span>Only latin alphabet (including accented characters) and '`- symbols allowed </span>
            <span class="error" id="lastNameError"></span>
        </p>
        <p><label>Birth date<span class="required">*</span>:
                <input id="dateIsValid" name="data[date]" placeholder="Birthdate..."
                       min="1900-01-01" max="2005-01-01" type="date" required>
            </label>
            <span class="error" id="dateError"></span>
        </p>
        <p><label>Report subject<span class="required">*</span>:
                <input id="subjectIsValid" name="data[subject]" placeholder="Repost subject..."
                       required>
            </label>
            <span class="error" id="subjectError"></span>
        </p>
        <p><label>Country<span class="required">*</span>:
                <select class="country" id="countryIsValid" name="data[country]" required>
                    <option>Choose Country</option>
                </select>
            </label>
            <span class="error" id="countryError"></span>
        </p>
        <p><label>Phone number (in the following format: "+1 (555) 555-5555")<span class="required">*</span>:
                <input id="phoneIsValid" name="data[phone]"  minlength="17"
                       data-mask="+0 (000) 000-0000" placeholder="+1 (555) 555-5555" required type="tel">
            </label>
            <span class="error" id="phoneError"></span>
        </p>
        <p><label>Email<span class="required">*</span>:
                <input id="emailIsValid" name="data[email]" placeholder="your.email@example.com"
                       required type="email">
            </label>
            <span class="error" id="emailError"></span>
        </p>
    </div>


    <div class="tab">
        <h3>Step 2</h3>
        <h3>Additional info:</h3>
        <p><label>Company:
                <input name="data[company]" placeholder="Company...">
            </label></p>
        <p><label>Position:
                <input name="data[position]" placeholder="Position...">
            </label></p>
        <p><label>About me:
                <textarea name="data[about]" placeholder="About me..."></textarea>
            </label></p>
        <input type="hidden" name="MAX_FILE_SIZE" value="3000000000"/>
        <p><label>My Photo (.png, .jpg, .jpeg):
                <input id="imgLoad" name="photo" type="file" accept=".png, .jpg, .jpeg">
            </label></p>
        <p id="fileWarning"></p>

    </div>

    <div class="tab">
        <h1 style="text-align: center">Registration complete! Share it with your friends!</h1>
        <div class="flex-row">

            <?php
            echo $anchors;
            ?>
        </div>
        <div class="finishAnchor">
            <a  href="/">Back to 1st step</a>
        </div>
    </div>

    <div style="overflow:auto;">
        <div style="float:right;">
            <button type="submit" id="nextBtn" onclick="sendData(currentTab)">Next</button>
            <button type="submit" id="step2Btn" onclick="nextPrev(currentTab)">Finish</button>
        </div>
    </div>

    <div style="text-align:center;margin-top:40px;">
        <span class="step"></span>
        <span class="step"></span>
        <span class="step"></span>
    </div>
</form>

<div class="members-link">
    <a href="members">All members (<span id="membersCount"></span>)</a>
</div>

<script>

    let currentTab = 0;
    if (sessionStorage.getItem('currentTab')) {
        currentTab = +sessionStorage.getItem('currentTab');
    } else if (+sessionStorage.getItem('currentTab') === 2) {
        currentTab = 0;
    }
    sessionStorage.setItem('currentTab', '0');

    let noErrors = {
        country: "",
        date: "",
        email: "",
        firstName: "",
        lastName: "",
        phone: "",
        subject: "",
    }

    showTab(currentTab);

    function sendData(n) {
        let oldForm = document.forms.form;
        let formData = new FormData(oldForm);
        let file_data = $('#imgLoad').prop('files')[0];
        formData.append("photo", file_data);
        let result;


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

    function updateData() {
        let oldForm = document.forms.form;
        let formData = new FormData(oldForm);
        let file_data = $('#imgLoad').prop('files')[0];
        formData.append("photo", file_data);

        $.ajax({
            type: "POST",
            processData: false,
            contentType: false,
            cache: false,
            url: 'update',
            data: formData,
            success: function (data) {

            }
        });
    }

    function getCount(){
        console.log(1);
        $.get( "get", function( data ) {
            $( "#membersCount" ).html( data );
        });
    }

    const countryList = document.querySelector('.country');
    fetch('https://restcountries.com/v3.1/all').then(res => {
        return res.json();
    }).then(data => {
        let output = '<option selected disabled value="">Choose Country</option>`';

        data.sort((a, b) => (a.name.common > b.name.common) ? 1 : -1)
            .forEach(country => {
                output += `<option value="${country.name.common}">${country.name.common}</option>`;
                countryList.innerHTML = output;
            });
    }).catch(err => {
        console.log(err);
    });


    let inputFirstName = document.getElementById('firstNameIsValid');
    inputFirstName.oninvalid = function(event) {
        console.log('oh')
        event.target.setCustomValidity("First Name should contain latin letters or '`- symbols and be maximum 30 symbols long.");
    }
    inputFirstName.oninput = function (event) {
        event.target.setCustomValidity('');
    }

    let inputLastName = document.getElementById('lastNameIsValid');
    inputLastName.oninvalid = function(event) {
        event.target.setCustomValidity("Last Name should contain latin letters or ' symbol and be maximum 30 symbols long.");
    }
    inputLastName.oninput = function (event) {
        event.target.setCustomValidity('');
    }

    let inputNumber = document.getElementById('phoneIsValid');
    inputNumber.oninvalid = function(event) {
        event.target.setCustomValidity("Phone number should contain 11 digits");
    }
    inputNumber.oninput = function (event) {
        event.target.setCustomValidity('');
    }

    let inputEmail = document.getElementById('emailIsValid');
    inputEmail.oninvalid = function(event) {
        event.target.setCustomValidity("Email should only contain latin letters, digits and @ symbol.");
    }
    inputEmail.oninput = function (event) {
        event.target.setCustomValidity('');
    }

    $(function(){

        $("#phoneIsValid").mask("+0 (000) 000-0000");
    });


</script>
</body>
</html>