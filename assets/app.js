/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './sass/app.scss';
import Plyr from "plyr";

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';






document.addEventListener("DOMContentLoaded", function() {
    const player = new Plyr('#player');
    var buttons = document.querySelectorAll('.play-episode');
    for (var i = 0; i < buttons.length; i++) {
        var self = buttons[i];

        self.addEventListener('click', function (event) {
            // prevent browser's default action
            event.preventDefault();

            player.source = {
                type: 'audio',
                sources: [
                    {
                        src: this.dataset.audio,
                        type: 'audio/mp3',
                    }
                ],
            };

            player.play();

        }, false);
    }
});


