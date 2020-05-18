window.onload = function() {
  var firebaseConfig = {
    apiKey: "AIzaSyDCqEaGyOikDZEihTCzTVPZS2c5IvIE5aU",
    authDomain: "register-6454b.firebaseapp.com",
    databaseURL: "https://register-6454b.firebaseio.com",
    projectId: "register-6454b",
    storageBucket: "register-6454b.appspot.com",
    messagingSenderId: "911585335407",
    appId: "1:911585335407:web:cfa0a85cc97f5b0329159a"
  };

  firebase.initializeApp(firebaseConfig);

  getSoftware();
  getCabinet();
  getSubjects();
}

const Software = {
  template:
    `
      <div>
        <div class='left-block'>
          <table border='1' class='po-table' id='software-table'>
            <tr>
              <td>№</td>
              <td>Имя</td>
              <td>Полное название</td>
              <td>Версия</td>
              <td>Лицензия</td>
            </tr>
          </table>
        </div>
        <div class='right-block'>
          <form class='po-form' onsubmit='addSoftware(); return false;' id='softwareForm'>
            <p class='form-title'>Добавить программное обеспечение</p>
            <input type='text' name='name' placeholder='Имя'>
            <input type='text' name='full_name' placeholder='Полное наименование'>
            <input type='text' name='version' placeholder='Версия'>
            <input type='text' name='license' placeholder='Лицензия'>
            <div class='license'>
              <input type='checkbox' onchange='change()' id='cb'>
              <p>Сроки лицензии</p>
            </div>
            <div class='license-date' id='hide' style='display: none;'>
              <p>с</p>
              <input type='date' name='time_start'>
              <p>по</p>
              <input type='date' name='time_end'>
            </div>
            <input type='button' value='Добавить' onclick='addSoftware()'>
          </form>
        </div>
      </div>
    `
}
const Cabinets = {
  template:
    `
      <div>
        <div class='left-block'>
          <table border='1' class='po-table' id='cabinet-table'>
            <tr>
              <td>№</td>
              <td>Номер</td>
              <td>Корпус</td>
              <td>Количество мест</td>
              <td>Доска</td>
              <td>Место преподавателя</td>
            </tr>
          </table>
        </div>
        <div class='right-block'>
          <form class='po-form' onsubmit='return false;' id='cabinetsForm'>
            <p class='form-title'>Добавить кабинет</p>
            <input type='text' name='number' placeholder='Номер'>
            <input type='text' name='housing' placeholder='Корпус'>
            <input type='text' name='number_seats' placeholder='Количество посадочных мест'>
            <div class='license'>
              <input type='checkbox' name='workplace' id='workplace-check' value='0'>
              <p>Рабочее место преподавателя</p>
            </div>
            <div class='license'>
              <input type='checkbox' name='board' id='board-check' value='0'>
              <p>Доска</p>
            </div>
            <input type='button' value='Добавить' onclick='addСabinet()'>
          </form>
        </div>
      </div>
    `
}
const Subjects = {
  template:
  `
    <div>
      <div class='left-block'>
        <table border='1' class='po-table' id='subject-table'>
          <tr>
            <td>№</td>
            <td>Название</td>
          </tr>
        </table>
      </div>
      <div class='right-block'>
        <form class='po-form' onsubmit='return false;' id='subjectsForm'>
          <p class='form-title'>Добавить предмет</p>
          <input type='text' name='title' placeholder='Название'>
          <input type='button' value='Добавить' onclick='addSubjects()'>
        </form>
      </div>
    </div>
  `
}
const Reports = {
  template:
  `
    <div>
      <form class='container-reports' onsubmit='return false;' id='reportsForm'>
        <select class='' name='subject'>
          <option disabled selected>Предмет</option>
          <option>1</option>
          <option>2</option>
        </select>
        <select class='' name='cabinet'>
          <option disabled selected>Кабинет</option>
          <option>1</option>
          <option>2</option>
        </select>
        <select class='' name='software'>
          <option disabled selected>Программное обеспечение</option>
          <option>1</option>
          <option>2</option>
        </select>
        <input type='button' value='Сформировать' onclick='createReport()'>
      </form>
    </div>
  `
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

$('#workplace-check').change(function() {
    $(this).val($(this).prop('checked')?1:0);
});

$('#board-check').change(function() {
    $(this).val($(this).prop('checked')?1:0);
});

function addSoftware() {
  let tmp = new FormData(document.getElementById("softwareForm")),
			data = {},
			onSend = true;

	tmp.forEach(function(value, key){
		if (value.length < 5) {
			onSend = false;
		}
	    data[key] = value;
	});

  let getLast = firebase.database().ref('software').limitToLast(1);
  getLast.once("value", function(resp){
    let lastID = (resp.val() === null) ? -1 : +Object.keys(resp.val())[0];
    pushItem(lastID + 1)
  });

  function pushItem(ID) {
    firebase.database().ref('software/').child(ID).set({
      id: ID,
      name: data.name,
      full_name: data.full_name,
      version: data.version,
      license: data.license,
      time_start: data.time_start,
      time_end: data.time_end,
    });
  };
}

function getSoftware() {
    firebase.database().ref('software').once('value', (val) => {
      software = val.val();
      for (i in software) {
        let ev = software[i];
        var tr = document.createElement('tr'),
            td1 = document.createElement('td'),
            td2 = document.createElement('td'),
            td3 = document.createElement('td'),
            td4 = document.createElement('td'),
            td5 = document.createElement('td'),
            softwareTable = document.getElementById('software-table');
        tr.append(td1, td2, td3, td4, td5);
        softwareTable.appendChild(tr);
        td1.innerText = ev.id;
        td2.innerText = ev.name;
        td3.innerText = ev.full_name;
        td4.innerText = ev.version;
        td5.innerText = ev.license;
      }
    })
}

function addСabinet() {
  let tmp = new FormData(document.getElementById("cabinetsForm")),
			data = {},
			onSend = true;

	tmp.forEach(function(value, key){
		if (value.length < 5) {
			onSend = false;
		}
	    data[key] = value;
      console.log(data)
	});
  
  let getLast = firebase.database().ref('cabinet').limitToLast(1);
  getLast.once("value", function(resp){
    let lastID = (resp.val() === null) ? -1 : +Object.keys(resp.val())[0];
    pushItem(lastID + 1)
  });
  let workplaceCheck = document.getElementById('workplace-check').value;
  let boardCheck = document.getElementById('board-check').value;

  function pushItem(ID) {
    firebase.database().ref('cabinet/').child(ID).set({
      id: ID,
      number: data.number,
      housing: data.housing,
      number_seats: data.number_seats,
      workplace: workplaceCheck,
      board: boardCheck,
    });
  }
}

function getCabinet() {
    firebase.database().ref('cabinet').once('value', (val) => {
      cabinet = val.val();
      for (i in cabinet) {
        let ev = cabinet[i];
        var tr = document.createElement('tr'),
            td1 = document.createElement('td'),
            td2 = document.createElement('td'),
            td3 = document.createElement('td'),
            td4 = document.createElement('td'),
            td5 = document.createElement('td'),
            td6 = document.createElement('td'),
            cabinetTable = document.getElementById('cabinet-table');
        tr.append(td1, td2, td3, td4, td5, td6);
        cabinetTable.appendChild(tr);
        td1.innerText = ev.id;
        td2.innerText = ev.number;
        td3.innerText = ev.housing;
        td4.innerText = ev.number_seats;
        td5.innerText = ev.board;
        td6.innerText = ev.workplace;
      }
    })
}

function addSubjects() {
  let tmp = new FormData(document.getElementById("subjectsForm")),
			data = {},
			onSend = true;

	tmp.forEach(function(value, key){
		if (value.length < 5) {
			onSend = false;
		}
	    data[key] = value;
	});
 
  let getLast = firebase.database().ref('subject').limitToLast(1);
  getLast.once("value", function(resp){
    let lastID = (resp.val() === null) ? -1 : +Object.keys(resp.val())[0];
    pushItem(lastID + 1)
  });

  function pushItem(ID) {
    firebase.database().ref('subject/').child(ID).set({
      id: ID,
      title: data.title,
    });
  }
}

function getSubjects() {
    firebase.database().ref('subject').once('value', (val) => {
      subject = val.val();
      for (i in subject) {
        let ev = subject[i];
        var tr = document.createElement('tr'),
            td1 = document.createElement('td'),
            td2 = document.createElement('td'),
            subjectTable = document.getElementById('subject-table');
        tr.append(td1, td2);
        subjectTable.appendChild(tr);
        td1.innerText = ev.id;
        td2.innerText = ev.title;
      }
    })
}

function createReport() {
  console.log(1);
}
