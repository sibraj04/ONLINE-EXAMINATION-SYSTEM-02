const progressBar = document.querySelector(".progress-bar"),
    progressText = document.querySelector(".progress-text");

const progress = (value) => {
    const percentage = (value / time) * 100;
    progressBar.style.width = `${percentage}%`;
    progressText.innerHTML = `${value}`;
};

let questions = [],
    time = 30,
    score = 0,
    currentQuestion,
    timer;

const startBtn = document.querySelector(".start"),
    numQuestions = document.querySelector("#num-questions"),
    category = document.querySelector("#category"),
    difficulty = document.querySelector("#difficulty"),
    timePerQuestion = document.querySelector("#Time"),
    quiz = document.querySelector(".quiz"),
    startscreen = document.querySelector(".start-screen");

const startQuiz = () => {
    const num = numQuestions.value;
    cat = category.value;
    diff = difficulty.value;

    let scriptSrc = "";

    if (cat === "10") {
        scriptSrc = "books.js";
    } else if (cat === "9") {
        scriptSrc = "generalKnowledge.js";
    } else if (cat === "11")
    {
        scriptSrc = "film.js";
    } else if (cat === "12")
    {
        scriptSrc = "cars.js";
    } else if(cat === "13")
    {
        scriptSrc = "politics.js";
    }
    else if(cat === "14")
    {
        scriptSrc = "computer.js";
    } else if(cat=== "15")
    {
        scriptSrc = "sports.js"
    } else if(cat=== "16")
    {
        scriptSrc = "Television.js"
    }
    

    
    const script = document.createElement("script");
    script.src = `./${scriptSrc}`;
    document.head.appendChild(script);

    
    script.onload = () => {
        if (cat === "10") {
            questions = bookQuestions;
          } else if (cat === "9") {
            questions = generalKnowledgeQuestions;
          } else if (cat === "11") {
            questions = filmQuestions; 
          } else if(cat === "12"){
            questions = carsQuestions;
          } else if(cat === "13"){
            questions = politicsQuestions;
          } else if(cat === "14"){
            questions = computerQuestions;
          } else if(cat === "15"){
            questions = sportsQuestions;
          } else if(cat === "16"){
            questions = TelevisionQuestions;
          }



        
        questions = questions.slice(0, num);

        startscreen.classList.add("hide");
        quiz.classList.remove("hide");
        currentQuestion = 1;
        showQuestion(questions[0]);
    };
};

startBtn.addEventListener("click", startQuiz);

const submitBtn = document.querySelector(".submit"),
    nextBtn = document.querySelector(".next");

    const showQuestion = (question) => {
        const questionText = document.querySelector(".question"),
            answerWrapper = document.querySelector(".answer-wrapper"),
            questionNumber = document.querySelector(".number");
    
        questionText.innerHTML = question.question;
    
        const options = [
            ...question.incorrect_answers,
            question.correct_answer.toString(),
        ];
    
        
        options.sort(() => Math.random() - 0.5);
    
        questionNumber.innerHTML = `
            question <span class="current">${questions.indexOf(question) + 1}</span>
            <span class="total">/${questions.length}</span>
        `;
    
        answerWrapper.innerHTML = "";
        for (let i = 0; i < options.length; i++) {
            answerWrapper.innerHTML += `
                <div class="answer">
                    <span class="text">${options[i]}</span>
                    <span class="checkbox">
                        <span class="icon">✓</span>
                    </span>
                </div>
            `;
        }
    
        const answerDiv = document.querySelectorAll(".answer");
        answerDiv.forEach((answer) => {
            answer.addEventListener("click", () => {
                if (!answer.classList.contains("checked")) {
                    answerDiv.forEach((answer) => {
                        answer.classList.remove("selected");
                    });
    
                    answer.classList.add("selected");
    
                    submitBtn.disabled = false;
                }
            });
        });
    
        time = timePerQuestion.value;
        startTimer(time);
    };
    

const startTimer = (time) => {
    timer = setInterval(() => {
        if (time >= 0) {
            progress(time);
            time--;
        } else {
            checkanswer();
        }
    }, 1000);
};

submitBtn.addEventListener("click", () => {
    checkanswer();
});

const checkanswer = () => {
    clearInterval(timer);

    const selectedAnswer = document.querySelector(".answer.selected");

    if (selectedAnswer) {
        const answer = selectedAnswer.querySelector(".text");
        if (answer.innerHTML === questions[currentQuestion - 1].correct_answer) {
            score++;
            selectedAnswer.classList.add("correct");
        } else {
            selectedAnswer.classList.add("wrong");
            const correctAnswer = document
                .querySelectorAll(".answer")
                .forEach((answer) => {
                    if (
                        answer.querySelector(".text").innerHTML ===
                        questions[currentQuestion - 1].correct_answer
                    ) {
                        answer.classList.add("correct");
                    }
                });
        }
    } else {
        const correctAnswer = document
            .querySelectorAll(".answer")
            .forEach((answer) => {
                if (
                    answer.querySelector(".text").innerHTML ===
                    questions[currentQuestion - 1].correct_answer
                ) {
                    answer.classList.add("correct");
                }
            });
    }

    const answerDiv = document.querySelectorAll(".answer");
    answerDiv.forEach((answer) => {
        answer.classList.add("checked");
    });

    submitBtn.style.display = "none";
    nextBtn.style.display = "block";
};

nextBtn.addEventListener("click", () => {
    nextQuestion();
    nextBtn.style.display = "none";
    submitBtn.style.display = "block";
});

const nextQuestion = () => {
    if (currentQuestion < questions.length) {
        currentQuestion++;
        showQuestion(questions[currentQuestion - 1]);
    } else {
        showScore();
    }
};

const endScreen = document.querySelector(".end-screen"),
    finalScore = document.querySelector(".final-score"),
    totalScore = document.querySelector(".total-score");

const showScore = () => {
    endScreen.classList.remove("hide");
    quiz.classList.add("hide");
    finalScore.innerHTML = score;
    totalScore.innerHTML = `/${questions.length}`;
};

const restartBtn = document.querySelector(".restart");
restartBtn.addEventListener("click", () => {
    window.location.reload();
});
