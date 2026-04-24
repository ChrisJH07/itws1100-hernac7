<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Soccer Trivia Quiz</title>

  <!-- Reuse the existing site stylesheet -->
  <link rel="stylesheet" href="../lab3/things.css">

  <style>
    /* ── Quiz layout ── */
    .quiz-wrapper {
      width: 60%;
      margin: 40px auto;
      font-family: sans-serif;
    }

    .quiz-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 15px;
      padding: 40px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .quiz-card h1 {
      text-align: center;
      color: #2c3e50;
      margin-bottom: 8px;
    }

    .quiz-card p.subtitle {
      text-align: center;
      color: #555;
      margin-bottom: 24px;
    }

    /* Start screen */
    #start-screen input {
      display: block;
      width: 100%;
      padding: 10px 14px;
      margin-bottom: 14px;
      border: 2px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      box-sizing: border-box;
    }

    #start-screen input:focus {
      border-color: #2c3e50;
      outline: none;
    }

    /* Question area */
    #question-screen { display: none; }

    #progress {
      font-size: 13px;
      color: #888;
      margin-bottom: 6px;
    }

    #score-display {
      font-size: 15px;
      font-weight: bold;
      color: #2c3e50;
      float: right;
    }

    #question-text {
      font-size: 20px;
      font-weight: bold;
      color: #2c3e50;
      margin: 16px 0 20px;
      clear: both;
    }

    .option-btn {
      display: block;
      width: 100%;
      padding: 12px 16px;
      margin-bottom: 10px;
      background: #f4f6f8;
      border: 2px solid #ccc;
      border-radius: 8px;
      font-size: 16px;
      text-align: left;
      cursor: pointer;
      transition: background 0.15s, border-color 0.15s;
    }

    .option-btn:hover:not(:disabled) {
      background: #dce8f5;
      border-color: #2c3e50;
    }

    .option-btn.correct {
      background: #d4edda;
      border-color: #28a745;
      color: #155724;
    }

    .option-btn.wrong {
      background: #f8d7da;
      border-color: #dc3545;
      color: #721c24;
    }

    /* Feedback message */
    #feedback {
      margin-top: 10px;
      font-weight: bold;
      font-size: 15px;
      min-height: 22px;
    }

    /* Result screen */
    #result-screen { display: none; text-align: center; }

    #final-score {
      font-size: 48px;
      font-weight: bold;
      color: #2c3e50;
      margin: 10px 0;
    }

    #result-message {
      font-size: 18px;
      color: #555;
      margin-bottom: 24px;
    }

    /* Shared button style */
    .btn-primary {
      background: #2c3e50;
      color: white;
      border: none;
      padding: 12px 30px;
      border-radius: 8px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.15s;
    }

    .btn-primary:hover { background: #3d5166; }

    #loading {
      text-align: center;
      color: #888;
      padding: 20px 0;
      display: none;
    }
  </style>
</head>
<body>

  <!-- Reuse existing navbar -->
  <div class="navbar">
    <a href="../lab2/index.html">Resume</a>
    <div class="dropdown">
      <button class="dropbtn">Labs ▾</button>
      <div class="dropdown-content">
        <a href="../lab1/index.html">Lab 1</a>
        <a href="../lab2/index.html">Lab 2</a>
        <a href="../lab3/web.html">Lab 3</a>
        <a href="../lab4/rss.xml">Lab 4</a>
        <a href="../lab5/lab5.html">Lab 5</a>
        <a href="../lab6/lab6_lp.html">Lab 6</a>
      </div>
    </div>
    <a href="https://www.linkedin.com/in/christopher-hernandez-34158538b/">LinkedIn</a>
  </div>

  <div class="quiz-wrapper">
    <div class="quiz-card">

      <h1>⚽ Soccer Trivia</h1>
      <p class="subtitle">8 questions. How much do you know?</p>

      <!-- ── Start screen ── -->
      <div id="start-screen">
        <input type="text" id="player-name" placeholder="Your name (optional)" maxlength="50">
        <button class="btn-primary" id="start-btn" style="width:100%;">Start Quiz</button>
      </div>

      <!-- ── Loading indicator ── -->
      <div id="loading">Loading questions...</div>

      <!-- ── Question screen ── -->
      <div id="question-screen">
        <div>
          <span id="progress"></span>
          <span id="score-display">Score: 0</span>
        </div>
        <div id="question-text"></div>
        <div id="options-container"></div>
        <div id="feedback"></div>
      </div>

      <!-- ── Result screen ── -->
      <div id="result-screen">
        <p>Final Score</p>
        <div id="final-score"></div>
        <div id="result-message"></div>
        <button class="btn-primary" id="restart-btn">Play Again</button>
      </div>

    </div>
  </div>

  <!-- jQuery from CDN -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    // ── State ──
    let questions  = [];
    let current    = 0;
    let score      = 0;
    let playerName = "";

    // ── Start button ──
    $("#start-btn").on("click", function () {
      playerName = $("#player-name").val().trim() || "Anonymous";
      $("#start-screen").hide();
      $("#loading").show();

      // AJAX call to questions.php — no page reload
      $.ajax({
        url: "questions.php",
        method: "GET",
        dataType: "json",
        success: function (data) {
          $("#loading").hide();
          questions = data;
          current   = 0;
          score     = 0;
          showQuestion();
          $("#question-screen").show();
        },
        error: function () {
          $("#loading").hide().text("Failed to load questions. Please refresh.");
        }
      });
    });

    // ── Render a question ──
    function showQuestion () {
      if (current >= questions.length) {
        showResult();
        return;
      }

      const q = questions[current];
      $("#progress").text("Question " + (current + 1) + " of " + questions.length);
      $("#score-display").text("Score: " + score);
      $("#question-text").text(q.question);
      $("#feedback").text("");

      // Build the four answer buttons
      const opts = [
        { letter: "A", text: q.option_a },
        { letter: "B", text: q.option_b },
        { letter: "C", text: q.option_c },
        { letter: "D", text: q.option_d }
      ];

      const $container = $("#options-container").empty();

      opts.forEach(function (opt) {
        const $btn = $("<button>")
          .addClass("option-btn")
          .text(opt.letter + ". " + opt.text)
          .attr("data-letter", opt.letter);

        $btn.on("click", function () {
          handleAnswer(opt.letter, q.correct_answer);
        });

        $container.append($btn);
      });
    }

    // ── Handle an answer click ──
    function handleAnswer (chosen, correct) {
      // Disable all buttons so the user can't click twice
      $(".option-btn").prop("disabled", true);

      if (chosen === correct) {
        score++;
        $(".option-btn[data-letter='" + chosen + "']").addClass("correct");
        $("#feedback").text("✓ Correct!").css("color", "#28a745");
      } else {
        $(".option-btn[data-letter='" + chosen + "']").addClass("wrong");
        $(".option-btn[data-letter='" + correct + "']").addClass("correct");
        $("#feedback").text("✗ Wrong — the answer was " + correct + ".").css("color", "#dc3545");
      }

      // Move to next question after a short delay
      setTimeout(function () {
        current++;
        showQuestion();
      }, 1200);
    }

    // ── Show the final result and POST the score ──
    function showResult () {
      $("#question-screen").hide();

      const total = questions.length;
      const pct   = Math.round((score / total) * 100);

      $("#final-score").text(score + " / " + total);

      let msg = "";
      if      (pct === 100) msg = "Perfect score! You really know your soccer.";
      else if (pct >= 75)   msg = "Great job, " + playerName + "! Solid soccer knowledge.";
      else if (pct >= 50)   msg = "Not bad, " + playerName + ". A few more games and you'll get there.";
      else                  msg = "Better luck next time, " + playerName + "!";

      $("#result-message").text(msg);
      $("#result-screen").show();

      // POST the score to save-score.php without reloading the page
      $.post("save-score.php", {
        name:  playerName,
        score: score,
        total: total
      });
    }

    // ── Restart ──
    $("#restart-btn").on("click", function () {
      $("#result-screen").hide();
      $("#start-screen").show();
    });
  </script>

</body>
</html>
