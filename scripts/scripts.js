// jQuery 

$(document).ready(function () {
    $('#profileImg').on('click', function () {
        $('.profile-dropdown').toggleClass("active");
    });

    $('#profileName').on('click', function () {
        $('.profile-dropdown').toggleClass("active");
    });

    $('.body-container').on('click', function () {
        $('.profile-dropdown').removeClass("active");
    });

    $('#country').change(function () {
        let countryId = $(this).val();

        $.ajax({
            url: 'functions/cities.php',
            data: { 'countryId': countryId },
            datatype: 'text',
            method: 'post',
            success: function (response) {
                $('#city').html(response);
            }
        });
    });

    $('#username').keyup(function () {
        let inputValueUsername = $(this).val();

        $.ajax({
            url: 'functions/checkDatabase.php',
            data: { 'username': inputValueUsername },
            datatype: 'text',
            method: 'post',
            success: function (response) {
                $('.queryMsgUsername').html(response);

                if (response == 'Username already taken') {
                    $('.queryMsgUsername').css({ color: 'red' });
                } else {
                    $('.queryMsgUsername').css({ color: 'green' });
                }
            }
        });
    });

    $('#email').keyup(function () {
        let inputValueEmail = $(this).val();

        $.ajax({
            url: 'functions/checkDatabase.php',
            data: { 'email': inputValueEmail },
            datatype: 'text',
            method: 'post',
            success: function (response) {
                $('.queryMsgEmail').html(response);

                if (response == 'Email already registered') {
                    $('.queryMsgEmail').css({ color: 'red' });
                } else {
                    $('.queryMsgEmail').css({ color: 'green' });
                }
            }
        });
    });

});

// JavaScript 

const tabButtons = document.querySelectorAll('.tab-container .tabs .button');
const tabContents = document.querySelectorAll('.tab-container .contents .content');

let buttons = [];
for (let i = tabButtons.length; i--; buttons.unshift(tabButtons[i]));

let contents = [];
for (let i = tabContents.length; i--; contents.unshift(tabContents[i]));

buttons.forEach(changeContent);

function changeContent(button, index) {
    button.addEventListener('click', () => {
        buttons.forEach(button => {
            button.classList.remove('active');
        });
        button.classList.add('active');
        contents.forEach(content => {
            content.classList.remove('active');
            content.style.transitionDelay = "translateY(0s)";
        });
        contents[index].classList.add('active');
        contents[index].style.transitionDelay = "translateY(0.3s)";
    });
}