<!DOCTYPE html>
<html>
<head>
    <title>Quiz</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        body { 
            font-family: Arial; 
            background: #f4f4f4; 
            text-align: center; 
        }
        .box { 
            background: #4a90e2; 
            color: #fff; 
            padding: 20px; 
            margin: 20px auto; 
            width: 400px; 
            border-radius: 10px; 
            min-height: 250px;
        }
        #startBox{
            display: flex;
            align-items: center;
        }
        #username{
            width: 100%;
            height: 22px;
            padding: 5px;
        }
        button { 
            background: gray; 
            color: #fff; 
            border: none; 
            padding: 10px 20px; 
            margin: 5px; 
            cursor: pointer; 
        }
        .options { 
            text-align: left; 
            margin: 10px; 
        }
    </style>
</head>
<body>

<div class="box" id="startBox">
    <input type="text" id="username" placeholder="Enter your name" />
    <button id="startQuiz">Next</button>
</div>

<div class="box" id="quizBox" style="display:none;">
    <h1 id="questionNumber"></h1>
    <h3 id="questionText"></h3>
    <div class="options" id="options"></div>
    <button onclick="skipQuestion()">Skip</button>
    <button onclick="nextQuestion(false)">Next</button>
</div>

<div class="box" id="resultBox" style="display:none;">
    <h3>Result Page</h3>
    <p>Correct Ans: <span id="correctCount"></span></p>
    <p>Wrong Ans: <span id="wrongCount"></span></p>
    <p>Skipped Ans: <span id="skipCount"></span></p>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
let userId, usedQuestions = [], correct = 0, wrong = 0, skipped = 0, correctAnswer, questionNo = 1;
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$(document).ready(function () {
    $("#startQuiz").click(function () {
        let name = $("#username").val();

        if (!name) {
            alert("Please enter your name");
            return;
        }

        $.ajax({
            url: "/start",
            type: "POST",
            data: {
                name: name,
                _token: "{{ csrf_token() }}" // Important for Laravel CSRF protection
            },
            success: function (response) {
                console.log("User ID:", response.user_id);
                // Hide name box and load first question
                $("#startBox").hide();
                $("#quizBox").show();

                startQuiz(); // function to load first question
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                alert("Something went wrong. Please try again.");
            }
        });
    });
});

function startQuiz(){
    $.post("{{ route('quiz.start') }}", { name: $('#username').val(), _token:$('meta[name="csrf-token"]').attr('content') }, function(res){
        userId = res.user_id;
        loadQuestion(res.question);
        $('#startBox').hide();
        $('#quizBox').show();
    });
}

function loadQuestion(q){
    if(!q){
        endQuiz();
        return;
    }
    usedQuestions.push(q.id);
    $('#questionText').text(q.question);
    $('#options').empty();
    $("#questionNumber").text("Question " + questionNo);
    correctAnswer = null;
    questionNo++;
    q.answers.forEach(a => {
        $('#options').append(`<label><input type="radio" name="answer" value="${a.id}"> ${a.answer_text}</label><br>`);
        if(a.is_correct) correctAnswer = a.id;
    });
}

function nextQuestion(countSkip = false){
    let chosen = $('input[name="answer"]:checked').val();
    if(chosen){
        if(chosen == correctAnswer) correct++;
        else wrong++;
    } else {
        if(!countSkip) skipped++;
    }
    $.post("{{ route('quiz.next') }}", { used: usedQuestions }, function(res){
        loadQuestion(res.question);
    });

}

function skipQuestion(){
    skipped++;
    nextQuestion(true);
}

function endQuiz(){
    $('#quizBox').hide();
    $('#resultBox').show();
    $('#correctCount').text(correct);
    $('#wrongCount').text(wrong);
    $('#skipCount').text(skipped);

    $.post("{{ route('quiz.result') }}", { user_id: userId, correct, wrong, skipped, _token:$('meta[name="csrf-token"]').attr('content') });
}
</script>

</body>
</html>
