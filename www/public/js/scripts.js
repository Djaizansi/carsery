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

$(document).on("click", ".myBtn", function () {
  id_page_supprimer = $(this).data('id');
  token = $(this).data('token');
  id_user = $(this).data('id');
});

$(document).on("click", ".myBtn", function () {
  $('#id').val($(this).data('iduser'));
  $('#id_firstname').val($(this).data('prenom'));
  $('#id_lastname').val($(this).data('nom'));
  $('#id_email').val($(this).data('email'));
  $('#id_role').val($(this).data('role'));
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


$(function(){
  $('#btnNo').click(function(){
    $('#modal1').toggleClass('modal-hide')
  })
})




const mceElf = new tinymceElfinder({
  // connector URL (Set your connector)
  url: 'php/connector.minimal.php',
  // upload target folder hash for this tinyMCE
  uploadTargetHash: 'l1_lw', // Hash value on elFinder of writable folder
  // elFinder dialog node id
  nodeId: 'elfinder' // Any ID you decide
});


tinymce.init({
  selector: "#myTextarea",
  height: 300,
  plugins: [
        "advlist autolink link image lists charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars insertdatetime nonbreaking",
        "table contextmenu directionality emoticons paste textcolor code"
  ],
  toolbar1: "undo redo | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | styleselect",
  toolbar2: "| link unlink anchor | image | forecolor backcolor  | print preview code ",
  menubar: "insert",
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

  /* file_picker_callback: function (cb, value, meta) {
    tinymce.activeEditor.windowManager.openUrl({
      title: 'Bibliothéque',
      url: "/media"
    });
    var FileBrowserDialogue = {
      init : function () {
          // Here goes your code for setting your custom things onLoad.
      },
      sendURL : function (URL) {
          var win = tinyMCEPopup.getWindowArg("window");
  
          // insert information now
          win.document.getElementById(tinyMCEPopup.getWindowArg("input")).value = URL;
  
          // are we an image browser
          if (typeof(win.ImageDialog) != "undefined")
          {
              // we are, so update image dimensions and preview if necessary
              if (win.ImageDialog.getImageData) win.ImageDialog.getImageData();
              if (win.ImageDialog.showPreviewImage) win.ImageDialog.showPreviewImage(URL);
          }
  
          // close popup window
          tinyMCEPopup.close();
      }
  } */

 /*  }); */
/* 
tinymce.init({
  selector: '#myTextarea',
  height: 300,
  plugins: 'a11ychecker advcode casechange formatpainter linkchecker autolink lists checklist media mediaembed pageembed permanentpen powerpaste table advtable tinycomments tinymcespellchecker image',
  toolbar: 'a11ycheck addcomment showcomments casechange checklist code formatpainter pageembed permanentpen table image',
  images_upload_url: '/test',
  toolbar_mode: 'floating',
  tinycomments_mode: 'embedded',
  tinycomments_author: 'Author name',
  image_title: true,
  automatic_uploads: true,
  }); */

  