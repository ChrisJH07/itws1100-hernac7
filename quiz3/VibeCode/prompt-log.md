# Prompt Log 



## Prompt 1
**Prompt:**
 "I want to build a soccer trivia quiz for my web dev class. It needs to use PHP and MySQL for the backend and jQuery on the front end. Questions need to come from a database and load without refreshing the page. What files do I need and what should the database table look like?"

**What it returned:**
Suggested a folder structure with separate files for the DB connection, a JSON endpoint, and the main page. Gave me a CREATE TABLE with columns for the question text, four answer options, the correct answer, and a difficulty level.

**What I kept / changed / threw away:**
Kept the overall file structure — splitting db.php out made sense since both questions.php and save-score.php need the connection. Kept storing the correct answer as a single letter  because that made the JavaScript comparison really simple. Added the difficulty ENUM column myself . Threw away a separate `quiz_results` table it suggested at first, 



## Prompt 2
**Prompt:**
 "Write db.php. It should connect to MySQL using mysqli and stop the script if the connection fails."

**What it returned:**
Short file, connected with `new mysqli(...)` and checked `$conn->connect_error`. If it failed it echoed the actual error and exited.

**What I kept / changed / threw away:**
Kept the structure but changed the error output. The original was printing `$conn->connect_error` directly to the page — that would expose the database host and credentials to anyone who triggered a connection failure. Changed it to a generic "Could not connect" message .

---

## Prompt 3
**Prompt:**
"Write questions.php. It should connect to the database, grab 8 random questions, and return them as JSON."

**What it returned:**
Used `ORDER BY RAND() LIMIT 8`, looped through with `fetch_assoc()`, built an array, and `json_encode()`d it at the end.

**What I kept / changed / threw away:**
Kept basically all of it. The only thing I added was `header("Content-Type: application/json")` at the top — the original didn't have it and without it jQuery sometimes gets confused parsing the response. 

---

## Prompt 4
**Prompt:**
 "Now write the main index.php. I want a start screen with a name input, then questions show up one at a time with four buttons, and a results screen at the end. All without the page reloading."

**What it returned:**
Generated a full page with three hidden divs (start, question, result) that swap visibility with jQuery's `.show()` and `.hide()`. The AJAX call on the Start button fetched from questions.php and kicked off the quiz loop.

**What I kept / changed / threw away:**
Kept the three-div layout  Rewrote some CSS. Pulled in `things.css` and matched the navbar from `web.html` so it felt consistent. Changed the transition delay between questions from 2000ms to 1200ms, two full seconds was too long.
---

## Prompt 5
**Prompt:**
"There's a bug — I can click multiple answer buttons and score extra points. After picking an answer all buttons need to lock."

**What it returned:**
Added `$(".option-btn").prop("disabled", true)` as the first line inside `handleAnswer()`.

**What I kept / changed / threw away:**
Kept it. Found this bug by actually playing the quiz. Also noticed the correct answer wasn't highlighting green when I got something wrong — the original only colored the button I clicked. Added `.addClass("correct")` on the right answer regardless so you always see what you should have picked.

---

## Prompt 6
**Prompt:**
"Add save-score.php. After the quiz ends it should POST the player name, score, and total and save it to a quiz_scores table using a prepared statement."

**What it returned:**
Returned save-score.php with `bind_param("sii", ...)` and a CREATE TABLE for quiz_scores. Added the `$.post()` call in the JavaScript result function too.

**What I kept / changed / threw away:**
Kept the prepared statemen. Added `played_at` with `NOW()` , the original didn't track timestamps. Also added a method check at the top so the file can't just be opened in a browser directly.

---

## Prompt 7
**Prompt:**
"The result screen needs to use the player's name. Also the result messages sound too stiff, rewrite them to be more casual."

**What it returned:**
Threaded `playerName` through the state and used it in the end message. Result messages were things like "Excellent result" and "Well done."

**What I kept / changed / threw away:**
Kept the name logic but rewrote every result message myself. 

---

## Prompt 8
**Prompt:**
 "The navbar at the top shows up but it has no styling — just plain text links stacked weird. Pull in the things.css stylesheet and make sure the dropdown menu works."

**What it returned:**
Added the `<link rel="stylesheet" href="things.css">` tag in the head and copied the full navbar HTML structure from web.html including the dropdown for Labs.

**What I kept / changed / threw away:**
Kept the navbar HTML completely. Had to fix the CSS path though — the original was pointing to `../lab3/things.css`. Changed it to just `href="things.css"` since things.css was already in the same directory. After that the navbar rendered exactly like the rest of my site and the dropdown worked on hover.

---
