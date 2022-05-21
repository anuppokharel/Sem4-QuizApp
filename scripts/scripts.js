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


// For admin dashboard left tab containers

// Store all the button elements in tabButtons constant as well for content elements

const tabButtons = document.querySelectorAll('.tab-container .tabs .button');
const tabContents = document.querySelectorAll('.tab-container .contents .content');

// Shift constant elements to an array
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

// For main quiz part
// Retrieving the data from database 

$.ajax({
    url: 'functions/getQuestion.php',
    data: { 'token': token },
    datatype: 'json',
    async: 'disable',
    method: 'post',
    success: function (data) {
        quizQuestions = JSON.parse(data);
        sendQuestion(quizQuestions);
    }
});

function sendQuestion(quizQuestions) {
    const quiz_container = document.querySelector('.mainCard');
    const attempt_container = document.querySelector('.attempt-list');
    const quiz_footer = document.querySelector('.question-footer');
    const quiz_question = document.querySelector('.question-header h2');
    const answers = document.querySelectorAll('.answer');
    const aLabel = document.getElementById('a_label');
    const bLabel = document.getElementById('b_label');
    const cLabel = document.getElementById('c_label');
    const dLabel = document.getElementById('d_label');
    const quizBtn = document.getElementById('quizSubmit');
    const quiz_image = document.getElementById('blogImg');

    let score = 0;
    let currentQuestionIndex = 0;

    loadQuiz();

    function loadQuiz() {
        answers.forEach(answer => {
            answer.checked = false;
        });

        const { question_image, question, firstOption, secondOption, thirdOption, fourthOption, created_at, topic_name } = quizQuestions[currentQuestionIndex];

        quiz_image.src = `images/blog-img/${question_image}`;
        quiz_question.innerText = question;
        aLabel.innerText = firstOption;
        bLabel.innerText = secondOption;
        cLabel.innerText = thirdOption;
        dLabel.innerText = fourthOption;

        attempt_container.innerHTML = `
        <p><span>${currentQuestionIndex + 1}</span>out of<span>${quizQuestions.length}</span>question.&nbsp;</p>
        `;
        quiz_footer.innerHTML = `
            <span id="timeField"></span>
            <p id="categoryField">${topic_name}</p>
        `;
    }

    quizBtn.addEventListener('click', () => {
        let userAnswer = getUserAnswer();

        if (userAnswer === quizQuestions[currentQuestionIndex].answer) {
            score++;
        }
        currentQuestionIndex++
        if (currentQuestionIndex < quizQuestions.length) {
            loadQuiz();
        } else {
            quiz_container.innerHTML = `
                <h3>You have answered ${score} out of ${quizQuestions.length} questions </h3>
                <div class="nextBtn">
                    <button onclick="location.reload()">Reload Quiz</button>
                </div>
            `;
        }
    });

    function getUserAnswer() {
        let userAnswer;

        answers.forEach(answer => {
            if (answer.checked) {
                userAnswer = answer.id;
            }
        });

        return userAnswer;

    }
}
