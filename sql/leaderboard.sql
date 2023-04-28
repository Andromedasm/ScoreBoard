CREATE TABLE leaderboard (
    player_id INTEGER PRIMARY KEY REFERENCES players(id),
    total_score INTEGER NOT NULL
);
