-- Run this once to create the table and seed it with questions
-- Connect with: mysql -u hernac7 -p hernac7db < setup.sql

CREATE TABLE IF NOT EXISTS soccer_quiz (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    question      VARCHAR(255)                        NOT NULL,
    option_a      VARCHAR(100)                        NOT NULL,
    option_b      VARCHAR(100)                        NOT NULL,
    option_c      VARCHAR(100)                        NOT NULL,
    option_d      VARCHAR(100)                        NOT NULL,
    correct_answer CHAR(1)                            NOT NULL,  -- 'A', 'B', 'C', or 'D'
    difficulty    ENUM('easy', 'medium', 'hard')      DEFAULT 'medium'
);

INSERT INTO soccer_quiz (question, option_a, option_b, option_c, option_d, correct_answer, difficulty) VALUES
('Who won the 2022 FIFA World Cup?',                              'France',        'Brazil',       'Argentina',     'Germany',       'C', 'easy'),
('Which country hosted the 2018 FIFA World Cup?',                'Brazil',        'Germany',      'Russia',        'France',        'C', 'easy'),
('Who is the all-time top scorer in FIFA World Cup history?',    'Ronaldo (BRA)', 'Pele',         'Just Fontaine', 'Miroslav Klose','D', 'medium'),
('How many times has Brazil won the World Cup?',                 '4',             '5',            '6',             '3',             'B', 'easy'),
('Which club has won the most UEFA Champions League titles?',    'Barcelona',     'Bayern Munich','AC Milan',      'Real Madrid',   'D', 'medium'),
('Who scored the famous Hand of God goal in 1986?',             'Pele',          'Maradona',     'Zidane',        'Ronaldo',       'B', 'easy'),
('What year did Lionel Messi win his first Ballon d\'Or?',      '2007',          '2008',         '2009',          '2010',          'C', 'medium'),
('Which team did Cristiano Ronaldo start his professional career at?', 'Real Madrid', 'Manchester United', 'Sporting CP', 'Juventus', 'C', 'medium'),
('How many players are on the field per team in soccer?',       '10',            '11',           '12',            '9',             'B', 'easy'),
('Which country invented the sport of association football?',   'Brazil',        'Spain',        'Germany',       'England',       'D', 'medium'),
('Who won the 2021 UEFA Champions League?',                     'PSG',           'Manchester City','Chelsea',     'Bayern Munich', 'C', 'hard'),
('What is the maximum number of substitutions allowed in a standard FIFA match?', '3', '4', '5', '6', 'C', 'medium');
