// db.js
const { Pool } = require("pg");
const config = require("./config");

const pool = new Pool({
    host: config.host,
    port: config.port,
    database: config.database,
    user: config.user,
    password: config.password,
});

module.exports = {
    query: (text, params) => pool.query(text, params),
};
