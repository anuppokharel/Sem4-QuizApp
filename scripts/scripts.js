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