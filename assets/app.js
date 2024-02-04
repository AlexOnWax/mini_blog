//import './bootstrap.js';
/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.scss';

import axios from 'axios';
document.addEventListener('DOMContentLoaded', function() {
    function onClickLike(event) {
        event.preventDefault();
        const url = this.href;
        const link = this;
        axios.get(url).then(function(response) {
            const likes = response.data.likes;
            const img = link.parentElement.querySelector('img');
           console.log(link);
                if (likes > 0) {
                    img.src = "/build/img/isliked.svg";
                    link.innerHTML = likes;
                } else {
                    img.src = "/build/img/isnotliked.svg";
                    link.innerHTML = likes;
                }
        });
    }
    document.querySelectorAll('.like-button > a').forEach(function (link) {
        link.addEventListener('click', onClickLike);
    });
});
