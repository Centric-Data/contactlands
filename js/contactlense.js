console.log('Contact Form Loaded');

const form = document.querySelector('#cf_form')
const sendBtn = document.querySelector('#cf_submit')
const msgNotify = document.querySelector('#msg_notify')

sendBtn.addEventListener( 'click', (e) => {
  e.preventDefault();

  let fullname = form['fullname'].value;
  let phone = form['phone'].value;
  let message = form['message'].value;

  if ( fullname === "" || phone === "" || message === "" ) {
    msgNotify.style.color = 'red';
    msgNotify.textContent = 'Message not sent, fill all gaps';
  } else {
    setTimeout( () =>{
      msgNotify.style.color = 'green';
      msgNotify.textContent = 'Message sent!';
    }, 1000 )
    setTimeout( () => {
      msgNotify.textContent = '';
    }, 3000 )
  }

} )
