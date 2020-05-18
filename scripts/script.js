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
  getDataReport();
}

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

function getDataReport() {
  firebase.database().ref('subject').once('value', (val) => {
      subject = val.val();
      for (i in subject) {
        let ev = subject[i];
        var option = document.createElement('option'),
            selectSubject = document.getElementById('selectSubject');
        selectSubject.appendChild(option);
        option.innerText = ev.title;
      }
    })
  firebase.database().ref('cabinet').once('value', (val) => {
      cabinet = val.val();
      for (i in cabinet) {
        let ev = cabinet[i];
        var option = document.createElement('option'),
            selectCabinet = document.getElementById('selectCabinet');
        selectCabinet.appendChild(option);
        option.innerText = ev.number;
      }
    })
  firebase.database().ref('software').once('value', (val) => {
      software = val.val();
      for (i in software) {
        let ev = software[i];
        var option = document.createElement('option'),
            selectSoftware = document.getElementById('selectSoftware');
        selectSoftware.appendChild(option);
        option.innerText = ev.name;
      }
    })
}
