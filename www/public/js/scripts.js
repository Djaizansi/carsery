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


var id_page_supprimer;
var id_user;
var token;
var file;
var unId;
var idarticleresolve;

$(document).on("click", ".myBtn", function () {
id_page_supprimer = $(this).data('id');
token = $(this).data('token');
id_user = $(this).data('id');
idarticleresolve = $(this).data('id');
});

$(document).on("click", ".myBtn", function () {
  $('#id').val($(this).data('iduser'));
  $('#id_firstname').val($(this).data('prenom'));
  $('#id_lastname').val($(this).data('nom'));
  $('#id_email').val($(this).data('email'));
  $('#id_role').val($(this).data('role'));
});

$(document).on("click", ".unBtn", function () {
  $('#idtitre').val($(this).data('untitre'));
  $('#unId').val($(this).data('id'));
});

$('#btnAdd').click(function() {
});

$(document).on("click", ".file", function () {
file = $(this).data('file');
});

$('#btnYes').click(function() {
window.location.href = "/supprimer-page?id="+id_page_supprimer/* +"&token="+token */;
});

$('#btnYesUser').click(function() {
window.location.href = "/supprimer-user?id="+id_user;
});

$('#btnYesFile').click(function() {
window.location.href = "/supprimer-media?file="+file;
});

$('#btnYesResolve').click(function() {
window.location.href = "/forum/resolution-article?id="+idarticleresolve;
});

$('#btnYesSupprimer').click(function() {
window.location.href = "/forum/suppression-message?id="+idarticleresolve;
});


$(function(){
$('#btnNo').click(function(){
  $('#modal1').toggleClass('modal-hide')
})
})

$(function(){
$('#btnNo').click(function(){
  $('#modal3').toggleClass('modal-hide')
})
})

tinymce.init({
selector: "#myTextarea",
height: 500,
plugins: [
      "advlist autolink link image lists charmap print preview hr anchor pagebreak",
      "searchreplace wordcount visualblocks visualchars insertdatetime nonbreaking",
      "table contextmenu directionality emoticons paste textcolor code"
],
toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect | fontselect | fontsizeselect",
toolbar2: "| link unlink anchor | image | forecolor backcolor  | print preview code ",
font_formats: 'Arial=arial,helvetica,sans-serif; Courier New=courier new,courier,monospace; AkrutiKndPadmini=Akpdmi-n',
menu: {
  file: { title: 'File', items: 'newdocument restoredraft | preview | print ' },
  edit: { title: 'Edit', items: 'undo redo | cut copy paste | selectall | searchreplace' },
  view: { title: 'View', items: 'code | visualaid visualchars visualblocks | spellchecker | preview fullscreen' },
  insert: { title: 'Insert', items: 'image link media template codesample inserttable | charmap emoticons hr | pagebreak nonbreaking anchor toc | insertdatetime' },
  format: { title: 'Format', items: 'bold italic underline strikethrough superscript subscript codeformat | formats blockformats fontformats fontsizes align | forecolor backcolor | removeformat' },
  tools: { title: 'Tools', items: 'spellchecker spellcheckerlanguage | code wordcount' },
  table: { title: 'Table', items: 'inserttable | cell row column | tableprops deletetable' }
},
images_upload_url: '/test',
image_title: true,
file_picker_types: 'image',
image_class_list: [
  {title: 'Ajout', value: 'addslash'}
],
file_picker_callback: function (cb, value, meta) {
  tinymce.activeEditor.windowManager.openUrl({
    title: 'Bibliothéque',
    url: "/media"
  });
},
});

// Ecoute les boutons pour la suppression et marqué comme résolu
var deleteButtons = document.querySelectorAll('.btnDelete');
var resolveButtons = document.querySelectorAll('.btnResolve');
var idToDelete = document.getElementById("idToDelete");
var idToDeleteC = document.getElementById("idToDeleteC");
var idToResolve = document.getElementById("idToResolve");
var yesButtonDelete = document.getElementById("yesBtnD");
var yesButtonDeleteC = document.getElementById("yesBtnC");
var yesButtonResolve = document.getElementById("yesBtnR");
if (deleteButtons) {
  // Ajout d'un evenement pour tous les bouttons suppression 'Oui'
  deleteButtons.forEach(
      e => {
      e.addEventListener('click', function () {
      console.log('idToSent', e.getAttribute('data-id'));
      if(e.getAttribute('data-model') == "article"){
          if (idToDelete && yesButtonDelete) {
              idToDelete.setAttribute('value', e.getAttribute('data-id'));
          }
      } else {
          if (idToDeleteC && yesButtonDeleteC) {
              idToDeleteC.setAttribute('value', e.getAttribute('data-id'));
          }
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

// Affichage message et réponse mailbox
var messsageMailbox = document.querySelectorAll('.openMessageMailbox');
if(messsageMailbox){
  messsageMailbox.forEach(
      e => {
          e.addEventListener('click', function () {
              removeAllColoredDiv();
              e.firstElementChild.classList.add('messageOverviewColor');
              var allReadMessages = document.querySelectorAll('.messageToHide');
              if(allReadMessages){
                  hideAllReadMessage(allReadMessages);
              }
              var id = e.getAttribute('data-id');
              var messageDiv = document.querySelector('#message-' + id);
              if(messageDiv){
                  if(messageDiv.classList.contains('hide')){
                      messageDiv.classList.remove('hide');
                      messageDiv.classList.add('show');
                  } else {
                      messageDiv.classList.remove('show');
                      messageDiv.classList.add('hide');
                  }
              }
      })
  });
}

function hideAllReadMessage(readMessages) {
  if(readMessages){
      readMessages.forEach( e => {
          e.classList.remove('show');
          e.classList.add('hide');
      });
  }
}

function removeAllColoredDiv(){
  var divs = document.querySelectorAll('.removeColor');
  if(divs){
      divs.forEach(e => {
        e.classList.remove('messageOverviewColor');
      });
  }
}

// Fait disparaitre la div success apres 4 secondes
var success = document.querySelector('.success');
if(success){
  setTimeout(function () {
      success.classList.add('hide');
  }, 4000)
}
