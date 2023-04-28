<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Leaderboard</title>
    <link rel="stylesheet" href="scss/animal.css">
    <!-- add jquery from google cdn -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <script src="js/animal.js"></script>
</head>
<body>
<h1 contenteditable="true">Leaderboard</h1>
<ul class="leaderboard">
    <!-- place for persons / isotope plugin -->
</ul>
<div class="add-person-popup">
    <div class="box">
        <input type="text" id="rand-icon" class="random-icon" value="🦊">
        <br>
        <input type="text" id="nickname" size="15" placeholder="Nickname">
        <br>
        <input type="number" id="score" placeholder="score">
        <br>
        <button class="cancel">CANCEL</button>
        <button class="ok">OK</button>
    </div>
</div>
<div class="edit-popup">
    <div class="box">
        <textarea id="tarea"></textarea>
        <button class="cancel">CANCEL</button>
        <button class="ok">OK</button>
    </div>
</div>
<div class="link-popup">
    <div class="box">
        <textarea id="tarea-link"></textarea>
        <button class="close">CLOSE</button>
    </div>
</div>


<div class="add-person">+</div>
<div class="edit">📋</div>
<div class="link">🔗</div>





<a id="gh-icon" target="_blank" href="https://github.com/tgogos/leaderboard"><img loading="lazy" width="149" height="149" src="https://github.blog/wp-content/uploads/2008/12/forkme_right_darkblue_121621.png?resize=149%2C149" class="attachment-full size-full" alt="Fork me on GitHub" data-recalc-dims="1"></a>