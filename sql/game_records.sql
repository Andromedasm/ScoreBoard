CREATE TABLE game_records (
    id SERIAL PRIMARY KEY,
    player_id INTEGER REFERENCES players(id),
    game_round INTEGER NOT NULL,
    game_time TIMESTAMP NOT NULL,
    score INTEGER NOT NULL,
    multiplier INTEGER NOT NULL
);
