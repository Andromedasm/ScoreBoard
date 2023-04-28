CREATE OR REPLACE FUNCTION update_leaderboard() RETURNS TRIGGER AS $$
BEGIN
    UPDATE leaderboard SET total_score = total_score + NEW.score WHERE player_id = NEW.player_id;
    RETURN NEW;
END;
$$ LANGUAGE plpgsql;

CREATE TRIGGER update_leaderboard_trigger
AFTER INSERT ON game_records
FOR EACH ROW
EXECUTE FUNCTION update_leaderboard();