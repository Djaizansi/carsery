function showContent(){
    document.querySelector('.loader-container').classList.add('hidden');
}
setTimeout(showContent, 3000);



const modalTriggerButtons = document.querySelectorAll("[data-modal-target]");
const modals = document.querySelectorAll(".modal");
const modalCloseButtons = document.querySelectorAll(".modal-close");

modalTriggerButtons.forEach(elem => {
  elem.addEventListener("click", event => toggleModal(event.currentTarget.getAttribute("data-modal-target")));
});
modalCloseButtons.forEach(elem => {
  elem.addEventListener("click", event => toggleModal(event.currentTarget.closest(".modal").id));
});
modals.forEach(elem => {
  elem.addEventListener("click", event => {
    if(event.currentTarget === event.target) toggleModal(event.currentTarget.id);
  });
});

// Maybe also close with "Esc"...
document.addEventListener("keydown", event => {
  if(event.keyCode === 27 && document.querySelector(".modal.modal-show")) {
    toggleModal(document.querySelector(".modal.modal-show").id);
  }
});

function toggleModal(modalId) {
  const modal = document.getElementById(modalId);

  if(getComputedStyle(modal).display==="flex") { // alternatively: if(modal.classList.contains("modal-show"))
    modal.classList.add("modal-hide");
    setTimeout(() => {
      document.body.style.overflow = "initial"; // Optional: in order to enable/disable page scrolling while modal is hidden/shown - in this case: "initial" <=> "visible"
      modal.classList.remove("modal-show", "modal-hide");
      modal.style.display = "none";      
    }, 200);
  }
  else {
    document.body.style.overflow = "hidden"; // Optional: in order to enable/disable page scrolling while modal is hidden/shown
    modal.style.display = "flex";
    modal.classList.add("modal-show");
  }
}


var id_utilisateur_supprimer;
var token;

$(document).on("click", ".myBtn", function () {
  id_utilisateur_supprimer = $(this).data('id');
  token = $(this).data('token');
});

$('#btnYes').click(function() {
	window.location.href = "/supprimer-page?id="+id_utilisateur_supprimer+"&token="+token;
});

$(function(){
  $('#btnNo').click(function(){
    $('#modal1').toggleClass('modal-hide')
  })
})

tinymce.init({
  selector: '#myTextarea',
  height: 300,
  plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker image',
  toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table image',
  toolbar_mode: 'floating',
  tinycomments_mode: 'embedded',
  tinycomments_author: 'Author name',
  image_title: true,
  automatic_uploads: true,
  files_picker_types: 'image',
  file_picker_callback: function(cb, value, meta) {
      var input = document.createElement('input');
      input.setAttribute('type', 'file');
      input.setAttribute('accept', 'image/*');

      input.onchange = function() {
      var file = this.files[0];
      var reader = new FileReader();
      
      reader.onload = function () {
          var id = 'blobid' + (new Date()).getTime();
          var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
          var base64 = reader.result.split(',')[1];
          var blobInfo = blobCache.create(id, file, base64);
          blobCache.add(blobInfo);

          // call the callback and populate the Title field with the file name
          cb(blobInfo.blobUri(), { title: file.name });
      };
      reader.readAsDataURL(file);
      };
      input.click();
  }
  });


// Ecoute les boutons suppression
var deleteButtons = document.querySelectorAll('.btnDelete');
var resolveButtons = document.querySelectorAll('.btnResolve');
var idToDelete = document.getElementById("idToDelete");
var idToResolve = document.getElementById("idToResolve");
var yesButtonDelete = document.getElementById("yesBtnD");
var yesButtonResolve = document.getElementById("yesBtnR");
if (deleteButtons) {
    // Ajout d'un evenement pour tous les bouttons suppression 'Oui'
    deleteButtons.forEach(
        e => {
        e.addEventListener('click', function () {
        console.log('idToSent', e.getAttribute('data-id'));
        if (idToDelete && yesButtonDelete) {
            idToDelete.setAttribute('value', e.getAttribute('data-id'));
        }
    })
});
};

if(resolveButtons){
    resolveButtons.forEach(
        e => {
        e.addEventListener('click', function () {
        console.log('idToSentResolve', e.getAttribute('data-id'));
        if (idToResolve && yesButtonResolve) {
            idToResolve.setAttribute('value', e.getAttribute('data-id'));
        }
    })
});
}

// Faire disparaitre la modal
var noButtons = document.querySelectorAll('.btnNo');
if(noButtons){
    noButtons.forEach(
        e => {
        e.addEventListener('click', function () {
        e.parentNode.parentNode.parentNode.classList.toggle('modal-hide');
    })
});
}