// Création du slider quand le document est prêt
$(document).ready(function(){
	makeSlider($('#slider'));
})


var current_image;
var total_images = 0;

function makeSlider(elem){
	// Définition de l'image courante (commence à 0)
	current_image = 0;

	// Ajout du slider à la page
	elem.before('<div class="slider"></div>');

	// Ajout de la navigation
	$('.slider').append('<nav></nav>');
	$('.slider nav').append('<button class="btn btn--prev" onclick="prev(); disableNav()"></button>');
	$('.slider nav').append('<button class="btn btn--next" onclick="next(); disableNav()"></button>');
	

	// Fabrication du container de slides
	var slides_container = $('<div class="slides-container"></div>');
	elem.children('img').each(function(){

		// ajouter 1 au total d'images
		total_images ++;

		var source = $(this).attr('src');
		console.log(source);
		var slide = $('<img class="slide">');
		slide.css('width', $('.slider').width() + 'px');
		slide.css('height', $('.slider').height() + 'px');
		slide.attr('src', source);

		// Ajout de la slide au container de slides
		slides_container.append(slide);
	})
	// ajout du container de slides au slider
	$('.slider').append(slides_container);

	// Retirer l'élément cible
	elem.remove();
}


function next(){
	current_image ++;
	slide();
}

function prev(){
	current_image --;
	slide();
}

function slide(){

	// Si on dépasse la derniere image
	if(current_image == total_images){
		var slide_temp = $($('.slide')[0]).clone();
		$('.slides-container').append(slide_temp);
		// Ecouter la fin de la transition
		$('.slides-container').on('transitionend', function(){
			// Retirer l'écouteur d'événement
			$('.slides-container').off();

			// Remettre le slider dans sa position initiale
			$('.slides-container').css('transition','none');
			$('.slides-container').css('left', '0px');
			current_image = 0;

			// Supprimer la slide temp
			slide_temp.remove();

			// Remmettre la transition
			setTimeout(function(){
				$('.slides-container').css('transition','all 1s');
			}, 10);
			
		})
	}

	// Si on precede la premiere image
	if(current_image == -1){
		var slide_temp = $($('.slide')[$('.slide').length - 1]).clone();
		slide_temp.css({
			"position" : "absolute",
			"top" : "0px",
			"left" : $('.slider').width() * (-1) + 'px'
		});
		$('.slides-container').prepend(slide_temp);

		$('.slides-container').on('transitionend', function(){
			// Retirer l'écouteur d'événement
			$('.slides-container').off();

			// Ramener le slider à la dernière image
			$('.slides-container').css('transition','none');
			$('.slides-container').css('left', -1 * ($('.slides-container').width() - $('.slider').width()));
			current_image = total_images - 1;

			// Retirer la slide temporaire
			slide_temp.remove();

			// Remmettre la transition
			setTimeout(function(){
				$('.slides-container').css('transition','all 1s');
			}, 10);
		})
	}

	// Ecouter la fin de la transition pour réactiver la navigation
	$('.slides-container').on('transitionend', function(){
		$('.slides-container').off();
		enableNav();
	})

	var offset = current_image * $('.slider').width() * (-1);
	$('.slides-container').css('left', offset + 'px');
}

function disableNav(){
	$('.slider nav').addClass('disabled');
	// Reinitialiser l'interval lors d'un clic sur la nav
	resetInterval();
}

function enableNav(){
	$('.slider nav').removeClass('disabled');
}

// Deroulement auto

var interval = setInterval(function(){
	next();
}, 3000);


function resetInterval(){
	clearInterval(interval);
	interval = setInterval(function(){
		next();
	}, 3000);
}
