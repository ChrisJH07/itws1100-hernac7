# Prompt Log — Soccer Trivia Quiz (Quiz 3, D2)
**hernac7 | ITWS 1100**

---

## Prompt 1
**Prompt:**
> "I need to build a soccer trivia quiz for my web dev class. It needs PHP, MySQL, and jQuery. The questions should come from a database and load without a page refresh. Can you give me a basic project structure and a CREATE TABLE statement to start?"

**What it returned:**
Gave me a folder structure and a CREATE TABLE with columns for the question, four options, and the correct answer stored as a single letter (A/B/C/D). Also outlined which files I'd need.

**What I kept/changed/threw away:**
Kept the table structure — storing the correct answer as a CHAR(1) letter instead of the full text was smart, easier to check on the client side. Added a `difficulty` column myself because I thought it might be useful later for filtering. Threw away the suggested `quiz_results` table for now since I wanted to get the core quiz working first.

---

## Prompt 2
**Prompt:**
> "Write the db.php connection file and a questions.php endpoint that returns 8 random questions as JSON."

**What it returned:**
Returned both files. questions.php used `ORDER BY RAND() LIMIT 8` and json_encoded the result array.

**What I kept/changed/threw away:**
Kept most of it. Changed the error handling in db.php — the original version was echoing `$conn->connect_error` directly to the page, which would have exposed my database credentials if something went wrong. Replaced that with a generic error message. That's something we covered in class.

---

## Prompt 3
**Prompt:**
> "Now write the main index.php page. It should have a Start button, load questions via AJAX when clicked, and display them one at a time with four answer buttons."

**What it returned:**
Generated a full HTML/PHP page with jQuery and the quiz logic inline. The structure was correct — start screen, question screen, result screen — and the AJAX call to questions.php worked.

**What I kept/changed/threw away:**
Kept the three-screen layout. Rewrote the CSS almost entirely because it looked generic and didn't match my site's existing `things.css` style at all — wrong colors, weird fonts. Added the navbar from my existing web.html so the quiz feels like part of the same site. Also changed the feedback delay from 2000ms to 1200ms because 2 seconds felt too slow.

---

## Prompt 4
**Prompt:**
> "The answer buttons don't get disabled after I click one. I can click all four and rack up infinite points. Fix that."

**What it returned:**
Added `$(".option-btn").prop("disabled", true)` at the top of the handleAnswer function, which disables all buttons the moment one is clicked.

**What I kept/changed/threw away:**
Kept it as-is. Simple fix, exactly what I needed. This was a bug I caught by actually playing the quiz myself.

---

## Prompt 5
**Prompt:**
> "Add a save-score.php that accepts a POST request with the player's name, score, and total, and inserts it into a quiz_scores table using a prepared statement."

**What it returned:**
Returned save-score.php with a prepared INSERT using bind_param("sii", ...) and a new CREATE TABLE for quiz_scores.

**What I kept/changed/threw away:**
Kept the prepared statement exactly as written — that's the right pattern and matches what we did in Lab 9. Added the `played_at` column to the table myself using `NOW()` in the INSERT so I'd have a timestamp on each score. The original didn't include that.

---

## Prompt 6
**Prompt:**
> "Add a player name input on the start screen and use it in the result message. Something like 'Great job, Chris!'"

**What it returned:**
Added a text input before the Start button and threaded `playerName` through the state so it shows up in the result screen message.

**What I kept/changed/threw away:**
Kept the logic. Changed the result messages — the ones it generated were too formal ("Excellent performance!"). Rewrote them to sound more casual. Also added a fallback to "Anonymous" if the field is left blank, which the original didn't handle.

---

## Prompt 7
**Prompt:**
> "Add a progress indicator like 'Question 3 of 8' and keep a live score counter visible during the quiz."

**What it returned:**
Added `#progress` and `#score-display` spans that update inside showQuestion() on each render.

**What I kept/changed/threw away:**
Kept both. Styled the score display to float right so it lines up opposite the progress text — the original just stacked them on top of each other which looked bad. Minor CSS tweak but it made a difference.

---

## Prompt 8
**Prompt:**
> "Write a .htaccess file that password-protects this quiz3 folder. And also add the SQL for the quiz_scores table to setup.sql."

**What it returned:**
Generated the .htaccess with `AuthType Basic`, `AuthUserFile`, and `Require valid-user`. Also added the `quiz_scores` CREATE TABLE to setup.sql.

**What I kept/changed/threw away:**
Kept both. Made sure the AuthUserFile path pointed outside the web root, not inside the quiz3 folder — if .htpasswd were inside a public folder, someone could just download it. That's exactly what we set up in Lab 10, so I already knew that detail.

---
