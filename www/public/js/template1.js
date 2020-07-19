// Ecouter le scroll de la fenêtre

$(window).scroll(function(){
  var window_position = $(window).scrollTop();
  // Si la fenêtre est scrollée (scrollTop > 0) alors ajouter la classe .sticky au header
  if(window_position > 0){
      $('header').addClass('sticky');
  }else{
      $('header').removeClass('sticky');
  }
  // Sinon retirer la classe .sticky
})

// Apparition des sections (hors section 1)

// Au chargement de la page:
// Décaler les sections (main > section) de 100px vers le bas et les rendre transparentes
$(document).ready(function(){
  // $('main > section:not(#section1)').css('opacity', 0);
  // $('main > section:not(#section1)').css('transform', 'translateY(200px)');
  // //$('main > section:not(#section1)').css('position', 'relative');
  // //$('main > section:not(#section1)').css('top', '200px');
  // $('main > section:not(#section1)').css('transition', 'all 0.6s');
  //Équivaut à écrire ce qui est ci-dessous
  $('main > section:not(#section1)').css({
      'opacity' : 0,
      'position' : "relative",
      'top' : "50px",
      'transition' : 'all 0.6s'
  });

})
// Au scroll : si une section est à 1/3 du bas de l'écran : apparition (top et opacity)
$(window).scroll(function(){
  $('main > section:not(#section1)').each(function(index){
      var top_section = $(this).position().top;
      var distance_topSection = $(window).height() - top_section + $(window).scrollTop();
      console.log('Ecart section' + index + ' = ' + distance_topSection);
      if(distance_topSection >= $(window).height() / 3){
          $(this).css('opacity', 1);
          $(this).css('transform', 'none');
      }
  })

})

function showModal(){
  $('body').append('<div id="modal"><button onclick="closeModal()">Fermer</button></div>');
}

function closeModal(){
  $('#modal').remove(); 
}