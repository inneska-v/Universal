const swiper = new Swiper('.swiper-container', {
  // Optional parameters
  loop: true,

 autoplay: {
   delay: 5000,
 },

  // If we need pagination
  pagination: {
    el: '.swiper-pagination',
  },

});
// ..анимация меню
let menuToggle = $('.header-menu-toggle');
menuToggle.on('click', function(event) {
  event.preventDefault();
  $('.header-nav').slideToggle(200);
})


// Очистка всех текстовых полей при перезагрузке страницы
let inputTextElements = document.querySelectorAll("input[type=text]");
inputTextElements.forEach((el) => {
  el.value = "";
});

// Отправка формы Контакты
let contactsForm = $(".contacts-form");

contactsForm.on("submit", function (evt) {
  evt.preventDefault();
  let formData = new FormData(this);
  formData.append("action", "contacts_form");
  $.ajax({
    type: "POST",
    url: adminAjax.url,
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      console.log("Ответ сервера: " + response);
      contactsForm.trigger("reset");
    },
    error: function (data) {
      alert(data);
    },
  });
});