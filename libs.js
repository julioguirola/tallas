// avoid html injections

function escapeHtml(text) {
  const htmlEscapeTable = {
    "&": "&amp;",
    '"': "&quot;",
    "'": "&apos;",
    "<": "&lt;",
    ">": "&gt;",
  };
  return text.replace(/[&"'<]/g, (m) => htmlEscapeTable[m]);
}

//make sure Both fields must be filled out!

function validateLogin(){  
  try {
    pw = document.getElementById('id_1723').value;
    us = document.getElementById('email').value;

    if (pw == null || pw == "" || us == "" || us == null) {
      alert("Llene todos los campos");
    } else {
      $.post('login.php', {'pass': pw, 'email': us}, function (data){
        if (data == 'Ok'){
          location.replace('mainpage.html');
        } else {
          alert("Usuario o contraseña incorrecto");
        }
      })
    }

    return false;
  } catch (e){
    return false;
  }
}


function validateRegister(){  
  try {
    pw = document.getElementById('id_1723').value;
    us = document.getElementById('email').value;
    un = document.getElementById('uname').value;
    ac = document.getElementById('sum').value;

    newstr = '';
    for (let index = 0; index < ac.length; index++) {
      if (!newstr.includes(ac[index])){
        newstr += ac[index];
      }
    }


    if (pw == null || pw == "" || us == "" || us == null || un == "" || un == null || ac == "" || ac == null) {
      alert("Llene todos los campos");
    
    } else if (!us.includes('@gmail.com')) {
      alert("Ese correo no tine talla!");
    } else if (ac.length < 20 || newstr.length < 10) {
      alert("Ponga algo con más talla acerca de ti");
    } else {
      $.post('signup.php', {'email': us, 'pass': pw, 'uname': un, 'sum': ac},
        function (data){
          if (data == 'Ok'){
            alert('Su cuenta ha sido creada, q TALLA!');
            location.replace('mainpage.html');
          } else {
            alert('Correo ya en uso, please login!');
            location.replace('index.html');
          }
        }
      )
    }

    return false;
  } catch (e){
    return false;
  }

}

function publicate_content(){
  $('#user_name').empty();
  $('#users_tallosos').empty();
  $('#all_tallas').empty();

  $.getJSON('content.php', function (data){
    console.log(data);
    $('#user_name').html(data.user);
    $('#users_tallosos').html(data.users);
    $('#all_tallas').html(data.tallas);
  })
}

function cont_pub(){
  try {

    talla = document.getElementById('talla').value;
    bool = talla == "" || talla == null;
    if (!bool) {
      $.post('talla.php', {'talla': talla}, 
      function (data){
        publicate_content();
      })
      document.getElementById('talla').value = '';
    } 

    return false;
  } catch (e) {
    return false;
  }
}


function darlike(tallaid){
    $.post('likeness.php', {'tallaid': tallaid, 'likeness': 'like'},
    function (data){
      publicate_content();
    }
    )
}

function dardislike(tallaid){
  $.post('likeness.php', {'tallaid': tallaid, 'likeness': 'dislike'},
  function (data){
    publicate_content();
  }
  )
}

function who(){
  $.post('who.php', {'asd':"asd"},function (data){})
}
