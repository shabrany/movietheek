(function () {
	'use strict';

	var input_title = document.getElementById('title'),
		input_imdb = document.getElementById('imdb'),
		ENTER_KEY = 13,
		SPACE_BAR_KEY = 32,
		ESCAPE_KEY = 27;

	function init() {

		// Add keyup listener
		input_title.addEventListener('keyup', function (event) {

			if (input_title.value == '' && document.querySelector('.ajax-container') || (event.which === ESCAPE_KEY)) {
				this.parentElement.removeChild(document.querySelector('.ajax-container'));
			}

			if (input_title.value.length < 3 || event.which !== SPACE_BAR_KEY || input_title.value.trim() == 'the') {
				return false;
			}

			var parentDiv = this.parentElement;
			var ajaxContainer = createAjaxContainer();

			ajaxCall({
				url: 'search.php?s=' + encodeURI(input_title.value.trim()),
				success: function (response) {
					if (parentDiv.querySelector('.ajax-container') == null) {
						ajaxContainer.innerHTML = response;
						ajaxContainer.style.display = 'block';
						parentDiv.appendChild(ajaxContainer);
					} else {
						parentDiv.querySelector('.ajax-container').innerHTML = response;
					}

					initClickEvent();
				}
			});
		});

		input_imdb.addEventListener('input', function (event) {
			var parentDiv = this.parentElement;
			var ajaxContainer = createAjaxContainer();

			ajaxCall({
				url: 'movie.php?id=' + input_imdb.value.trim(),
				success: function (res) {
					var movie = JSON.parse(res);
					console.log(movie);
					if (movie.Response == 'True') {
						document.querySelector('input[name=imdb]').value = movie.imdbID;
						document.querySelector('input[name=title]').value = movie.Title;
						document.querySelector('input[name=year]').value = movie.Year;
						document.querySelector('input[name=authors]').value = movie.Actors;
						document.querySelector('input[name=lang_code]').value = movie.Language;
						document.querySelector('input[name=poster]').value = movie.Poster;

						if (movie.Poster != 'N/A') {
							var img = new Image();
							img.src = movie.Poster;
							console.log(img);
							document.querySelector('.image-wrapper').appendChild(img);
						}

					}
				}
			});
		});

		// Attach click event to pagination
		document.addEventListener('click', function (event) {
			if (event.target.className == 'page-nav') {
				navigate2page(event.target);
			}
		});
	}

	function navigate2page(a) {
		var url = a.getAttribute('data-href');
		var ajaxContainer = document.querySelector('.ajax-container');

		ajaxCall({
			url: url,
			success: function (response) {
				ajaxContainer.innerHTML = response;
			}
		});
	}

	function createAjaxContainer() {
		var container = document.createElement('div');
		container.className = 'ajax-container';
		return container;
	}

	function ajaxCall(options) {
		var xhr = new XMLHttpRequest();
		xhr.open('GET', options.url, true);
		xhr.send(null);
		xhr.onreadystatechange = function () {
			if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
				options.success(xhr.responseText);
			}
		};
	}

	function selectMovie(element) {
		var movieID = element.getAttribute('data-imdb');
		var formGroup = document.querySelector('.ajax-container').parentElement;

		ajaxCall({
			url: 'movie.php?id=' + movieID,
			success: function (response) {
				var movie = JSON.parse(response);
				document.querySelector('input[name=imdb]').value = movie.imdbID;
				document.querySelector('input[name=title]').value = movie.Title;
				document.querySelector('input[name=year]').value = movie.Year;
				document.querySelector('input[name=authors]').value = movie.Actors;
				document.querySelector('input[name=lang_code]').value = movie.Language;
				document.querySelector('input[name=poster]').value = movie.Poster;

				// close popup results
				formGroup.removeChild(document.querySelector('.ajax-container'));
			}
		});
	}

	function initClickEvent() {
		var movies = document.querySelectorAll('.movie');
		for (var i = 0; i < movies.length; i++) {
			movies[i].addEventListener('click', function () {
				selectMovie(this);
			});
		}
	}

	init();

})();
