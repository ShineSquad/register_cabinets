/**
  Software:
    form:
      count(возрастание)
      name
      full_name
      version
      license
      time_start
      time_end
    table:
      [[--count--]]
      [[--name--]]
      [[--full_name--]]
      [[--version--]]
      [[--license--]]

  Сabinet:
    form:
      count(возрастание)
      number
      housing
      number_seats
      workplace
      board
    table:
      [[--count--]]
      [[--number--]]
      [[--housing--]]
      [[--number_seats--]]
      [[--workplace--]]
      [[--board--]]

    Subjects:
      form:
        count(возрастание)
        title
      table:
        [[--count--]]
        [[--title--]]
**/

const Software = {
  template: "<div><div class='left-block'><table border='1' class='po-table'><tr><td>№</td><td>Имя</td><td>Полное название</td><td>Версия</td><td>Лицензия</td></tr><tr style='display: none;'><td>[[--count--]]</td><td>[[--name--]]</td><td>[[--full_name--]]</td><td>[[--version--]]</td><td>[[--license--]]</td></tr></table></div><div class='right-block'><form class='po-form'><p class='form-title'>Добавить программное обеспечение</p><input type='text' name='name' placeholder='Имя'><input type='text' name='full_name' placeholder='Полное наименование'><input type='text' name='version' placeholder='Версия'><input type='text' name='license' placeholder='Лицензия'><div class='license'><input type='checkbox' onchange='change()' id='cb'><p>Сроки лицензии</p></div><div class='license-date' id='hide' style='display: none;'><p>с</p><input type='date' name='time_start'><p>по</p><input type='date' name='time_end'></div><input type='button' value='Добавить' onclick='addSoftware()'></form></div></div>"
}
const Cabinets = {
  template: "<div><div class='left-block'><table border='1' class='po-table'><tr><td>№</td><td>Номер</td><td>Корпус</td><td>Количество мест</td><td>Доска</td><td>Место преподавателя</td></tr><tr style='display: none;'><td>[[--count--]]</td><td>[[--number--]]</td><td>[[--housing--]]</td><td>[[--number_seats--]]</td><td>[[--board--]]</td><td>[[--workplace--]]</td></tr></table></div><div class='right-block'><form class='po-form'><p class='form-title'>Добавить кабинет</p><input type='text' name='number' placeholder='Номер'><input type='text' name='housing' placeholder='Корпус'><input type='text' name='number_seats' placeholder='Количество посадочных мест'><div class='license'><input type='checkbox' name='workplace'><p>Рабочее место преподавателя</p></div><div class='license'><input type='checkbox' name='board'><p>Доска</p></div><input type='button' value='Добавить' onclick='addСabinet()'></form></div></div>"
}
const Subjects = {
  template: "<div><div class='left-block'><table border='1' class='po-table'><tr><td>№</td><td>Название</td></tr><tr style='display: none;'><td>[[--count--]]</td><td>[[--title--]]</td></tr></table></div><div class='right-block'><form class='po-form'><p class='form-title'>Добавить предмет</p><input type='text' name='title' placeholder='Название'><input type='button' value='Добавить' onclick='addSubjects()'></form></div></div>"
}
const Reports = {
  template: "<form class='container-reports'><select class='' name='subject'><option disabled>Предмет</option><option></option><option></option></select><select class='' name='cabinet'><option disabled>Кабинет</option><option></option><option></option></select><select class='' name='software'><option disabled>Программное обеспечение</option><option></option><option></option></select><input type='button' value='Сформировать' onclick='createReport()'></form>"
}

var router = new VueRouter({
   routes: [
     { path: '/software', component: Software },
     { path: '/cabinets', component: Cabinets },
     { path: '/subjects', component: Subjects },
     { path: '/reports', component: Reports }
  ]
})

new Vue({
  el: '#app',
  router: router
})

function change() {
  if ($('#cb').is(':checked')){
  	$('#hide').css('display', 'block');
  } else {
  	$('#hide').css('display', 'none');
  }
}

function addSoftware() {
  console.log(1)
}

function addСabinet() {

}

function addSubjects() {

}

function createReport() {

}
