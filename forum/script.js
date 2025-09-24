function toggleVisibility(elementId) {
    const element = document.getElementById(elementId);
    if (element.style.display === "none" || element.style.display === "") {
        element.style.display = "flex"; // Show as flex (because of styling)
    } else {
        element.style.display = "none";
    }
}
function toggleForm(id) {
        const form = document.getElementById(`comment-form-${id}`);
        if (form.style.display === "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
function login_button() {
    // Hide the register form if it's visible
    document.getElementById('register-form').style.display = "none";
    // Toggle the login form
    toggleVisibility('login-form');
}

function register_button() {
    // Hide the login form if it's visible
    document.getElementById('login-form').style.display = "none";
    // Toggle the register form
    toggleVisibility('register-form');
}

function buttoncontrol() {
    const ad = document.getElementById('ad').value;
    const soyad = document.getElementById('soyad').value;
    const mail = document.getElementById('mail-register').value;
    const password = document.getElementById('password-register').value;
    const kullanıcı_ad = document.getElementById('kullanıcı_ad').value;

    const button = document.getElementById('kayıtbuton');

    if (ad && soyad && mail && password.length >= 6 && kullanıcı_ad.length >= 4) {
        button.disabled = false;
    } else {
        button.disabled = true;
    }
}


function toggleEntryText(){
    const div = document.getElementById('entry-text');
    if(div.style.display === "none" || div.style.display === "") {

        div.style.display = "block"
    }
    else {

        div.style.display = "none"
    }



}
function storyTitle() {
    const titlediv = document.getElementById('userTitle'); // Div'i seçiyoruz.
    const secim = document.getElementById('hikaye'); // Select elemanını seçiyoruz.

    if (secim.value === 'hikaye') { // Seçili değeri kontrol ediyoruz.
        titlediv.style.display = 'block'; // Div'i görünür yapıyoruz.
    } else {
        titlediv.style.display = 'none'; // Eğer başka bir şey seçilirse gizliyoruz.
    }
}

window.onload = function() {
    // Hide both forms initially
    document.getElementById('login-form').style.display = 'none';
    document.getElementById('register-form').style.display = 'none';
};
